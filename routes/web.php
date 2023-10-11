<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Auth::routes();
Auth::routes(['verify' => true]);


Route::group(['middleware' => ['auth','verified']], function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');
    Route::post('/dashboard/get', [App\Http\Controllers\DashboardController::class, 'dashboardInfo'])->name('dashboardInfo');

    Route::group(['middleware' => ['is-admin']], function () {
        /*************************** Products ************************************************/
        Route::get('/products', [App\Http\Controllers\MasterProductController::class, 'index'])->name('products');
        Route::get('/products/get', [App\Http\Controllers\MasterProductController::class, 'getMasterProduct']);
        Route::get('/products/add/{id?}', [App\Http\Controllers\MasterProductController::class, 'masterProductForm']);
        Route::post('/products/store', [App\Http\Controllers\MasterProductController::class, 'storeMasterProduct']);
        Route::get('/products/view/{id?}', [App\Http\Controllers\MasterProductController::class, 'masterProductVeiw']);
        Route::get('/products/delete/{id?}', [App\Http\Controllers\MasterProductController::class, 'destroy']);
        /***********************************************************************************************/

        /*************************** Top Features ************************************************/
        Route::get('/top_features', [App\Http\Controllers\TopFeaturesController::class, 'index'])->name('topfeatures');
        Route::get('/top_features/get', [App\Http\Controllers\TopFeaturesController::class, 'getTopFeatures']);
        Route::get('/top_features/add/{id?}', [App\Http\Controllers\TopFeaturesController::class, 'topFeaturesForm']);
        Route::post('/top_features/store', [App\Http\Controllers\TopFeaturesController::class, 'storeTopFeature']);
        Route::get('/top_features/view/{id?}', [App\Http\Controllers\TopFeaturesController::class, 'topFeatureVeiw']);
        Route::get('/top_features/delete/{id?}', [App\Http\Controllers\TopFeaturesController::class, 'destroy']);

        /*************************** Hardware Integration ************************************************/
        Route::get('/hardware_integrations', [App\Http\Controllers\HardwareIntegrationController::class, 'index'])->name('hardware_integration');
        Route::get('/hardware_integrations/get', [App\Http\Controllers\HardwareIntegrationController::class, 'getHardwareIntegration']);
        Route::get('/hardware_integrations/add/{id?}', [App\Http\Controllers\HardwareIntegrationController::class, 'hardwareIntegrationForm']);
        Route::post('/hardware_integrations/store', [App\Http\Controllers\HardwareIntegrationController::class, 'storeHardwareIntegration']);
        Route::get('/hardware_integrations/view/{id?}', [App\Http\Controllers\HardwareIntegrationController::class, 'hardwareIntegrationView']);
        Route::get('/hardware_integrations/delete/{id?}', [App\Http\Controllers\HardwareIntegrationController::class, 'destroy']);

        /*************************** Pricing ************************************************/
        Route::get('/pricing', [App\Http\Controllers\PricingController::class, 'index'])->name('pricing');
        Route::get('/pricing/get', [App\Http\Controllers\PricingController::class, 'getPricing']);
        Route::get('/pricing/add/{id?}', [App\Http\Controllers\PricingController::class, 'pricingForm']);
        Route::post('/pricing/store', [App\Http\Controllers\PricingController::class, 'storePricing']);
        Route::get('/pricing/view/{id?}', [App\Http\Controllers\PricingController::class, 'pricingView']);
        Route::get('/pricing/delete/{id?}', [App\Http\Controllers\PricingController::class, 'destroy']);

        /*************************** News & videos ************************************************/
        Route::get('/news_videos', [App\Http\Controllers\NewsVideosController::class, 'index'])->name('news_videos');
        Route::get('/news_videos/get', [App\Http\Controllers\NewsVideosController::class, 'getNewsVideos']);
        Route::get('/news_videos/add/{id?}', [App\Http\Controllers\NewsVideosController::class, 'newsVideosForm']);
        Route::post('/news_videos/store', [App\Http\Controllers\NewsVideosController::class, 'storeNewsVideos']);
        Route::get('/news_videos/view/{id?}', [App\Http\Controllers\NewsVideosController::class, 'newsVideosVeiw']);
        Route::get('/news_videos/delete/{id?}', [App\Http\Controllers\NewsVideosController::class, 'destroy']);

        /*************************** Knowledge Base ************************************************/
        Route::get('/knowledge_base', [App\Http\Controllers\KnowledgeBaseController::class, 'index'])->name('knowledge_base');
        Route::get('/knowledge_base/get', [App\Http\Controllers\KnowledgeBaseController::class, 'getKnowledgeBase']);
        Route::get('/knowledge_base/add/{id?}', [App\Http\Controllers\KnowledgeBaseController::class, 'knowledgeBaseForm']);
        Route::post('/knowledge_base/store', [App\Http\Controllers\KnowledgeBaseController::class, 'storeKnowledgeBase']);
        Route::get('/knowledge_base/view/{id?}', [App\Http\Controllers\KnowledgeBaseController::class, 'knowledgeBaseView']);
        Route::get('/knowledge_base/delete/{id?}', [App\Http\Controllers\KnowledgeBaseController::class, 'destroy']);

        /*************************** Server Status ************************************************/
        Route::get('/server_status', [App\Http\Controllers\ServerStatusController::class, 'index'])->name('server_status');
        Route::post('/server_status/store', [App\Http\Controllers\ServerStatusController::class, 'storeServerStatus']);
        /***************************************************************************/

        /*************************** Users ************************************************/
        Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
        Route::get('/users/get', [App\Http\Controllers\UsersController::class, 'getUsers']);
        Route::get('/users/add/{id?}', [App\Http\Controllers\UsersController::class, 'UserForm']);
        Route::post('/users/store', [App\Http\Controllers\UsersController::class, 'storeUser']);
        Route::get('/users/view/{id?}', [App\Http\Controllers\UsersController::class, 'UserView']);
        Route::get('/users/delete/{id?}', [App\Http\Controllers\UsersController::class, 'destroy']);
        /***********************************************************************************************/

    });
});
