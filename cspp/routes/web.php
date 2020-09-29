<?php

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

// 10 May 2020 05:05 pm
// luffy note: login, register, logout, dah di set by vendor - base.php.
// ga perlu ditampilkan lagi di sini.

Route::get('/', 'DashboardController@to_login');
// register
Route::get('register', 'Admin\Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
Route::post('register', 'Admin\Auth\RegisterController@register');

Route::group(['middleware' => ['web']], function () {
  // Dashboard
  Route::get('dashboard', 'DashboardController@index');
});

// backpack route
Route::group(['middleware' => ['permission:manage-users']], function () {
  Route::crud('user', 'UserCrudController');
  Route::get('user/deleted', 'UsersController@index');
  Route::get('ajaxdata/user/deleted', 'UsersController@getdata')->name('ajaxdata.user.deleted');
  Route::get('user/deleted/{id}/restore', 'UsersController@restore');
});
Route::group(['middleware' => ['permission:manage-roles']], function () {
  Route::crud('role', 'RoleCrudController');
});
Route::group(['middleware' => ['permission:manage-permissions']], function () {
  Route::crud('permission', 'PermissionCrudController');
});
// end backpack route

// profile
Route::group(['middleware' => ['permission:menu-profile']], function () {
  Route::get('edit-account-info', 'MyAccountController@getAccountInfoForm')->name('backpack.account.info');
  Route::post('edit-account-info', 'MyAccountController@postAccountInfoForm');
  Route::post('change-password', 'MyAccountController@postChangePasswordForm')->name('backpack.account.password');
});

// public ajax -----------------------------------------------------------------//
// Master Number ajax
Route::post('ajax-master-numbers', 'MasterNumbersController@ajaxGetById')->name('ajax-master-numbers');
// get connect response
Route::get('get-connect-response', 'ConnectResponseController@get_connect_response')->name('get-connect-response');
// Constant Yes No ajax
Route::post('ajax-constant-yesno', 'ConstantYesnoController@ajaxGetById')->name('ajax-constant-yesno');
// ajax connect response
Route::post('ajax-connect-response', 'ConnectResponseController@ajaxGetById')->name('ajax-connect-response');
Route::post('connect-response/insert', 'ConnectResponseController@store');
Route::post('connect-response/update/{id}', 'ConnectResponseController@update');
Route::get('connect-response/delete/{id}', 'ConnectResponseController@destroy');
// ajax campaign result
Route::post('ajax-campaign-result', 'CampaignResultsController@ajaxGetById')->name('ajax-campaign-result');
Route::post('campaign-result/insert', 'CampaignResultsController@store');
Route::post('campaign-result/update/{id}', 'CampaignResultsController@update');
Route::get('campaign-result/delete/{id}', 'CampaignResultsController@destroy');
// ajax next action
Route::post('ajax-next-action', 'NextActionsController@ajaxGetById')->name('ajax-next-action');
Route::post('next-action/insert', 'NextActionsController@store');
Route::post('next-action/update/{id}', 'NextActionsController@update');
Route::get('next-action/delete/{id}', 'NextActionsController@destroy');
// ajax category game
Route::post('ajax-category-game', 'CategoryGameController@ajaxGetById')->name('ajax-category-game');
Route::post('category-game/insert', 'CategoryGameController@store');
Route::post('category-game/update/{id}', 'CategoryGameController@update');
Route::get('category-game/delete/{id}', 'CategoryGameController@destroy');
// ajax category game
Route::post('ajax-category-web', 'CategoryWebController@ajaxGetById')->name('ajax-category-web');
Route::post('category-web/insert', 'CategoryWebController@store');
Route::post('category-web/update/{id}', 'CategoryWebController@update');
Route::get('category-web/delete/{id}', 'CategoryWebController@destroy');
//-------------------------------------------------------------------------//

// demo cs
Route::group(['middleware' => ['permission:demo-leader']], function () {
  // Route::get('/demoleader', function(){
  //   return redirect('uploads\demo-leader');
  // });
  Route::get('/demoleader', 'DashboardController@to_demo_leader');
});

// demo cs
Route::group(['middleware' => ['permission:demo-cs']], function () {
  // Route::get('/democs', function(){
  //   return redirect('uploads\demo-cs');
  // });
  Route::get('/democs', 'DashboardController@to_demo_cs');

});

// Route::get('admin/dashboard', function(){
//   return redirect('dashboard');
// });

// upload numbers
Route::group(['middleware' => ['permission:menu-upload']], function () {
  Route::get('numbers/upload', 'UploadsController@index');
  Route::post('numbers/upload/import', 'UploadsController@import');
  // example excel
  Route::get('/file-download', 'DashboardController@file_example');
});

// Newnumbers
Route::group(['middleware' => ['permission:menu-newnumbers']], function () {
  Route::get('ajaxdata/getdataNewnumbers', 'NewnumbersController@getdata')->name('ajaxdata.getdataNewnumbers');
  Route::get('numbers/newnumbers', 'NewnumbersController@index');
  Route::post('numbers/newnumbers/assignto', ['as'=>'numbers.newnumbers.assignto','uses'=>'NewnumbersController@assignto']);
  Route::post('search-newnumbers', 'NewnumbersController@search')->name('search-newnumbers');
});

// Assigned
Route::group(['middleware' => ['permission:menu-assigned']], function () {
  Route::get('ajaxdata/getdataAssigned', 'AssignedController@getdata')->name('ajaxdata.getdataAssigned');
  Route::get('numbers/assigned', 'AssignedController@index');
  Route::post('numbers/assigned/assignto', ['as'=>'numbers.assigned.assignto','uses'=>'AssignedController@assignto']);
  Route::post('search-assigned', 'AssignedController@search')->name('search-assigned');
  Route::get('assigned-update', 'AssignedController@assignedUpdateModal');
  Route::resource('assigned-update','AssignedController',['parameters'=> ['assigned-update'=>'id']]);
});

// contacted
Route::group(['middleware' => ['permission:menu-contacted']], function () {
  Route::get('ajaxdata/getdataContacted', 'ContactedController@getdata')->name('ajaxdata.getdataContacted');
  Route::get('numbers/contacted', 'ContactedController@index');
  Route::post('numbers/contacted/assignto', ['as'=>'numbers.contacted.assignto','uses'=>'ContactedController@assignto']);
  Route::post('search-contacted', 'ContactedController@search')->name('search-contacted');
  Route::get('contacted-update', 'ContactedController@contactedUpdateModal');
  Route::resource('contacted-update','ContactedController',['parameters'=> ['contacted-update'=>'id']]);
});

// interested
Route::group(['middleware' => ['permission:menu-interested']], function () {
  Route::get('ajaxdata/getdataInterested', 'InterestedController@getdata')->name('ajaxdata.getdataInterested');
  Route::get('numbers/followup/interested', 'InterestedController@index');
  Route::post('numbers/interested/assignto', ['as'=>'numbers.interested.assignto','uses'=>'NewnumbersController@assignto']);
  Route::post('search-interested', 'InterestedController@search')->name('search-interested');
  Route::post('get-interested-ajax', 'InterestedController@getInterestedAjax')->name('get-interested-ajax');
  Route::post('numbers/interested/assignto', ['as'=>'numbers.interested.assignto','uses'=>'InterestedController@assignto']);
  Route::get('interested-update', 'InterestedController@interestedUpdateModal');
  Route::resource('interested-update','InterestedController',['parameters'=> ['interested-update'=>'id']]);
});

// registered
Route::group(['middleware' => ['permission:menu-registered']], function () {
  Route::get('ajaxdata/getdataRegistered', 'RegisteredController@getdata')->name('ajaxdata.getdataRegistered');
  Route::get('numbers/followup/registered', 'RegisteredController@index');
  Route::post('search-registered', 'RegisteredController@search')->name('search-registered');
  Route::post('get-registered-ajax', 'RegisteredController@getRegisteredAjax')->name('get-registered-ajax');
  Route::post('numbers/registered/assignto', ['as'=>'numbers.registered.assignto','uses'=>'RegisteredController@assignto']);
  Route::get('registered-update', 'RegisteredController@registeredUpdateModal');
  Route::resource('registered-update','RegisteredController',['parameters'=> ['registered-update'=>'id']]);
});

// check 
Route::group(['middleware' => ['permission:menu-check']], function () {
  Route::get('ajaxdata/getdataCheck', 'CheckController@getdata')->name('ajaxdata.getdataCheck');
  Route::get('numbers/leader/check', 'CheckController@index');
  Route::post('leader/check/assignto', ['as'=>'leader.check.assignto','uses'=>'CheckController@assignto']);
  Route::delete('leader/check/multiple-delete', ['as'=>'leader.check.multiple-delete','uses'=>'CheckController@multipleDelete']);
  Route::post('search-check', 'CheckController@search')->name('search-check');
  Route::resource('check-update','CheckController',['parameters'=> ['check-update'=>'id']]);
  Route::post('numbers/check/assignto', ['as'=>'numbers.check.assignto','uses'=>'CheckController@assignto']);
});

// reassign 
Route::group(['middleware' => ['permission:menu-reassign']], function () {
  Route::get('ajaxdata/getdataReassign', 'ReassignController@getdata')->name('ajaxdata.getdataReassign');
  Route::get('numbers/leader/reassign', 'ReassignController@index');
  Route::post('leader/reassign/assignto', ['as'=>'leader.reassign.assignto','uses'=>'ReassignController@assignto']);
  Route::delete('leader/reassign/multiple-delete', ['as'=>'leader.reassign.multiple-delete','uses'=>'ReassignController@multipleDelete']);
  Route::post('search-reassign', 'ReassignController@search')->name('search-reassign');
});

// players
Route::group(['middleware' => ['permission:menu-players']], function () {
  Route::get('numbers/players', 'PlayersController@index');
  Route::get('ajaxdata/getdataPlayers', 'PlayersController@getdata')->name('ajaxdata.getdataPlayers');
  Route::post('search-players', 'PlayersController@search')->name('search-players');
});

// trash numbers
Route::group(['middleware' => ['permission:menu-trash']], function () {
  Route::get('numbers/trash', 'TrashController@index');
  Route::get('ajaxdata/getdataTrash', 'TrashController@getdata')->name('ajaxdata.getdataTrash');
  Route::post('search-trash', 'TrashController@search')->name('search-trash');
});

Route::group(['middleware' => ['permission:menu-settings']], function () {
  // Settings
  Route::get('settings', 'SettingsController@index');
  Route::post('settings/update', 'SettingsController@update');
  Route::post('settings/insert', 'SettingsController@create');
});

// ------------------------------------------------------------------------------------------------------------------- //
// --------------------------------------Developer Purpose Only!------------------------------------------------------ //
// ------------------------------------------------------------------------------------------------------------------- //
// for DEV ONLY, STAY AWAY!!!!
if(!App::environment('production')){
  Route::get('/devtools/database', 'DevtoolsController@database');
  // truncate
  Route::get('/devtools/database/truncate', 'DevtoolsController@truncate');
  Route::get('/devtools/database/truncate/{type}', 'DevtoolsController@truncate');// truncate new numbers
  // remake master
  Route::get('/devtools/database/step_1', 'DevtoolsController@step_1');
  Route::get('/devtools/database/step_2', 'DevtoolsController@step_2');
  Route::get('/devtools/database/step_3', 'DevtoolsController@step_3');
  Route::get('/devtools/database/step_4', 'DevtoolsController@step_4');
  Route::get('/devtools/database/step_5', 'DevtoolsController@step_5');
  Route::get('/devtools/database/bot_step', 'DevtoolsController@bot_step');
  
  Route::get('/devtools/database/cache_flush', 'DevtoolsController@cache_flush');
}
// ------------------------------------------------------------------------------------------------------------------- //
// --------------------------------------End Developer Purpose Only!-------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------- //