<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $primarykey = 'id';
    protected $fillable = [
        'name', 'quantity', 'expiration'
    ];

    
    public function recipes(){
        return $this->belongsToMany(Recipe::class, 'recipe_products')->withPivot('quantity');
    }
}
