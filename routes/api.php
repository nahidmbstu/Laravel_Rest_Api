<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\UserController;
Use App\Article;


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
    
});


Route::get('articles', function() {
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    return Article::all();
})->middleware('auth:api');
 
Route::get('articles/{id}', function($id) {
    return Article::find($id);
})->middleware('auth:api');

Route::post('articles', function(Request $request) {

    $data = $request->all();
    return Article::create([
        'title' => $data['title'],
        'body' => $data['body'],
    ]);

})->middleware('auth:api');

Route::put('articles/{id}', function(Request $request, $id) {
    $article = Article::findOrFail($id);
    $article->update($request->all());

    return $article;
})->middleware('auth:api');

Route::delete('articles/{id}', function($id) {
    Article::find($id)->delete();

    return 204;
})->middleware('auth:api');

