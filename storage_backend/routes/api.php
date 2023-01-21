<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Category                                                          
Route::get('categories',[CategoryController::class, 'index']);
Route::post('categories',[CategoryController::class, 'store']);
Route::put('categories/{id}',[CategoryController::class, 'update']);
Route::delete('categories/{id}',[CategoryController::class, 'destroy']);
Route::put('categories/active/{id}', [CategoryController::class, 'updateStateCategory']);
Route::get('active/categories',[CategoryController::class, 'list_active_categories']);
Route::get('categories/{id}',[CategoryController::class, 'getCategoryById']);
Route::get('categories/search/{name}',[CategoryController::class, 'existCategoryName']);
Route::get('categories/{categories_id}/subcategories',[CategoryController::class, 'listSubcategoryByCategoryId']);

//Subcategory
Route::get('subcategories',[SubCategoryController::class, 'index']);
Route::post('subcategories', [SubCategoryController::class ,'store']);
Route::put('subcategories/{id}', [SubCategoryController::class ,'update']);
Route::delete('subcategories/{id}', [SubCategoryController::class ,'destroy']);
Route::put('subcategories/active/{id}', [SubCategoryController::class, 'updateStateSubCategory']);
Route::get('subcategories/search/{name}',[SubCategoryController::class, 'existSubCategory']);
Route::get('subcategories/{subcategories_id}/products',[SubCategoryController::class, 'listProductBySubCategoryId']);
Route::get('subcategories/{subcategories_id}/brands',[SubCategoryController::class, 'listBrandsBySubCategoryId']);

//Product
Route::get('products',[ProductController::class, 'index']);
Route::post('products',[ProductController::class, 'store']);
Route::put('products/{id}',[ProductController::class, 'update']);
Route::delete('products/{id}',[ProductController::class, 'destroy']);
Route::put('products/active/{id}', [ProductController::class, 'updateStateProduct']);
Route::get('products/{id}',[ProductController::class, 'show']);
Route::get('products/search/{name}',[ProductController::class, 'findProductname']);


//NOTA: AGREGAR UN METODO QUE, CUANDO ESCRIBA EL NOMBRE DE UN PRODUCTO O SUBCATEGORIA O CATEGORIA EN LA BARRA DE BUSQUEDA, 
//ME DEVUELVA TODOS LOS PRODUCTOS RELACIONADOS A ESE NOMBRE O SUBCATEGORIA O CATEGORIA.
