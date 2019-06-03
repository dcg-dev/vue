<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Requests\ItemDecline;
use App\Models\Item;
use App\Http\Requests\AdminItemCreate;
use App\Http\Requests\AdminItemUpdate;
use App\Http\Requests\ItemThumbnail;
use App\Http\Requests\ItemAudio;
use App\Http\Requests\ItemArchive;
use Carbon\Carbon;

trait ItemController
{

    /**
     * Return all items requests in json
     *
     * @return \Illuminate\Http\Response
     */
    public function getItems(Request $request)
    {
        return Item::filter($request->all())
            ->paginate($request->get('per_page', 20));
    }

    /**
     * Return all comments requests in json
     *
     * @return \Illuminate\Http\Response
     */
    public function getComments(Request $request)
    {
        return Comment::filter($request->all())
            ->paginate($request->get('per_page', 20));
    }

    /**
     * Return all review requests in json
     *
     * @return \Illuminate\Http\Response
     */
    public function getRatings(Request $request)
    {
        return Rating::filter($request->all())
            ->paginate($request->get('per_page', 20));
    }

    /**
     * Approve the item
     *
     * @return \Illuminate\Http\Response
     */
    public function approve(Item $item)
    {
        $item->status = 2;
        if (!$item->approved_at) {
            $item->approved_at = Carbon::now();
        }
        $item->saveOrFail();
        return $item;
    }

    /**
     * Decline the item
     *
     * @return \Illuminate\Http\Response
     */
    public function decline(Item $item, ItemDecline $request)
    {
        $item->status = 3;
        $item->decline_reason = $request->get('reason');
        $item->saveOrFail();
        return $item;
    }

    /**
     * Delete item
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Item $item)
    {
        return [
            'status' => $item->delete()
        ];
    }

    /**
     * Delete comment
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteComment(Comment $comment)
    {
        return [
            'status' => $comment->delete()
        ];
    }

    /**
     * Delete rating
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteRating(Rating $rating)
    {
        return [
            'status' => $rating->delete()
        ];
    }

    /**
     * Create new item
     *
     * @param AdminItemCreate $request
     *
     * @return Item
     */
    public function create(AdminItemCreate $request)
    {
        $data = $request->only(['name', 'description', 'featured', 'creator_id']);
        $item = new Item();
        $item->creator_id = $this->user()->id;
        $item->fill($data);
        $item->saveOrFail();
        $item->syncCategories($request->get('categoriesIds', []));
        $item->syncTags($request->get('tagsIds', []));
        return $item;
    }

    /**
     * Update the item
     *
     * @param UserUpdate $request
     *
     * @return Item
     */
    public function update(Item $item, AdminItemUpdate $request)
    {
        $data = $request->only(['name', 'slug', 'description', 'status', 'decline_reason', 'need_follow',
            'price', 'loopable', 'includes_stems', 'featured', 'creator_id']);
        $item->fill($data);
        $item->fill($request->get('files'));
        if (!$item->approved_at) {
            $item->approved_at = $request->get('status') == 2 ? Carbon::now() : null;
        }
        if ($request->get('approved_at')) {
            $item->approved_at = Carbon::createFromTimestamp($request->get('approved_at'));
        }
        $item->saveOrFail();
        $item->syncCategories($request->get('categoriesIds', []));
        $item->categoriesIds = $item->categories()->get();
        $item->syncTags($request->get('tagsIds', []));
        $item->tagsIds = $item->tags()->get();
        $item->syncLicenses($request->get('licensesIds', []));
        if ($request->get('formatsIds', false)) {
            $item->syncFormats($request->get('formatsIds', []));
        }
        $item->licensesIds = $item->licenses()->get();
        return $item;
    }

    /**
     * Update the comment
     *
     * @param Comment $comment
     * @param Request $request
     *
     * @return Item
     */
    public function updateComment(Comment $comment, Request $request)
    {
        $comment->fill($request->only(['message']));
        $comment->saveOrFail();
        return $comment;
    }

    /**
     * Update the rating
     *
     * @param Comment $comment
     * @param Request $request
     *
     * @return Item
     */
    public function updateRating(Rating $rating, Request $request)
    {
        $rating->fill($request->only(['review']));
        $rating->saveOrFail();
        return $rating;
    }

    /**
     * Update the item image
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadThumbnail(Item $item, ItemThumbnail $request)
    {
        $item->setThumbnail($request->file('image'), 'image');
        $item->saveOrFail();
        return $item;
    }

    /**
     * Update the item demo
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadDemo(Item $item, ItemAudio $request)
    {
        $item->setFile($request->file('demo'), 'demo');
        $item->saveOrFail();
        return $item;
    }

    /**
     * Update the item demo
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadProduct(Item $item, ItemArchive $request)
    {
        $item->setFile($request->file('product'), 'file');
        $item->saveOrFail();
        return $item;
    }

}
