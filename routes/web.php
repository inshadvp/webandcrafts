<?php

use App\Car;
use App\Http\Controllers\CommonController;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');


Route::get('/home', function () {
    return view('welcome');
})->middleware('auth');

Route::resource('employees','EmployeeController')->middleware('auth');

Route::group(['prefix'=>'operations','as'=>'operations.','middleware' => 'auth'], function(){
    Route::get('/', ['as' => 'index', 'uses' => 'CommonController@index']);
    Route::get('fetch-countries', ['as' => 'fetch-countries', 'uses' => 'CommonController@fetchCountries']);
    Route::get('/employee-listing', 'CommonController@employeeListing')->name('employee-listing');
});

// Route::get('fetchCountries', 'CommonController@fetchCountries')->name('fetchCountries'); 
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

//-------------------- elqouent routes --------------------//

Route::get('/user-company-details', "CommonController@userCompanyDetails");
Route::get('/user-roles', "CommonController@userRoles");


//-------------------- elqouent orm routes --------------------//
// -create a car
    Route::get('/create-car', function(){
        $car = Car::create([
            'model'=>'Wolkswagon',
            'year'=>1999
            ]);
        return $car;
    });

// -view all cars
    Route::get('cars', function(){
        $cars = Car::all();
        return view('cars.cars', ['cars'=>$cars]);
    })->name('cars.index');

// - create a car(show a form)
    Route::get('/cars/create', function(){
        return view('cars.car-create');
    });

// - view a single car
    // method-1
        Route::get('/cars/{model}', function($model){
            // $car = Car::where('model',$model)->first();
            $car = Car::whereModel($model)->firstOrFail(); //if fail then redirected to 404
            return view('cars.car', compact('car'));
        });
    // method-2
        // Route::get('/cars/{car:model}', function(Car $car){
        //     return view('cars.car', compact('car'));
        // });

// - create a car(process the form)
    Route::post('/cars', function(){
        $data = request()->all();
        $car = Car::create($data);
        return redirect()->route('cars.index');
    })->name('cars');

// - edit/update a car (process the update)
    Route::patch('/cars/{car:model}', function(Car $car){
        $car->fill(request()->all());
        $car->save();
        return redirect()->route('cars.index');
    });

// - delete a car
    Route::delete('/cars/{car:model}', function(Car $car){
        $car->delete();
        return redirect()->route('cars.index');
    });
//-------------------- elqouent orm routes --------------------//