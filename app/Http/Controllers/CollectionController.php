<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Kryptonit3\Counter\Facades\CounterFacade as Counter;

class CollectionController extends Controller
{

    use Api\CollectionController;

    public function view(Collection $collection)
    {
        Counter::count('user.collection', $collection->creator->username);
        return view('collection.view', [
            'collection' => $collection
        ]);
    }

    public function top()
    {
        return view('collection.top');
    }
}
