<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SubCategoryStoreRequest;
use App\Http\Requests\SubCategoryUpdateRequest;
use App\Http\Requests\SubcategoryActiveRequest;
class SubCategoryController extends Controller
{

    public function index()
    {
        $subcategories=DB::select('CALL sp_list_subcategories()');
        if($subcategories==[]){
            return response()->json([
                'res'=>false,
                'msg'=>'There are no subcategories'
            ]);
        }
        $dati = json_encode($subcategories);
        $testdat = json_decode($dati, true);
        //Log::info($testdat[0]['id']);
        return response()->json([
                'res'=>true,
                'data'=>$subcategories
        ],200);
    }

    public function store(SubCategoryStoreRequest $request)
    {
        try{
            $subcategories=DB::select('CALL sp_add_subcategories(?,?,?)',[
                $request->name,
                $request->description,
                $request->categories_id
            ]);
            $id = $subcategories[0] -> id;
            return response()->json([
                'res'=>true,
                'msg'=>'added successfully',
                'data' => array("id"=>$id)
            ],201);

        }catch(\Exception $e){
            return response()->json([
                'res'=>false,
                'msg'=>$e->getMessage(),
            ],500);
        }
    }

    public function show($id)
    {
        //
    }

    public function update(SubCategoryUpdateRequest $request, $id)
    {
        try {
            $subcategoriesExist = DB::Select('CALL sp_if_subcategory_id_exist(?)',[
                $id
            ]);

            if ($subcategoriesExist == []) {
                return response()->json([
                    'res' => false,
                    'msg' => 'The subcategory does not exist'
                ],404);
            }

            $updateSubcategory= DB::update('CALL sp_update_subcategory(?,?,?)',[
                $id,
                $request->name,
                $request->description
            ]);
            return response()->json([
                'res'=>true,
                'msg'=>'subcategory updated'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        //to delete a subcategory it's need to be inactive and exist AND there need to be zero products associate to it
        try {
            $subcategoryExist = DB::select('CALL sp_if_subcategory_id_exist(?)',[$id]);
            if ($subcategoryExist == []){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The subcategory does not exist'
                ],404);
            }
            //verify is the subcategory is active or not
            $datos = json_encode($subcategoryExist);
            $array_data = json_decode($datos, true);
            //Log::info($array_data[0]['is_actived']);
            if ($array_data[0]['is_actived'] == true){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The subcategory is active'
                ],404);
            }

            $subcategoryHasProducts = DB::select('CALL sp_if_subcategory_has_products(?)',[$id]);
            
            if (empty($subcategoryHasProducts)) {
                //if the subcategory has no products then delete
                DB::delete('CALL sp_delete_subcategory(?)',[$id]);
                return response()->json([
                    'res'=> true,
                    'message' => 'The subcategory has beeen deleted'
                ],200);
            } else {
                return response()->json([
                    'res'=>false,
                    'msg' => 'The subcategory has products'
                ],404);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'res'=>false,
                'message'=>$th->getMessage()
            ]);
        }
    }

    //EXTRAS FUNCTIONS

    public function updateStateSubCategory(SubcategoryActiveRequest $request, $id){

        try {

            $subcategoriesExist = DB::Select('CALL sp_if_subcategory_id_exist(?)',[
                $id
            ]);

            if ($subcategoriesExist == []) {
                return response()->json([
                    'res' => false,
                    'msg' => 'The subcategory does not exist'
                ],404);
            }

            DB::update('CALL sp_update_is_actived_subcategory(?,?)',[
                $id,
                $request->is_actived
            ]);
            return response()->json([
                'res'=>true,
                'msg'=>'subcategory state updated'
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }
    }

    //Exit subcategory by Name
    public function existSubCategory($subcategory_name)
    {
        try{
            $subcategory_exist = DB::select('CALL sp_if_exists_subcategory(?)',[
                $subcategory_name,
            ]);      
            if(json_decode(json_encode($subcategory_exist['0']), true)["`@exists_subcategories`"]==0){
                return response()->json([
                    'res' =>false,
                    'error' => 'The subcategory does not exist'
                                            ], 404); 
            }

            $subcategory_details = DB::select('select * from subcategories where name=(?)',[
                $subcategory_name
            ]);
            return response()->json([
                "res" => true,
                "msg" => 'The subcategory exist',
                "data" => $subcategory_details,
                ], 200);
                    
        }catch(\Exception $e){
            return response()->json([
                'res' => false,
                'msg' => $e->getMessage(),
            ], 500);
        }
    }

    //list product by subcategory
    public function listProductBySubCategoryId($subcategories_id){
        try {
            //the subcategory needs to exist and be active
            $subcategoryExist = DB::select('CALL sp_if_subcategory_id_exist(?)',[$subcategories_id]);
            if ($subcategoryExist == []){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The subcategory does not exist'
                ],404);
            }
            //verify is the subcategory is active or not
            $datos = json_encode($subcategoryExist);
            $array_data = json_decode($datos, true);
            //Log::info($array_data[0]['is_actived']);
            if ($array_data[0]['is_actived'] == false){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The subcategory is not active'
                ],404);
            }

            $products=DB::Select('CALL sp_list_products_by_subcategory(?)',[
                $subcategories_id
            ]);

            $datos = json_encode($products);
            $array_data = json_decode($datos, true);
            Log::info($array_data);
            if (array_key_exists('exit', $array_data[0])) {
                return response()->json([
                    'res' => false,
                    'msg' => 'There are not products'
                ],204); //204 -> No content, in others words the res and msg will NOT show in the response, only the code status will show
            }
            return response()->json([
                'res' => true,
                'data' => $products
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }
    }

    //list brands by subcategory
    public function listBrandsBySubCategoryId($subcategories_id){
        try {
            //the subcategory needs to exist and be active
            $subcategoryExist = DB::select('CALL sp_if_subcategory_id_exist(?)',[$subcategories_id]);
            if ($subcategoryExist == []){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The subcategory does not exist'
                ],404);
            }
            //verify is the subcategory is active or not
            $datos = json_encode($subcategoryExist);
            $array_data = json_decode($datos, true);
            //Log::info($array_data[0]['is_actived']);
            if ($array_data[0]['is_actived'] == false){
                return response()->json([
                    'res'=>false,
                    'msg' => 'The subcategory is not active'
                ],404);
            }

            $brands=DB::Select('CALL sp_list_brands_by_subcategory(?)',[
                $subcategories_id
            ]);

            return response()->json([
                'res' => true,
                'data' => $brands
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'msg' => $th->getMessage(),
            ], 500);
        }
    }
}
