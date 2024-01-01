<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Product;
use App\Http\Requests\RecipeRequest;

class RecipeController extends Controller
{
    /**
     * Create a new recipe.
     *
     * @param  RecipeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RecipeRequest $request){
        try{
            //creating recipe
            $recipe = Recipe::create(['name' => $request->name]);

            //linking recipe with products
            foreach($request->products as $item){
                $recipe->ingredients()->attach($item['id'], ['quantity' => $item['quantity']]);
            }

            //loading product names only of the created recipe
            $recipe->load('ingredients:name');

            //returning the created recipe with a status of 201
            return response()->json([
                'recipe' => $recipe
            ], 201);
        }catch(\Exception $e){
            //returning errors in case any error was catched 
            return response()->json([
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get all recipes with status and missing ingredients.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recipes(){
        try{
            //loading all recipes
            $recipes = Recipe::all();
            $data = [];

            //looping each recipe
            foreach($recipes as $recipe){ 
                $status = true;
                $missingProducts = [];

                //looping each product of recipe
                foreach($recipe->ingredients as $product){
                    //checking if product is qte is out of stock
                    if($product->quantity == 0){
                        $status = false;
                        //push it to missing products
                        $missingProducts[] = $product->name;
                    }else{
                        //getting the quantity of product in recipe
                        $quantity = $product->pivot->quantity;

                        //checking if missing quantity
                        $diff = $quantity - $product->quantity;
                        if($diff > 0){
                            $status = false;
                            $missingProducts[] = "$diff ".$product->name;
                        }
                    }
                }
                //loading ingredients of the current recipe
                $recipe->load('ingredients:name');
                //pushing to data array the result
                $data[] = [
                    'recipe' => $recipe,
                    'missingIngredients' => $missingProducts,
                    'isValid' => $status
                ];
            }

            //returning data with success status
            return response()->json([
                'recipes' => $data
            ], 200);
        }catch(\Exception $e){
            //returning errors in case any error was catched 
            return response()->json([
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Validate a recipe.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateRecipe(Request $request){
        try{
            $recipe = Recipe::findOrFail($request->id);
            
            //loop recipe products
            foreach($recipe->ingredients as $product){
                //getting the quantity of product in recipe
                $qte = $product->pivot->quantity;
                
                //calculating new product's stock
                $stock = $product->quantity - $qte;
                
                //updating stock 
                Product::find($product->id)->update([
                    'quantity' => $stock
                ]);
            }
             //returning success message
            return response()->json([
                'message' => 'Validated successfully' 
            ], 200);
        }catch(\Exception $e){
            //returning errors in case any error was catched 
            return response()->json([
                'errors' => $e->getMessage()
            ], 400);
        }
    }
}
