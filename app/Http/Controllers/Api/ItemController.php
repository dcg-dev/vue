<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ItemCreate;
use App\Http\Requests\ItemEdit;
use App\Http\Requests\ItemThumbnail;
use App\Http\Requests\ItemAudio;
use App\Http\Requests\ItemArchive;
use App\Http\Requests\ItemCommented;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait ItemController {

    /**
     * Returns the all active items
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request) {
        return Item::filter($request->all())
                        ->where('status', 2)
                        ->with(['creator' => function ($query) {
                                $query->select(['id', 'firstname', 'lastname', 'username', 'avatar']);
                            }])
                        ->paginate($request->get('per_page', 5));
    }

    /**
     * Returns the all active items
     *
     * @return \Illuminate\Http\Response
     */
    public function max($attribute, Request $request) {
        return Item::filter($request->all())
                        ->where('status', 2)
                        ->max($attribute);
    }

    /**
     * Returns the all featured items
     *
     * @return \Illuminate\Http\Response
     */
    public function featuredList(Request $request) {
        return Item::filter($request->all())
                        ->with(['promo' => function ($query) {
                                $query->select(['ends_at']);
                            }, 'creator' => function ($query) {
                                $query->select(['id', 'firstname', 'lastname', 'username']);
                            }])
                        ->where(function ($query) {
                            $query->where('featured', true)
                            ->orWhereHas('promo', function ($query) {
                                $query->where('ends_at', '>', DB::raw('NOW()'));
                            });
                        })
                        ->where('status', 2)
                        ->inRandomOrder()
                        ->paginate($request->get('per_page', \Setting::get('pagination.user.featured', 9)));
    }

    /**
     * Returns the my items
     *
     * @return \Illuminate\Http\Response
     */
    public function my(Request $request) {
        return $this->user()
                        ->items()
                        ->filter($request->all())
                        ->with(['active_promo', 'creator' => function ($query) {
                                $query->select(['id', 'firstname', 'lastname', 'username']);
                            }])
                        ->orderBy('created_at', 'desc')
                        ->paginate($request->get('per_page', 10));
    }

    /**
     * Returns the my items
     *
     * @return \Illuminate\Http\Response
     */
    public function userItems(User $user, Request $request) {
        return $user->items()
                        ->filter($request->all())
                        ->where('status', 2)
                        ->with(['creator' => function ($query) {
                                $query->select(['id', 'firstname', 'lastname', 'username']);
                            }])
                        ->orderBy('created_at')
                        ->paginate(\Setting::get('pagination.items.user') ?: $request->get('per_page', 5));
    }

    /**
     * Returns the item
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Item $item) {
        $this->canView($item);
        $item->boughtLicenses = $this->getBoughtLicenses($item);
        return $item;
    }

    /**
     * Get bought item licenses
     *
     * @param Item $item
     *
     * @return array
     */
    public function getBoughtLicenses(Item $item) {
        $boughtLicenses = [];
        if ($user = $this->user()) {
            $itemLicenses = $item->licenses()->pluck('licenses.id')->all();
            $boughtLicenses = OrderItem::where('item_id', $item->id)
                            ->where('status', OrderItem::STATUS_PAID)
                            ->whereHas('order', function ($query) use ($user) {
                                $query->where('customer_id', $user->id);
                            })
                            ->whereIn('license_id', $itemLicenses)->get()->pluck('license_id');
        }
        return $boughtLicenses;
    }

    /**
     * Returns the item comments
     *
     * @return \Illuminate\Http\Response
     */
    public function comments(Item $item, Request $request) {
        $this->canView($item);
        return $item->comments()->filter($request->all())->paginate($request->get('per_page', 5));
    }

    /**
     * Returns the item ratings
     *
     * @return \Illuminate\Http\Response
     */
    public function ratings(Item $item, Request $request) {
        $this->canView($item);
        return $item->ratings()->filter($request->all())->paginate($request->get('per_page', 5));
    }

    /**
     * Returns the item comments
     *
     * @return \Illuminate\Http\Response
     */
    public function commented(Item $item, ItemCommented $request) {
        $item->comments()->create([
            'message' => $request->get('message'),
            'sender_id' => $this->user()->id,
            'likes' => 0
        ]);
        return $this->comments($item, $request);
    }

    /**
     * Creates new item
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ItemCreate $request) {
        $maxProducts = 5;
        if ($this->user()->subscription('main') &&
                $plan = \App\Models\Plan::where('stripe_id', $this->user()->subscription('main')->stripe_plan)->first()) {
            $maxProducts = $plan->products;
        }
        if (!$this->user()->isAdmin() && $this->user()->items->count() >= $maxProducts) {
            throw new BadRequestHttpException("Sorry, you can not create the item until you don't reduce your items quantity to the required.");
        }
        $data = $request->only(['name', 'description']);
        $item = new Item();
        $item->fill($data);
        $item->creator_id = $this->user()->id;
        $item->saveOrFail();
        $item->syncCategories($request->get('categoriesIds', []));
        $item->syncTags($request->get('tagsIds', []));
        $item->status = 0;
        return $item;
    }

    /**
     * Update the item
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Item $item, ItemEdit $request) {
        $data = \Illuminate\Support\Arr::only($request->all(), ['name', 'description', 'price', 'loopable', 'includes_stems', 'free', 'need_follow']);
        $item->fill($data);
        if ($request->get('categoriesIds', false)) {
            $item->syncCategories($request->get('categoriesIds', []));
        }
        if ($request->get('tagsIds', false)) {
            $item->syncTags($request->get('tagsIds', []));
        }
        if ($request->get('formatsIds', false)) {
            $item->syncFormats($request->get('formatsIds', []));
        }
        if ($request->get('licensesIds', false)) {
            $item->syncLicenses($request->get('licensesIds', []));
        }
        $item->status = 0;
        $item->saveOrFail();
        return $item;
    }

    /**
     * Update the item thumbnail
     *
     * @return \Illuminate\Http\Response
     */
    public function thumbnail(Item $item, ItemThumbnail $request) {
        $item->setThumbnail($request->file('image'), 'image');
        $item->status = 0;
        $item->saveOrFail();
        return $item;
    }

    /**
     * Update the item demo
     *
     * @return \Illuminate\Http\Response
     */
    public function demo(Item $item, ItemAudio $request) {
        $item->setFile($request->file('demo'), 'demo');
        $item->status = 0;
        $item->saveOrFail();
        return $item;
    }

    /**
     * Update the item demo
     *
     * @return \Illuminate\Http\Response
     */
    public function product(Item $item, ItemArchive $request) {
        $item->setFile($request->file('product'), 'file');
        $item->status = 0;
        $item->saveOrFail();
        return $item;
    }

    /**
     * Publish the item
     *
     * @return \Illuminate\Http\Response
     */
    public function publish(Item $item) {
        $validator = Validator::make($item->getAttributes(), [
                    'name' => 'required|string|min:3|max:50',
                    'description' => 'nullable|max:5000',
                    'demo' => 'required',
                    'file' => 'required',
                    'image' => 'required',
                    'price' => 'numeric|min:0|max:9999',
                ])->validate();
        $item->status = 1;
        $item->saveOrFail();
        return $item;
    }

    /**
     * Add to favourite
     *
     * @return \Illuminate\Http\Response
     */
    public function favourite(Item $item) {
        $item->favourite();
        return Item::find($item->id);
    }

    /**
     * Add rating.
     *
     * @return \Illuminate\Http\Response
     */
    public function addRating(Item $item, Request $request) {
        $rating = Rating::where([
                    'item_id' => $item->id,
                    'creator_id' => $this->user()->id
                ])->first();

        if (!$rating) {
            $item->ratings()->create([
                'item_id' => $item->id,
                'creator_id' => $this->user()->id,
                'review' => $request->get('review'),
                'rating' => $request->get('rating')
            ]);
        }

        return $item->ratings()->where('creator_id', $this->user()->id)->get();
    }

    /**
     * @param $item
     * @return bool
     */
    public function canView($item) {
        $user = $this->user();
        if ($item->status == 2 || ($user && ($user->id === $item->creator_id || $user->isAdmin()))) {
            return true;
        }
        abort(403, 'You do not have access to this item.');
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id) {
        $item = Item::findOrFail($id);

        if (OrderItem::where('item_id', $item->id)->get()->count() > 0) {
            $item->delete();
        } else {
            $files = Storage::disk('s3')->files($item->getDirectoryAttribute(false));
            $matchingFiles = preg_grep('/^public\/users\/' . $this->user()->id . '\/items\/' . $id . '/', $files);
            Storage::disk('s3')->delete($matchingFiles);
            $item->forceDelete();
        }

        return [
            'success' => true
        ];
    }

    public function generateAffilateLink(Request $request) {
        try {
            $link = parse_url($request->get('link'));
            $error = false;
            if ($request->root() != $link['scheme'] . '://' . $link['host'] || !preg_match("/^\/item\/([\w|\d|\-]+)/i", $link['path'], $id)) {
                throw new BadRequestHttpException("Item link is invalid, probabaly it's neither url, or from this site.");
            }
            $id = $id[1];
            $item = Item::where('slug', $id)->first();
            if (!$item) {
                throw new BadRequestHttpException('The requested item was not found in the system.');
            }
            if ($item->creator_id == $request->user()->id) {
                throw new BadRequestHttpException('You can not use your items.');
            }
            return URL::route('item', ['item' => $item, 'ref' => $request->user()->username]);
        } catch (\Exception $ex) {
            return response($ex->getMessage(), 422);
        }
    }

}
