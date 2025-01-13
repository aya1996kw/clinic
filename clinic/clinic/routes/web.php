<?php
namespace App\Http\Controllers;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

*/

Route::group (['middleware'=>'guest'],function(){
    Route::get('/login',[UsersController::class,'login_index'])->name('login');
    Route::get('/register',[UsersController::class,'register_index'])->name('register');
    Route::post('/login',[UsersController::class,'login']);
    Route::post('/register',[UsersController::class,'register']);

});
Route::group (['middleware'=>'auth.admin'],function(){
    Route::get('/admin/home',[AdminController::class,'dashboard_index']);
    Route::get('/admin/doctor',[AdminController::class,'doctor_index']);
    Route::get('/admin/specializations',[AdminController::class,'specializations_index']);
    Route::get('/admin/table_doctor',[AdminController::class,'table_doctor_index']);
    Route::get('/admin/Patient',[AdminController::class,'Patient_index']);
    Route::post('/admin/add_specializations',[AdminController::class,'add_specializations']);
    Route::post('/admin/add_Doctor',[AdminController::class,'add_Doctor']);
    Route::post("/admin/Update",[AdminController::class,'profileUpdate']);


});
Route::group (['middleware'=>'auth.doctor'],function(){
    Route::get('/doctor/home',[DoctorController::class,'dashboard_index']);
    Route::post('/doctor/add_range',[DoctorController::class,'add_range']);
    Route::post( '/doctor/update_user_time',[DoctorController::class,'update_user_time']);
    Route::post("/doctor/Update",[DoctorController::class,'profileUpdate']);
    Route::get('/doctor/Add_Working_Hours',[DoctorController::class,'Add_Working_Hours_index']);
    Route::get('/doctor/Available_Ranges',[DoctorController::class,'Available_Ranges_index']);
    Route::post( '/doctor/add_off_days',[DoctorController::class,'add_off_days']);


});

Route::group (['middleware'=>'auth.client'],function(){
    Route::get('/home',[ClientController::class,'dashboard_index'])->name('home');
    Route::get('/client',[ClientController::class,'client_index']);
    Route::get('/client/ajax',[ClientController::class,'ajax_index']);
    Route::post('/pick_date',[ClientController::class,'pick_date']);
    Route::post('/rating',[ClientController::class,'rating']);
    Route::post("/client/Update",[ClientController::class,'profileUpdate']);
    Route::get('/client/add',[ClientController::class,'add_date_index']);
});

Route::group (['middleware'=>'auth.basic'],function(){
    Route::get('/logout',[UsersController::class,'logout']);


});

