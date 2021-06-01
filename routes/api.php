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

Route::middleware('auth:api')->get('/user', 'UserController@AuthRouteAPI');

Route::apiResource('/jobs', 'JobApiController');
// API develop for ionic mobile application 2020-01-14

/**
 * Technician login 
 * Param : email, password
 * Date: 2020-01-14
 */
Route::get('/login', array('middleware' => 'cors', 'uses' => 'Api\TechController@login'))->name('api.get.tech.login');
Route::get('/logout', array('middleware' => 'cors', 'uses' => 'Api\TechController@logout'))->name('api.get.tech.logout');
Route::get('/storelocation', array('middleware' => 'cors', 'uses' => 'Api\TechController@storelocation'))->name('api.get.tech.logout');

Route::get('/update_technician', array('middleware' => 'cors', 'uses' => 'Api\TechController@updateTechnician'))->name('api.get.tech.update');
/**
 * Get Callout list
 * Param : round_id
 * Date: 2020-01-15
 */
Route::get('/callout_list', array('middleware' => 'cors', 'uses' => 'Api\TechController@getCalloutlist'))->name('api.get.callout.list');
Route::get('/callout_detail', array('middleware' => 'cors', 'uses' => 'Api\TechController@getCalloutdetail'))->name('api.get.callout.detail');
Route::get('/docket_detail', array('middleware' => 'cors', 'uses' => 'Api\TechController@getCalloutDocketdetail'))->name('api.get.docket.detail');
Route::get('/callout_action', array('middleware' => 'cors', 'uses' => 'Api\TechController@updateCalloutaction'));
Route::get('/callout_docket_action', array('middleware' => 'cors', 'uses' => 'Api\TechController@updateCalloutDocektaction'));
Route::get('/callout_closed_list', array('middleware' => 'cors', 'uses' => 'Api\TechController@getCalloutClosedlist'))->name('api.get.callout.closedlist');
Route::get('/callout_recent', array('middleware' => 'cors', 'uses' => 'Api\TechController@getRecentCallouts'))->name('api.get.callout.recentCallouts');

Route::get('/lift_detail', array('middleware' => 'cors', 'uses' => 'Api\TechController@getLiftdetail'))->name('api.get.lift.detail');
Route::get('/lift_update', array('middleware' => 'cors', 'uses' => 'Api\TechController@updateLift'))->name('api.get.lift.update');
Route::get('/calloutsendemail', array('middleware' => 'cors', 'uses' => 'Api\TechController@calloutSendEmail'));
Route::get('/calloutsendprint', array('middleware' => 'cors', 'uses' => 'Api\TechController@calloutSendPrint'));


Route::post('/callout_upload_image', array('middleware' => 'cors', 'uses' => 'Api\TechController@calloutUPloadImage'));
Route::get('/callout_delete_image', array('middleware' => 'cors', 'uses' => 'Api\TechController@deleteCalloutImage'));

/**
 * Get Maintenance List
 *  */
Route::get('/maintenance_list', array('middleware' => 'cors', 'uses' => 'Api\TechController@getMaintenanceList'))->name('api.get.maintenance.list');
Route::get('/maintenance_detail', array('middleware' => 'cors', 'uses' => 'Api\TechController@getMaintenanceDetail'))->name('api.get.maintenance.detail');
Route::get('/maintenance_update', array('middleware' => 'cors', 'uses' => 'Api\TechController@maintenanceUpdate'))->name('api.get.maintenance.update');
Route::get('/maintenance_creation', array('middleware' => 'cors', 'uses' => 'Api\TechController@getCreationMaintenance'))->name('api.get.maintenance.creation');
Route::get('/maintenance_create', array('middleware' => 'cors', 'uses' => 'Api\TechController@postCreateMaintenance'))->name('api.post.maintenance.creation');
Route::get('/maintenance_list_closed', array('middleware' => 'cors', 'uses' => 'Api\TechController@getMaintenanceClosedList'))->name('api.get.maintenance.closedlist');
Route::get('/maintenancesendemail', array('middleware' => 'cors', 'uses' => 'Api\TechController@maintenanceSendEmail'));
Route::get('/maintenancesendprint', array('middleware' => 'cors', 'uses' => 'Api\TechController@maintenanceSendPrint'));
Route::get('/tasks/sopa', array('middleware' => 'cors', 'uses' => 'Api\TechController@getSOPATasks'));
Route::get('/tasks/sopa/save', array('middleware' => 'cors', 'uses' => 'Api\TechController@saveSOPATasks'));


/**
 * Get Jobs 
 */
Route::get('/job_list', array('middleware' => 'cors', 'uses' => 'Api\TechController@getJobsList'))->name('api.get.job.list');
Route::get('/job_detail', array('middleware' => 'cors', 'uses' => 'Api\TechController@getJobDetail'))->name('api.get.job.detail');
Route::get('/job_more_detail', array('middleware' => 'cors', 'uses' => 'Api\TechController@getJobMoreDetail'));
Route::get('/job_maintenace_gettasks', array('middleware' => 'cors', 'uses' => 'Api\TechController@getMaintenanceTasks'))->name('api.get.job.detail');
Route::get('/job_maintenance_create', array('middleware' => 'cors', 'uses' => 'Api\TechController@postCreateJobMaintenanceTasks'));
Route::get('/callout_create', array('middleware' => 'cors', 'uses' => 'Api\TechController@postCreateJobCallout'));
Route::get('/job_lifts', array('middleware' => 'cors', 'uses' => 'Api\TechController@getJobLifts'));

/**
 * RealTime tracking gps
 */
Route::get('/sendgps', array('middleware' => 'cors', 'uses' => 'Api\LocationtrackerController@start'));
Route::get('/stopgps', array('middleware' => 'cors', 'uses' => 'Api\LocationtrackerController@stop'));

/**
 * Get ChecklistActivities
 */

Route::get('/maintenance/checklistactivities', array('middleware' => 'cors', 'uses' => 'Api\TechController@getChecklistActivities'));
Route::get('/maintenance/savechecklist', array('middleware' => 'cors', 'uses' => 'Api\TechController@saveChecklistActivities'));
