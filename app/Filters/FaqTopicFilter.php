<?php

namespace App\Filters;

use App\Filters\Filter;

class FaqTopicFilter extends Filter {

    public function q($search) {
        return $this->where(function($q) use ($search) {
                    return $q->where('question', 'ilike', '%' . $search . '%')
                             ->orWhere('answer', 'ilike', '%' . $search . '%');
                });
    }
    
    public function filter($value) {
        return $this->where(function($q) use ($value) {
                    return $q->where('types', 'ilike', '%' . $value . '%');
                });
    }
    
}
