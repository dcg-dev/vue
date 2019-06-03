<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller {

    use Api\CategoryController;
    
    public function view(Category $category) {
        return view('item.search', [
            'category' => $category
        ]);
    }

}
