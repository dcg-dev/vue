<?php

namespace App\Filters;

use App\Filters\Filter;

class UserFilter extends Filter {

    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('username', 'ilike', '%' . $search . '%');
                });
    }
}
