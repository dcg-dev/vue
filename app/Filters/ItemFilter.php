<?php

namespace App\Filters;

use Illuminate\Support\Facades\DB;
use App\Filters\Filter;
use App\Models\Category;

class ItemFilter extends Filter
{

    public function noids($ids)
    {
        if (is_array($ids)) {
            $this->whereNotIn('id', $ids);
        } else {
            $this->where('id', '!=', $ids);
        }
    }

    public function q($search)
    {
        return $this->where(function ($q) use ($search) {
            return $q->where('name', 'ilike', '%' . $search . '%')
                ->orWhere('description', 'ilike', '%' . $search . '%')
                ->orWhere('slug', 'ilike', '%' . $search . '%')
                ->orWhereHas('creator', function ($query) use ($search) {
                    $query->where('username', 'ilike', '%' . $search . '%');
                });
        });
    }

    public function status($value)
    {
        return $this->where('status', (int)$value);
    }

    public function price($value)
    {
        $range = explode("|", $value);
        if (count($range) == 2) {
            return $this->whereBetween('price', $range);
        }
        return $this->where('price', (float)$value);
    }

    public function rating($value)
    {
        return $this->where('rating', (int)$value);
    }

    public function formats($ids)
    {
        $db = DB::table('item_formats')->selectRaw('count(id)')->whereIn('format_id', $ids)->whereRaw('item_id=items.id');
        $this->mergeBindings($db);
        return $this->whereRaw("(" . $db->toSql() . ") > 0");
    }

    public function tags($ids)
    {
        $db = DB::table('item_tags')->selectRaw('count(id)')->whereIn('tag_id', $ids)->whereRaw('item_id=items.id');
        $this->mergeBindings($db);
        return $this->whereRaw("(" . $db->toSql() . ") > 0");
    }

    public function categories($value)
    {
        $ids = Category::whereIn('procreator_id', $value)->select('id')->pluck('id')->all();
        $ids = array_merge(array_map(function ($value) {
            return (int)$value;
        }, $value), $ids);
        $db = DB::table('item_categories')->selectRaw('count(id)')->whereIn('category_id', $ids)->whereRaw('item_id=items.id');
        $this->mergeBindings($db);
        return $this->whereRaw("(" . $db->toSql() . ") > 0");
    }

    protected function orderParse($line)
    {
        switch ($line) {
            case 'latest':
                $this->orderBy('approved_at', 'desc');
                return $this;
            case 'popular':
                $this->orderBy('count_sales', 'desc');
                $this->orderBy('rating', 'desc');
                $this->orderBy('count_rating', 'desc');
                $this->orderBy('approved_at', 'desc');
                return $this;
            default:
                return parent::orderParse($line);
        }
    }

}
