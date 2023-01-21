<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\CategoryActiveRequest;
use PhpParser\Node\Stmt\TryCatch;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::select('CALL sp_list_categories()');
        if($categories==[]){
            return response()->json([
                'res'=> false,
                'mes'=> 'There are no categories'
            ]);
        }
        return response()->json([
            'res' => true,
            'data' => $categories
        ], 200);

    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            //Verficar si el nombre de la category ya existe
            DB::insert('CALL sp_add_categories(?,?)',[
                $request -> name,
                $request->description
            ]);
            return response()->json([
                'res' => true,
                'mes'=> 'category added succesfully'
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'res'=> false,
                'mes'=> $th->getMessage()
            ],500);
        }
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        try {
            $categoryExist = DB::select('CALL sp_if_category_id_exist(?)',[
                $id
            ]);
            if ($categoryExist ==[]) {
                return response()->json([
                    'res'=>false,
                    'msg' => 'The category does not exist'
                ],404);
            }
            
            $updateCategory = DB::update('CALL sp_update_category(?,?,?)',[
                $id,
                $request->name,
                $request->description
            ]);
            return response()->json([
                'res'=>true,
                'msg'=> 'category updated'
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'res'=> false,
                'msg' => $th->getMessage()
            ],500);
        }
    }

    public function destroy($id)
    {
        //to delete a category it's need to be inactive and exist
        try {
            $categoryExist = DB::select('CALL sp_if_category_id_exist(?)',[$id]);
            //Log::info($categoryExist);
            if ($categoryExist == []){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The category does not exist'
                ],404);
            }
            //verify is the category is active or not
            $datos = json_encode($categoryExist);
            $array_data = json_decode($datos, true);
            //Log::info($array_data[0]['is_actived']);
            if ($array_data[0]['is_actived'] == true){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The category is still active'
                ],404);
            }

            DB::delete('CALL sp_delete_category(?)',[$id]);
            return response()->json([
                'res'=> true,
                'message' => 'The category has beeen deleted'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'res'=>false,
                'message'=>$th->getMessage()
            ]);
        }
    }

    //ADITIONALS FUNCTIONS

    public function list_active_categories()
    {
        $categories = DB::select('CALL sp_list_active_categories()');
        if($categories==[]){
            return response()->json([
                'res'=> false,
                'mes'=> 'There are no active categories'
            ]);
        }
        return response()->json([
            'res' => true,
            'data' => $categories
        ], 200);

    }

    //Update is_active Category
    public function updateStateCategory(CategoryActiveRequest $request, $id)
    {
        try {

            $categoriesExist = DB::Select('CALL sp_if_category_id_exist(?)',[
                $id
            ]);

            if ($categoriesExist == []) {
                return response()->json([
                    'res' => false,
                    'msg' => 'The category does not exist'
                ],404);
            }

            DB::update('CALL sp_update_is_actived_category(?,?)',[
                $id,
                $request->is_actived
            ]);
            return response()->json([
                'res'=>true,
                'msg'=>'Category state updated'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }


    }

    //get category by id
    public function getCategoryById($id)
    {
        $category = DB::select('CALL sp_if_category_id_exist(?)',[$id]);
        if($category==[]){
            return response()->json([
                'res'=> false,
                'mes'=> 'The category does not exist'
            ]);
        }
        return response()->json([
            'res' => true,
            'data' => $category
        ], 200);

    }

    //Exist category by name
    public function existCategoryName($category_name)
    {
        try {
            $category_exist = DB::select('CALL sp_if_exists_category(?)',[
                $category_name,
            ]);      
            if(json_decode(json_encode($category_exist['0']), true)["`@exists_categories`"]==0){
                return response()->json([
                    'res' =>false,
                    'error' => 'The category does not exist'
                                            ], 404); 
            }
            
            $category_details = DB::select('select * from categories where name=(?)',[
                $category_name
            ]);
            return response()->json([
                "res" => true,
                "msg" => 'The category exist',
                "data" => $category_details,
                ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }
    }

    public function listSubcategoryByCategoryId($categories_id)
    {
        //only can list if tge category exist and is active
        try {
            $categoryExist = DB::Select('CALL sp_if_category_id_exist(?)',[
                $categories_id
            ]);
            
            if ($categoryExist == []) {
                return response()->json([
                    'res' => false,
                    'msg' => 'The category does not exist'
                ],404);
            }
            //verify is the category is active or not
            $datos = json_encode($categoryExist);
            $array_data = json_decode($datos, true);
            //Log::info($array_data[0]['is_actived']);
            if ($array_data[0]['is_actived'] == false){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The category is not active'
                ],404);
            }

            $subcategories=DB::Select('CALL sp_list_subcategory_by_category(?)',[
                $categories_id
            ]);
            
            $datos = json_encode($subcategories);
            $array_data = json_decode($datos, true);
            //Log::info($array_data);
            if (array_key_exists('exit', $array_data[0])) {
                return response()->json([
                    'res' => false,
                    'msg' => 'There are not subcategories'
                ],204); //204 -> No content, in others words the res and msg will NOT show in the response, only the code status will show
            }
            return response()->json([
                'res' => true,
                'msg' => $subcategories
            ],200);
        } 
        catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }
    }

}
