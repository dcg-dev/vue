<?php

namespace App\Filters;

use App\Filters\Filter;

class PromoSubscriptionFilter extends Filter {
    
    public function q($search) {
        return $this->with('plan')->whereHas('plan', function($query) use ($search) {
                    return $query->where('name', 'ilike', '%' . $search . '%');
                });
    }
    
}
