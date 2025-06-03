<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowProduct extends Model
{
    public function show(Product $product) {
        return view('information', compact('product'));
    }
}
