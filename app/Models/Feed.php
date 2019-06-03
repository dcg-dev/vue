<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Models\Item;
use App\Models\User;

class Feed
{

    protected $user_id;
    protected $request;
    public $perPage = 20;

    public function __construct($user_id, Request $request)
    {
        $this->user_id = $user_id;
        $this->request = $request;
    }

    public function setPerPage($value)
    {
        $this->perPage = $value;
    }

    public function query()
    {
        $users = DB::table('items')
            ->where('status', 2)
            ->whereIn('creator_id', DB::table('followers')
                ->select('follow_id')
                ->whereRaw("user_id = $this->user_id"));
        $collections = DB::table('items')
            ->where('status', 2)
            ->whereIn('id', DB::table('collection_items')
                ->select('item_id')
                ->whereIn('collection_id', DB::table('collection_followers')
                    ->select('collection_id')
                    ->whereRaw("user_id = $this->user_id")))
            ->union($users);
        $querySql = $collections->toSql();
        $query = DB::table(DB::raw("($querySql) as items"))->mergeBindings($collections);
        $this->filters($query);
        return $query;
    }

    public function all()
    {
        $query = $this->query();
        $results = $query->paginate($this->perPage);
        $results->setCollection(Item::fromQuery($query->toSql(), $query->getBindings()));
        return $results;
    }

    public function count()
    {
        $query = $this->query();
        return $query->count();
    }

    public function max($attribute)
    {
        $query = $this->query();
        return $query->max($attribute);
    }

    protected function filters(Builder &$query)
    {
        $params = $this->request->all();
        if ($params) {
            foreach ($params as $key => $value) {
                if (method_exists($this, $key)) {
                    $this->{$key}($value, $query);
                }
            }
        }
    }

    protected function q($value, Builder &$query)
    {
        $query->where('name', 'ilike', '%' . $value . '%');
    }

    protected function category($value, Builder &$query)
    {
        $ids = Category::where('procreator_id', $value)->select('id')->pluck('id')->all();
        $db = DB::table('item_categories')->selectRaw('count(id)')->whereIn('category_id', $ids)->whereRaw('item_id=items.id');
        $query->whereRaw("(" . $db->toSql() . ") > 0");
        $query->mergeBindings($db);
    }

    protected function author($value, Builder &$query)
    {
        $query->where('creator_id', $value);
    }

    protected function order($value, Builder &$query)
    {
        if (is_array($value)) {
            foreach ($value as $order) {
                $this->orderParse($order, $query);
            }
            return $this;
        } else {
            return $this->orderParse($value, $query);
        }
    }

    protected function orderParse($line, $query)
    {
        if ($line == 'popular') {
            $query->orderBy('count_sales', 'desc');
            $query->orderBy('rating', 'desc');
            $query->orderBy('count_rating', 'desc');
            $query->orderBy('created_at', 'desc');
            return $query;
        } else {
            $result = explode("|", $line);
            if (count($result) == 1) {
                $result[1] = 'asc';
            }
            if ($result[1] == 'asc') {
                $result[1] = 'asc';
            } else {
                $result[1] = 'desc';
            }
            return $query->orderBy($result[0], $result[1]);
        }
    }

}
