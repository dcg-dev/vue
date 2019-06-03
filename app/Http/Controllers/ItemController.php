<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Storage;
use Kryptonit3\Counter\Facades\CounterFacade as Counter;

class ItemController extends Controller
{

    use Api\ItemController;

    public function search()
    {
        return view('item.search', [
            'category' => false
        ]);
    }

    public function featured()
    {
        return view('item.featured');
    }

    public function listView()
    {
        return view('item.list');
    }

    public function createView()
    {
        return view('item.create');
    }

    public function view(Item $item)
    {
        $this->canView($item);
        Counter::count('user.item', $item->creator->username);
        return view('item.view', [
            'item' => $item
        ]);
    }

    public function editView(Item $item)
    {
        return view('item.edit', [
            'item' => $item
        ]);
    }

    public function itemFavourites()
    {
        return view('item.favourites');
    }

    public function downloadDemo(Item $item)
    {
        return $this->download($item->getDemoPath(), $item->slug);
    }

    public function downloadProduct($slug)
    {
        $item = Item::withTrashed()->where('slug', $slug)->firstOrFail();

        if (!$item->getProductPath() || !$this->availabilityDownload($item, $this->user())) {
            abort(404);
        }
        return $this->download($item->getProductPath(), $item->slug);
    }

    protected function download($path, $name = false)
    {
        if (!Storage::disk('s3')->exists($path)) {
            abort(404);
        }
        $metadata = Storage::disk('s3')->getDriver()->getMetadata($path);
        $content = Storage::disk('s3')->get($path);
        $response = response($content, 200, [
            'Content-Type' => $metadata['mimetype'],
            'Content-Length' => $metadata['size'],
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename=" . ($name ? $name . "." . $metadata['extension'] : $metadata['basename']),
//            'Content-Transfer-Encoding' => 'binary',
        ]);
        ob_end_clean();
        return $response;
    }

    /**
     * Check availability to download product.
     *
     * @param Item $item
     * @param User $user
     * @return bool
     */
    private function availabilityDownload($item, $user)
    {
        return
            $this->user()->isAdmin() ||
            $item->creator_id == $user->id ||
            OrderItem::with('order')
                ->where('item_id', $item->id)
                ->where(function ($query) {
                    $query->where('status', OrderItem::STATUS_PAID)
                        ->orWhere('stripe_status', OrderItem::STATUS_PAID);
                })
                ->whereHas('order', function ($query) use ($user) {
                    $query->where('customer_id', $user->id);
                })
                ->first() ||
            $item->price == 0;
    }

}
