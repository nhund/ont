<?php

namespace App\Transformers\Category;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract {
    
    public function transform(Category $category){

        return [
            'id' => $category->id,
            'name' => $category->name,
            'type' => $category->type,
            'created_at' => $category->create_at
        ];
    }
}