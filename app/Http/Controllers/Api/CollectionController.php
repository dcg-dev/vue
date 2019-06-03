<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CollectionUpdated;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\CollectionCreated;
use App\Http\Requests\CollectionAttach;
use App\Models\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait CollectionController
{

    public function get(Collection $collection)
    {
        return $collection;
    }

    /**
     * Returns the collection items
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        return Collection::filter($request->all())->where('private', false)->paginate(\Setting::get('pagination.collections') ?: $request->get('per_page', 8));
    }

    /**
     * Returns the collection items
     *
     * @return \Illuminate\Http\Response
     */
    public function items(Collection $collection, Request $request)
    {
        return $collection->items()->filter($request->all())->paginate(\Setting::get('pagination.items.collection') ?: $request->get('per_page', 8));
    }

    public function create(CollectionCreated $request)
    {
        $data = $request->only(['name', 'description']);
        $collection = new Collection();
        $collection->fill($data);
        $collection->creator_id = $this->user()->id;
        $collection->saveOrFail();
        return $collection;
    }

    public function update(Collection $collection, CollectionUpdated $request)
    {
        if ($collection->creator_id != $this->user()->id) {
            abort(403);
        }
        $data = $request->intersect(['name']);
        $collection->fill($data);
        $collection->saveOrFail();
        return $collection;
    }

    public function delete(Collection $collection)
    {
        return [
            'status' => $collection->delete()
        ];
    }

    public function attach(Collection $collection, CollectionAttach $request)
    {
        if ($this->hasItem($collection, $request->get('item'))) {
            return ['status' => false];
        }
        $collection->items()->attach($request->get('item'));
        $collection->recalculateItems();
        $collection->save();
        return [
            'collection' => $collection,
            'status' => true
        ];
    }

    public function detach(Collection $collection, CollectionAttach $request)
    {
        if ($this->hasItem($collection, $request->get('item'))) {
            abort(403, 'This item is not in the collection.');
        }
        $collection->items()->detach($request->get('item'));
        $collection->recalculateItems();
        $collection->save();
        return $collection;
    }

    protected function hasItem($collection, $id)
    {
        return (bool)$collection->items()->where('item_id', $id)->count();
    }

    /**
     * Follow user action
     *
     * @return \App\Models\Collection
     */
    public function follow(Collection $collection)
    {
        $has = $collection->followers()->where('user_id', $this->user()->id)->count();
        if (!$has) {
            $collection->followers()->attach($this->user()->id);
        } else {
            $collection->followers()->detach($this->user()->id);
        }
        $collection->recalculateFollowers();
        $collection->save();
        return Collection::find($collection->id);
    }

}
