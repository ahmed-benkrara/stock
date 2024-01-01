<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Recipe extends Model
{
    use HasFactory;
    protected $table = 'recipe';
    protected $primarykey = 'id';
    protected $fillable = [
        'name'
    ];

    public function ingredients(){
        return $this->belongsToMany(Product::class, 'recipe_products')->withPivot('quantity');
    }
}
