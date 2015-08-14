<?php
use Illuminate\Http\Request;
Route::get('/', "IndexController@index" );
Route::post('/playground',['as'=>'playground', 'uses'=>'PlaygroundController@playground']);
Route::get('/verstka', function(){
	return view('verstka');
});

Route::get('/playground', ['as'=>'plaing', 'uses'=>'PlaygroundController@plaing']);
Route::post('/statistics', ['as'=>'post_statistics', 'uses'=>'StatisticController@index']);
Route::get('/statistics', ['as'=>'get_statistics', 'uses'=>'StatisticController@index']);
