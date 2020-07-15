<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Employee;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('empleados', function (){
    $empleados = Employee::get();
    return $empleados;
});

Route::get('empleados/{id}', function ($id){
    $empleados = Employee::findOrFail($id);
    return $empleados;
});

// crea un empleado
Route::post('empleados', function (Request $request){
    $request
        ->validate([
                       'name'           => 'required|max:50',
                       'lastname'       => 'required|max:50',
                       'document_id'    => 'required|max:50',
                       'email'          => 'required|max:50|email|unique:employees',
                       'state'          => 'required|max:50',
                       'sex'            => 'required|max:50',
                       'marital_status' => 'required|max:50',
                       'phone'          => 'required|max:50',
                   ]);

    $e = new Employee();
    $e->name        = $request->input('name');
    $e->lastname    = $request->input('lastname');
    $e->document_id = $request->input('document_id');
    $e->email       = $request->input('email');
    $e->state       = $request->input('state');
    $e->sex         = $request->input('sex');
    $e->marital_status = $request->input('marital_status');
    $e->phone       = $request->input('phone');

    $e->save();

    return 'empleado creado';

});

// Actualizar empleado
Route::put('empleados/{id}', function (Request $request, $id){
    $request
        ->validate([
                       'name'           => 'required|max:50',
                       'lastname'       => 'required|max:50',
                       'document_id'    => 'required|max:50',
                       'email'          => 'required|max:50|email|unique:employees,email,'.$id,
                       'state'          => 'required|max:50',
                       'sex'            => 'required|max:50',
                       'marital_status' => 'required|max:50',
                       'phone'          => 'required|max:50',
                   ]);

    $e = Employee::findOrFail($id);
    $e->name        = $request->input('name');
    $e->lastname    = $request->input('lastname');
    $e->document_id = $request->input('document_id');
    $e->email       = $request->input('email');
    $e->state       = $request->input('state');
    $e->sex         = $request->input('sex');
    $e->marital_status = $request->input('marital_status');
    $e->phone       = $request->input('phone');

    $e->save();
    return "empleado actualizado";
});

// eliminar empleado
Route::delete('empleados/{id}', function (Request $request, $id){
    $e = Employee::findOrFail($id);
    $e->delete();
    return "empleado eliminado exitosamene";

});
