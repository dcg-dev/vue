<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class TagFilter extends ModelFilter {

    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('name', 'ilike', '%' . $search . '%');
                });
    }

}
