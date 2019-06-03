<?php

namespace App\Filters;

use App\Filters\Filter;

class RatingFilter extends Filter {

    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('review', 'ilike', '%' . $search . '%');
                });
    }

}
