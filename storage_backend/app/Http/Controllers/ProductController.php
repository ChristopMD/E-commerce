<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductStorageRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductActiveRequest;

class ProductController extends Controller
{
    //list all products
    public function index()
    {
        $products = DB::select('CALL sp_list_products()');
        if($products==[]){
            return response()->json([
                'res'=> false,
                'mes'=> 'There are no products'
            ]);
        }
        return response()->json([
            'res' => true,
            'data' => $products
        ], 200);
    }


    public function store(ProductStorageRequest $request)
    {
        try{
            
            DB::insert('call sp_add_products(?,?,?,?,?,?,?)',[
                $request->name,
                $request->price,
                $request->stock,
                base64_encode(file_get_contents($request->img_url)),
                $request->brand,
                $request->description,
                $request->subcategories_id,]);

            return response()->json([
                "code"    => 201,
                "status"  => "Created",
                "message" => "The request succeeded, and create new product"    
            ],201);

        } catch (\Throwable $th) {
            return response()->json([
                "code"    =>  500,
                "status" =>  "Internal Server Error",
                "message" => "The server has encountered a situation it does not know how to handle.",
                "error"   =>  $th->getMessage()
            ],500);
        };
    }


    public function show($id)
    {
        $lista = DB::Select('Call sp_if_product_id_exist(?)', [$id]);
        Log::info($lista);
        if ($lista == []) {
            return response()->json([
                'res'=> false,
                "msg" => "The product does not exist"
            ], 404);
        }

        return response()->json([
            'msg' => true,
            'data' => $lista
        ], 200);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        try {
            $productExist = DB::select('CALL sp_if_product_id_exist(?)',[$id]);
            if ($productExist==[]) {
                return response()->json([
                    'res'=>false,
                    'msg'=>'The product does not exist'
                ],404);
            }
            $productUpdated = DB::update("Call sp_update_product(?,?,?,?,?,?)", [
                $id,
                $request->name,
                $request->price,
                base64_encode(file_get_contents($request->img_url)),
                $request->brand,
                $request->description,]);
                
            return response()->json([
                'res' => true,
                'respuesta' => 'Product updated'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'res'=>false,
                'msg'=>$th->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        //to delete a product it's need to be inactive and exist
        try {
            $productExist = DB::select('CALL sp_if_product_id_exist(?)',[$id]);
            if ($productExist == []){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The product does not exist'
                ],404);
            }

            //verify is the category is active or not
            $datos = json_encode($productExist);
            $array_data = json_decode($datos, true);
            //Log::info($array_data[0]['is_actived']);
            if ($array_data[0]['is_actived'] == true){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The product is active'
                ],404);
            }

            DB::delete('CALL sp_delete_product(?)',[$id]);
            return response()->json([
                'res'=> true,
                'message' => 'The product has beeen deleted'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'res'=>false,
                'message'=>$th->getMessage()
            ]);
        }
    }
    
    //EXTRAS FUNCTIONS

    //Update is_active Category
    public function updateStateProduct(ProductActiveRequest $request, $id)
    {
        try {

            $categoriesExist = DB::Select('CALL sp_if_product_id_exist(?)',[
                $id
            ]);

            if ($categoriesExist == []) {
                return response()->json([
                    'res' => false,
                    'msg' => 'The product does not exist'
                ],404);
            }

            DB::update('CALL sp_update_is_actived_product(?,?)',[
                $id,
                $request->is_actived
            ]);
            return response()->json([
                'res'=>true,
                'msg'=>'product state updated'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }


    }

    //find product by name
    public function findProductname($name){
    
        try {
            $product_exist = DB::select('CALL sp_if_exists_product(?)',[
                $name,
            ]);      
            if(json_decode(json_encode($product_exist['0']), true)["`@exists_products`"]==0){
                return response()->json([
                    'res' =>false,
                    'error' => 'The product does not exist'
                                            ], 404); 
            }
            
            $product_details = DB::select('select * from products where name=(?)',[
                $name
            ]);
            return response()->json([
                "res" => true,
                "msg" => 'The product exist',
                "data" => $product_details,
                ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }
    }
    
}
