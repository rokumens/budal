<?php

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
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Authentication Routes
// Auth::routes();
// luffy 7 April 2020 07:29 pm #change the way url admin login 
// Login...
Route::group(['middleware' => ['web']], function() {
    Route::get('apgadm', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('apgadm', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
});
// // Regis...
// Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
// Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);
// // Password reset...
// Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
// Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
// Route::get('password/reset/{token}', ['as' => 'password.request.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
// Route::post('password/reset', ['as' => 'password.request.post', 'uses' => 'Auth\ResetPasswordController@reset']);

/*
|--------------------------------------------------------------------------
| FRONT END
|--------------------------------------------------------------------------
*/

// Homepage Route
// Route::group(['middleware' => ['web', 'checkblocked']], function () {
Route::get('/', 'Frontend\HomeController@index')->name('home');
Route::get('/terms', 'TermsController@terms')->name('terms');

// Ajax
Route::post('ajax/livedraw/gettime', 'Frontend\AjaxController@gettime')->name('ajax.livedraw.gettime');
Route::post('ajax/livedraw/getnumberbydate', 'Frontend\AjaxController@getNumberByDate');
/*
|--------------------------------------------------------------------------
| BACK END
|--------------------------------------------------------------------------
*/

// Public Routes
Route::group(['middleware' => ['web', 'activity', 'checkblocked']], function () {
  Route::get('/', 'Frontend\HomeController@index')->name('home');
  Route::get('/terms', 'TermsController@terms')->name('terms');
  Route::get('/result', 'Frontend\HomeController@result');
  Route::get('/livedraw', 'Frontend\HomeController@livedraw');
  Route::get('/about', 'Frontend\HomeController@about');
  Route::get('/contact', 'Frontend\HomeController@contact');

  // Sitemap Route luffy 12 May 2020 02:02 pm
  Route::get('/sitemap.xml', 'Frontend\SitemapController@index')->name('sitemap.xml');
  
  // // Activation Routes
  // Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

  // Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
  // Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
  // Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

  // // Socialite Register Routes
  // Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
  // Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

  // // Route to for user to reactivate their user deleted account.
  // Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'checkblocked']], function () {
  // // Activation Routes
  // Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
  // Numbers Routes
  Route::get('apgadm/numbers', 'NumbersController@index')->name('apgadm/numbers');
  Route::post('apgadm/numbers/store', 'NumbersController@store')->name('apgadm/numbers/store');
  Route::post('apgadm/numbers', 'NumbersController@edit');
  Route::put('apgadm/numbers', 'NumbersController@update')->name('apgadm/numbers');
  Route::delete('apgadm/numbers/{id}', 'NumbersController@destroy');
  Route::post('search-numbers', 'NumbersController@search')->name('search-numbers');
  // Prize Routes
  Route::get('apgadm/prize/{id}', 'NumbersController@Prize');
  // ------------------------ Settings route ------------------------ //
  // General settings
  Route::get('apgadm/settings/general', 'SettingGeneralController@index')->name("settings-general");
  Route::post('apgadm/settings/general/store', 'SettingGeneralController@store')->name('apgadm/settings/general/store');
  Route::get('apgadm/settings/general/edit/{id}', 'SettingGeneralController@edit');
  Route::post('apgadm/settings/general/update', 'SettingGeneralController@update')->name('apgadm/settings/general/update');
  Route::get('apgadm/settings/general/delete/{id}/{type}', 'SettingGeneralController@destroy');
  Route::get('apgadm/settings/general/terminator/{id}', 'SettingGeneralController@terminator');
  Route::get('apgadm/settings/general/level/{id}/{type}', 'SettingGeneralController@level');
  Route::post('apgadm/settings/general/ajaxEdit', 'SettingGeneralController@ajaxEdit');
  // Numbers
  Route::get('apgadm/settings/numbers', 'SettingNumbersController@index');
  Route::post('apgadm/settings/numbers/update', 'SettingNumbersController@update')->name('apgadm/settings/numbers/update');
  // Seo
  Route::get('apgadm/settings/seo', 'SettingSeoController@index')->name("settings-seo");;
  Route::post('apgadm/settings/seo/store', 'SettingSeoController@store')->name('apgadm/settings/seo/store');
  Route::get('apgadm/settings/seo/edit/{id}', 'SettingSeoController@edit');
  Route::post('apgadm/settings/seo/update', 'SettingSeoController@update')->name('apgadm/settings/seo/update');
  Route::delete('apgadm/settings/seo/destroy/', 'SettingSeoController@destroy')->name('apgadm/settings/seo/destroy');
  // Pop Up
  Route::get('apgadm/settings/popup', 'SettingPopupController@index');
  Route::post('apgadm/settings/popup/update', 'SettingPopupController@update')->name('apgadm/settings/popup/update');
  // ------------------------ End settings route ------------------------ //
  // luffy 11 april 2020 11:51 am
  //  Apgadm Dashboard - Redirect the user after login to apgadmin.
  Route::get('apgadm/dashboard', ['as' => 'admin.dashboard',   'uses' => 'NumbersController@index']);
  Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');

  /*
  |--------------------------------------------------------------------------
  | DEV Tools -> STAY AWAY!!! Development and debugging purpose only!!!
  |--------------------------------------------------------------------------
  */
  Route::get('devtools/index', 'DevtoolsController@index');
  Route::get('devtools/purge/prize', 'DevtoolsController@purge')->name('devtools/purge/prize');
  Route::get('devtools/purge/winner', 'DevtoolsController@purge')->name('devtools/purge/winner');
  Route::get('devtools/purge/starter', 'DevtoolsController@purge')->name('devtools/purge/starter');
  Route::get('devtools/purge/consolation', 'DevtoolsController@purge')->name('devtools/purge/consolation');
  Route::get('devtools/livedraw/generatetimeshow', 'DevtoolsController@generatetimeshow')->name('devtools/livedraw/generatetimeshow');
  Route::get('devtools/truncate/{type}', 'DevtoolsController@truncate');
  Route::get('devtools/generator', 'DevtoolsController@generator');
  Route::post('devtools/generator/generate', 'DevtoolsController@generate_number');
  /*
  |--------------------------------------------------------------------------
  | END Devtools
  |--------------------------------------------------------------------------
  */
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep', 'checkblocked']], function () {
  // Route::prefix('apgadm')->group(function () {
    // luffy 11 april 2020 11:51 am
    //  Apgadm Dashboard - Redirect the user after login to apgadmin.
    Route::get('apgadm/dashboard', ['as' => 'admin.dashboard',   'uses' => 'NumbersController@index']);
    // Show users profile - viewable by other users.
    Route::get('apgadm/profile/{username}', [
      'as'   => '{username}',
      'uses' => 'ProfilesController@show',
    ]);
  // });
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep', 'checkblocked']], function () {
  Route::prefix('apgadm')->group(function () {
    // User Profile and Account Routes
    Route::resource(
      'profile',
      'ProfilesController',
      [
        'only' => [
          'show',
          'edit',
          'update',
          'create',
        ],
      ]
    );
    Route::put('profile/{username}/updateUserAccount', [
      'as'   => '{username}',
      'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
      'as'   => '{username}',
      'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
      'as'   => '{username}',
      'uses' => 'ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
      'uses' => 'ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);

  });

});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity', 'twostep', 'checkblocked']], function () {

  // Route::prefix('apgadm')->group(function () {

    Route::resource('/users/deleted', 'SoftDeletesController', [
      'only' => [
        'index', 'show', 'update', 'destroy',
      ],
    ]);

    Route::resource('users', 'UsersManagementController', [
      'names' => [
        'index'   => 'users',
        'destroy' => 'user.destroy',
      ],
      'except' => [
        'deleted',
      ],
    ]);
    Route::post('search-users', 'UsersManagementController@search')->name('search-users');

    Route::resource('themes', 'ThemesManagementController', [
      'names' => [
        'index'   => 'themes',
        'destroy' => 'themes.destroy',
      ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'AdminDetailsController@listRoutes');
    Route::get('active-users', 'AdminDetailsController@activeUsers');

  // });
});

Route::redirect('/php', '/phpinfo', 301);
