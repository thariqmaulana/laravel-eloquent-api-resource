<?php

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategorySimpleResourceImplementation;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDebugResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceConditional;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// /api/categories/{id} ketika mengakses seperti ini. menambah prefix /api
Route::get('/categories/{id}', function ($id) {
    $category = Category::findOrFail($id);
    /**Secara otomatis di edit sesuai kostumisasi yg sudah kita buat
     * dan akan diubah menjadi json.
     * yg asalnya semua kolom.
     */
    return new CategoryResource($category);
});

Route::get('/categories-all', function () {
    $categories = Category::all();
    // untuk yg return datanya lebih dari 1
    // jadi masing-masingnya akan dibungkus lagi per array
    return CategoryResource::collection($categories);//anonymous resource collection
});

Route::get('/categories-collection-custom', function () {
    $categories = Category::all();
    return new CategoryCollection($categories);
});

Route::get('/categories-collection-implementing-another-resource-collection', function () {
    $categories = Category::all();
    return new CategorySimpleResourceImplementation($categories);
});

Route::get('/products/{id}', function ($id) {
    $product = Product::find($id);
    return (new ProductResource($product))->response()->header('Author', 'thariq');
});

Route::get('/products', function () {
    $products = Product::all();
    return new ProductCollection($products);
});

Route::get('/products-paging', function (Request $request) {
    $page = $request->get('page', 1);
    $products = Product::paginate(perPage: 2, page: $page);
    return new ProductCollection($products);
});

Route::get('/products-additional', function () {
    $product = Product::first();
    return new ProductDebugResource($product);
});

Route::get('/products-conditional/{id}', function ($id) {
    $product = Product::find($id);
    return new ProductResourceConditional($product);
});