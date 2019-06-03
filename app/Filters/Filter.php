<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class Filter extends ModelFilter {

    public function relations($relations) {
        if (is_array($relations)) {
            foreach ($relations as $relation) {
                $this->with($relation);
            }
            return $this;
        } else {
            return $this->with($relation);
        }
    }

    public function order($search) {
        if (is_array($search)) {
            foreach ($search as $order) {
                $this->orderParse($order);
            }
            return $this;
        } else {
            return $this->orderParse($search);
        }
    }

    protected function orderParse($line) {
        $result = explode("|", $line);
        if (count($result) == 1) {
            $result[1] = 'asc';
        }
        if ($result[1] == 'asc') {
            $result[1] = 'asc';
        } else {
            $result[1] = 'desc';
        }
        return $this->orderBy($result[0], $result[1]);
    }

}
