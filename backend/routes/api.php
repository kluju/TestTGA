<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/encuestas','App\Http\Controllers\EncuestaController@index');
Route::post('/encuestas','App\Http\Controllers\EncuestaController@store');

Route::get('/respuestas','App\Http\Controllers\RespuestaController@index');
Route::get('/respuestas/excel','App\Http\Controllers\RespuestaController@excel');
Route::get('/respuestas/participante/{id}','App\Http\Controllers\RespuestaController@edit');
Route::get('/respuestas/graficoGenero','App\Http\Controllers\RespuestaController@graficoGenero');
Route::get('/respuestas/graficoHobby','App\Http\Controllers\RespuestaController@graficoHobby');
Route::get('/respuestas/graficoNombres','App\Http\Controllers\RespuestaController@graficoNombres');
Route::get('/respuestas/graficoTiempoDedicado','App\Http\Controllers\RespuestaController@graficoTiempoDedicado');

Route::get('/clientes/getClientsSortByAmount/{id}','App\Http\Controllers\ClienteController@getClientsSortByAmount');
Route::get('/clientes/newClientRanking','App\Http\Controllers\ClienteController@newClientRanking');

Route::get('/empresas','App\Http\Controllers\EmpresaController@index');
Route::get('/empresas/getBusinessById/{id}','App\Http\Controllers\EmpresaController@getBusinessById');
Route::post('/empresas','App\Http\Controllers\EmpresaController@store');
Route::post('/empresas/update/{id}','App\Http\Controllers\EmpresaController@update');
Route::delete('/empresas/{id}','App\Http\Controllers\EmpresaController@destroy');
Route::get('/empresas/resumenArriendo','App\Http\Controllers\EmpresaController@resumenArriendo');

Route::get('/empresas/getCompanyClientsSortByName','App\Http\Controllers\EmpresaController@getCompanyClientsSortByName');
Route::get('/empresas/getCompaniesSortByProfits','App\Http\Controllers\EmpresaController@getCompaniesSortByProfits');
Route::get('/empresas/getCompaniesWithRentsOver1Week','App\Http\Controllers\EmpresaController@getCompaniesWithRentsOver1Week');
Route::get('/empresas/getClientsWithLessExpense','App\Http\Controllers\EmpresaController@getClientsWithLessExpense');

Route::get('/arriendos','App\Http\Controllers\ArriendoController@index');
Route::post('/arriendos','App\Http\Controllers\ArriendoController@store');
Route::post('/arriendos/update/{id}','App\Http\Controllers\ArriendoController@update');
Route::delete('/arriendos/{id}','App\Http\Controllers\ArriendoController@destroy');
Route::get('/arriendos/pormes','App\Http\Controllers\ArriendoController@arriendoPorMes');
Route::get('/arriendos/getLeasesById/{id}','App\Http\Controllers\ArriendoController@getLeasesById');

Route::get('/arriendos/mayormonto','App\Http\Controllers\ArriendoController@arriendoMayorMonto');
Route::get('/arriendos/menormonto','App\Http\Controllers\ArriendoController@arriendoMenorMonto');


