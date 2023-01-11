<?php

use Illuminate\Support\Facades\Route;


Route::post('/login', 'AuthApi@login');
Route::post('/register', 'AuthApi@register');

Route::group(['middleware' => 'AuthApi'], function () {
    Route::post('/logout', 'AuthApi@logout');

    Route::resource('category', 'CategoryApi');

    Route::resource('note', 'NoteApi');
    Route::post('fav-note/add', 'NoteApi@addFav');
    Route::delete('fav-note/remove', 'NoteApi@removeFav');
    Route::get('fav-note/get', 'NoteApi@getFav');

    Route::post('/search/user', 'NoteApi@searchUser');
    Route::post('contribute-note/create', 'NoteApi@createContribute');
    Route::get('contribute-note/get', 'NoteApi@getContribute');
    Route::get('receive-note/get', 'NoteApi@getReceiveNote');
});

Route::fallback(function () {
    return response()->json(['success' => false, 'data' => "invalid_route"]);
});
