<?php

namespace App\Filters;

use App\Filters\Filter;

class PromoPlanFilter extends Filter {

    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('name', 'ilike', '%' . $search . '%');
                });
    }

}
