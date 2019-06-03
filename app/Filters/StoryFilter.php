<?php

namespace App\Filters;

use App\Filters\Filter;

class StoryFilter extends Filter {

    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('title', 'ilike', '%' . $search . '%')
                            ->orWhere('sub_title', 'ilike', '%' . $search . '%');
                });
    }

}
