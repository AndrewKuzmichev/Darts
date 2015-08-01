<?php
use Illuminate\Http\Request;
Route::get('/', "IndexController@index" );
Route::post('/playground',['as'=>'playground', 'uses'=>'IndexController@playground']);
Route::get('/verstka', function(){
	return view('verstka');
});
Route::get('/playground',['as'=>'plaing', 'uses'=>'IndexController@plaing']);
