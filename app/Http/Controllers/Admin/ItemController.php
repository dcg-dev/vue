<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;

class ItemController extends Controller
{

    use Api\ItemController;

    /**
     * Show list of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function items()
    {
        return view('admin.item.list');
    }

    /**
     * Show list of the comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function comments()
    {
        return view('admin.item.comment.list');
    }

    /**
     * Show list of the ratings.
     *
     * @return \Illuminate\Http\Response
     */
    public function ratings()
    {
        return view('admin.item.rating.list');
    }

    /**
     * Show form to edit the item.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEdit(Item $item)
    {
        return view('admin.item.edit', ['item' => $item]);
    }

    /**
     * Show form to create an item.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate()
    {
        return view('admin.item.create');
    }

}
