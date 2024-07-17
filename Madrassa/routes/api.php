<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DeclarationController;
use App\Http\Controllers\DeclarationArchController;
use App\Http\Controllers\PictureDecController;
use App\Http\Controllers\PictureAnnController;
use App\Http\Controllers\AttacheController;
use App\http\Controllers\RapportController;
use App\http\Controllers\ServiceController;
use App\http\Controllers\AnnonceController;
use App\http\Controllers\AnnonceArchController;
use App\http\Controllers\PictureAnnArchController;

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
//Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/validate', [AuthController::class, 'sendCode']);
Route::get('/users', [AuthController::class, 'getUsers']);
Route::get('/responsables', [AuthController::class, 'getResponsables']);


//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function () {
        return 'Succes';
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    //Admin routes
    Route::prefix('admin')->group(function () {
        Route::post('/create', [AuthController::class, 'createUser']);
    });


});

//Categories CRUD

Route::post('/CreateCat' , [CategorieController::class,'store'] );
Route::put('/UpdateCat' , [CategorieController::class,'update'] );
Route::get('/ShowCat' , [CategorieController::class,'index'] );
Route::delete('/DeleteCat' , [CategorieController::class,'destroy'] );

//Desclarations CRUD

Route::post('/CreateDec' , [DeclarationController::class , 'store'] );
Route::get('/ShowDecAll' , [DeclarationController::class , 'indexAll'] );
Route::get('/ShowDecSelf' , [DeclarationController::class , 'indexSelf'] );
Route::put('/UpdateDec' , [DeclarationController::class , 'update'] );
Route::put('/UpdateDecState' , [DeclarationController::class , 'updateState'] );
Route::put('/AttacheService' , [DeclarationController::class , 'attacheService'] );
Route::delete('/DeleteDec' , [DeclarationController::class , 'destroy'] );


//Attaches CRUD

Route::get('/ShowAtt' , [AttacheController::class , 'index'] );
Route::post('/CreateAtt' , [AttacheController::class , 'store'] );
Route::put('/UpdateAtt' , [AttacheController::class , 'update'] );
Route::delete('/DeleteAtt' , [AttacheController::class , 'destroy'] );


//Picture Declaration CRUD

Route::post('/InsertPic' , [PictureDecController::class , 'store'] );
Route::post('/ShowPic' , [PictureDecController::class , 'indexIdDec'] );
Route::post('/UpdatePic' , [PictureDecController::class , 'update'] );
Route::post('/DeletePic' , [PictureDecController::class , 'destroy'] );


//Rapport CRUD functions

Route::post('/InsertRapport' , [RapportController::class , 'store'] );
Route::post('/ShowRapport' , [RapportController::class , 'index'] );  // la consultation pour le service ou le responsable
Route::post('/UpdateRapport' , [RapportController::class , 'update'] );
Route::post('/DeleteRapport' , [RapportController::class , 'destroy'] );


//change state to valide/miss_document for responsable

Route::put('/UpdateState' , [RapportController::class , 'updateState'] );


//delete user
Route::delete('/DeleteUser' , [AuthController::class , 'deleteUser'] );

//Service CRUD functions

Route::post('/InsertService', [ServiceController::class , 'store'] );
Route::put('/UpdateService', [ServiceController::class , 'update'] );
Route::get('/ShowAllService', [ServiceController::class , 'index_all'] );
Route::get('/ShowService', [ServiceController::class , 'index'] );
Route::delete('/DeleteService', [ServiceController::class , 'destroy'] );



//Picture Annonce CRUD

Route::post('/InsertPicAnn' , [PictureAnnController::class , 'store'] );
Route::post('/ShowPicAnn' , [PictureAnnController::class , 'indexIdAnn'] );
Route::post('/UpdatePicAnn' , [PictureAnnController::class , 'update'] );
Route::post('/DeletePicAnn' , [PictureAnnController::class , 'destroy'] );



//Annonces CRUD

Route::post('/CreateAnn' , [AnnonceController::class , 'store'] );
Route::get('/ShowAnnAll' , [AnnonceController::class , 'indexAll'] );
Route::get('/ShowAnnSelf' , [AnnonceController::class , 'indexSelf'] );
Route::put('/UpdateAnn' , [AnnonceController::class , 'update'] );
Route::put('/UpdateAnnState' , [AnnonceController::class , 'updateState'] );
Route::delete('/DeleteAnn' , [AnnonceController::class , 'destroy'] );


//archive

//declarations
Route::get('/ShowDecAllArch' , [DeclarationArchController::class , 'indexAll'] );
Route::get('/ShowDecSelfArch' , [DeclarationArchController::class , 'indexSelf'] );
//declaration pictures
Route::get('/ShowPicDecArch' , [PictureDecArchController::class , 'indexIdDec'] );
//declaration rapport
Route::post('/ShowRapportArch' , [RapportArchController::class , 'index'] );  // la consultation pour le service ou le responsable


//annonce
Route::get('/ShowPicAllArch' , [AnnonceArchController::class , 'indexAll'] );
Route::get('/ShowPicSelfArch' , [AnnonceArchController::class , 'indexSelf'] );
//annonce pictures
Route::get('/ShowPicAnnArch' , [PictureAnnArchController::class , 'indexIdAnn'] );
