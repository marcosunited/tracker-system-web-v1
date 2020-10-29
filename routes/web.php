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

// Example Routes

Auth::routes();
Route::view('/', 'auth/login');


Route::get('/dashboard', 'DashboardController@index')->middleware('auth');
Route::post('/getreloadmap','DashboardController@reloadmap')->middleware('auth');
//Jobs
Route::get('/jobs/all', 'JobController@index')->middleware('auth');
Route::get('/jobs/create', 'JobController@create')->middleware('auth');
Route::post('/jobs/create', 'JobController@store')->middleware('auth');
Route::get('/jobs/{job}', 'JobController@show')->middleware('auth');
Route::patch('/jobs/{job}', 'JobController@edit')->middleware('auth');
Route::get('/jobs/{job}/callouts', 'JobController@callouts')->middleware('auth');
Route::get('/jobs/{job}/maintenances', 'JobController@maintenances')->middleware('auth');
Route::get('/jobs/{job}/repairs', 'JobController@repairs')->middleware('auth');
Route::get('/jobs/{job}/file', 'JobController@file')->middleware('auth');
Route::post('/jobs/{job}/file', 'JobController@uploadfile')->middleware('auth');
Route::delete('/jobs/{job}/file/{file}', 'JobController@deletefile')->middleware('auth');
Route::get('/jobs/{job}/notes', 'JobController@notes')->middleware('auth');
Route::post('/jobs/{job}/notes', 'JobController@addnotes')->middleware('auth');
Route::delete('/jobs/{job}/notes/{note}', 'JobController@deletenote')->middleware('auth');
Route::get('/jobs/{job}/rounds', 'JobController@round')->middleware('auth');


//Lifts
Route::get('/jobs/{job}/lifts', 'LiftController@index')->middleware('auth');
Route::get('/jobs/{job}/lifts/{lift}/callouts', 'LiftController@callouts')->middleware('auth');
Route::get('/jobs/{job}/lifts/{lift}', 'LiftController@edit')->middleware('auth');
Route::patch('/jobs/{job}/lifts/{lift}', 'LiftController@update')->middleware('auth');
Route::delete('/jobs/{job}/lifts/{lift}', 'LiftController@destroy')->middleware('auth');
Route::post('/jobs/{job}/lifts', 'LiftController@store')->middleware('auth');

//Rounds
Route::get('/rounds', 'RoundController@index')->middleware('auth');
Route::get('/rounds/create', 'RoundController@create')->middleware('auth');
Route::post('/rounds', 'RoundController@store')->middleware('auth');
Route::get('/rounds/{round}', 'RoundController@show')->middleware('auth');
Route::patch('/rounds/{round}', 'RoundController@update')->middleware('auth');
Route::get('/rounds/{round}/jobs', 'RoundController@jobs')->middleware('auth');
Route::get('/rounds/{round}/techs', 'RoundController@techs')->middleware('auth');

//Techs
Route::get('/techs', 'TechController@index')->middleware('auth');
Route::get('/techs/create', 'TechController@create')->middleware('auth');
Route::post('/techs', 'TechController@store')->middleware('auth');
Route::get('/techs/{tech}', 'TechController@show')->middleware('auth');
Route::patch('/techs/{tech}', 'TechController@update')->middleware('auth');
Route::get('/techs/{tech}/jobs', 'TechController@jobs')->middleware('auth');
Route::get('/techs/{tech}/callouts', 'TechController@callouts')->middleware('auth');
Route::get('/techs/{tech}/maintenances', 'TechController@maintenances')->middleware('auth');
Route::delete('/techs/{tech}', 'TechController@delete')->middleware('auth');


//Agents
Route::get('/agents', 'AgentController@index')->middleware('auth');
Route::get('/agents/create', 'AgentController@create')->middleware('auth');
Route::post('/agents', 'AgentController@store')->middleware('auth');
Route::get('/agents/{agent}', 'AgentController@show')->middleware('auth');
Route::patch('/agents/{agent}', 'AgentController@update')->middleware('auth');
Route::get('/agents/{agent}/jobs', 'AgentController@jobs')->middleware('auth');
Route::delete('/agents/{agent}', 'AgentController@destroy')->middleware('auth');

//Callouts
Route::get('/callouts/opencallouts', 'CalloutController@open')->middleware('auth');
Route::get('/callouts/closedcallouts', 'CalloutController@closed')->middleware('auth');
Route::get('/callouts/followupcallouts', 'CalloutController@followup')->middleware('auth');
Route::get('/callouts/shutdowncallouts', 'CalloutController@shutdown')->middleware('auth');
Route::get('/callouts/underrepaircallouts', 'CalloutController@underrepair')->middleware('auth');;
Route::get('/callouts/create', 'CalloutController@create')->middleware('auth');
Route::post('/callouts/create', 'CalloutController@create')->middleware('auth');
Route::get('/callouts/{callout}', 'CalloutController@show')->middleware('auth');
Route::get('/callouts/{callout}/techdetails', 'CalloutController@techdetails')->middleware('auth');
Route::patch('/callouts/{callout}/techdetails', 'CalloutController@techupdate')->middleware('auth');
Route::post('/callouts/add', 'CalloutController@store')->middleware('auth');
Route::patch('/callouts/{callout}', 'CalloutController@update')->middleware('auth');
Route::delete('/callouts/{callout}', 'CalloutController@destroy')->middleware('auth');
Route::get('/callouts/{callout}/jobdetails', 'CalloutController@calloutjob')->middleware('auth');
Route::get('/callouts/{callout}/round', 'CalloutController@round')->middleware('auth');
Route::get('/callouts/{callout}/file', 'CalloutController@file')->middleware('auth');
Route::post('/callouts/{callout}/file', 'CalloutController@uploadfile')->middleware('auth');
Route::delete('/callouts/{callout}/file/{file}', 'CalloutController@deletefile')->middleware('auth');
Route::get('/callouts/{callout}/notes', 'CalloutController@notes')->middleware('auth');
Route::post('/callouts/{callout}/notes', 'CalloutController@addnotes')->middleware('auth');
Route::delete('/callouts/{callout}/notes/{note}', 'CalloutController@deletenote')->middleware('auth');
Route::post('/callouts/selectedJob', 'CalloutController@selectedJob')->middleware('auth');

//PDF
Route::get('/callouts/{callout}/pdf', 'CalloutController@pdf')->middleware('auth');
Route::get('/maintenances/{maintenance}/pdf', 'MaintenanceController@pdf')->middleware('auth');
Route::get('/repairs/{repair}/pdf', 'RepairController@pdf')->middleware('auth');

//Correction
Route::get('/correction', 'CorrectionController@index')->middleware('auth');
Route::get('/correction/add', 'CorrectionController@create')->middleware('auth');
Route::post('/correction', 'CorrectionController@store')->middleware('auth');
Route::get('/correction/{correction}', 'CorrectionController@show')->middleware('auth');
Route::post('/correction/{correction}', 'CorrectionController@update')->middleware('auth');
Route::delete('/correction/{correction}', 'CorrectionController@destroy')->middleware('auth');

//Fault
Route::get('/fault', 'FaultController@index')->middleware('auth');
Route::get('/fault/add', 'FaultController@create')->middleware('auth');
Route::post('/fault', 'FaultController@store')->middleware('auth');
Route::get('/fault/{fault}', 'FaultController@show')->middleware('auth');
Route::post('/fault/{fault}', 'FaultController@update')->middleware('auth');
Route::delete('/fault/{fault}', 'FaultController@destroy')->middleware('auth');

//Print Callout
Route::get('/callouts/{callout}/print', 'CalloutController@print');
Route::post('/callouts/calloutsendemail','CalloutController@calloutSendEmail')->middleware('auth');
Route::post('/callouts/calloutprint','CalloutController@calloutPrint')->middleware('auth');
//Print Maintenance
Route::get('/maintenances/{mainid}/print', 'MaintenanceController@print');
Route::post('/maintenances/maintenancesendemail','MaintenanceController@maintenanceSendEmail')->middleware('auth');
Route::post('/maintenances/maintenanceprint','MaintenanceController@maintenancePrint')->middleware('auth');
//Print Repair
Route::get('/repairs/{repair}/print', 'RepairController@print');

//Maintenance
Route::get('/maintenances/create', 'MaintenanceController@create')->middleware('auth');
Route::get('/maintenances/{maintenance}/tasks', 'MaintenanceController@tasks')->middleware('auth');
Route::get('/maintenances/pendingmaintenances', 'MaintenanceController@pending')->middleware('auth');
Route::get('/maintenances/finishedmaintenances', 'MaintenanceController@finished')->middleware('auth');
Route::post('/maintenances/add', 'MaintenanceController@store')->middleware('auth');
Route::post('/maintenances/sopa', 'MaintenanceController@sopaTasks')->middleware('auth');
Route::post('/maintenances/selecttasks', 'MaintenanceController@selecttasks')->middleware('auth');
Route::get('/maintenances/{maintenance}', 'MaintenanceController@edit')->middleware('auth');
Route::patch('/maintenances/{maintenance}', 'MaintenanceController@update')->middleware('auth');
Route::delete('/maintenances/{maintenance}', 'MaintenanceController@destroy')->middleware('auth');
Route::get('/maintenances/{maintenance}/techdetails', 'MaintenanceController@techdetails')->middleware('auth');
Route::patch('/maintenances/{maintenance}/techdetails', 'MaintenanceController@techupdate')->middleware('auth');
Route::get('/maintenances/{maintenance}/jobdetails', 'MaintenanceController@maintenancejob')->middleware('auth');
Route::get('/maintenances/{maintenance}/round', 'MaintenanceController@round')->middleware('auth');
Route::get('/maintenances/{maintenance}/file', 'MaintenanceController@file')->middleware('auth');
Route::post('/maintenances/{maintenance}/file', 'MaintenanceController@uploadfile')->middleware('auth');
Route::delete('/maintenances/{maintenance}/file/{file}', 'MaintenanceController@deletefile')->middleware('auth');
Route::get('/maintenances/{maintenance}/notes', 'MaintenanceController@notes')->middleware('auth');
Route::post('/maintenances/{maintenance}/notes', 'MaintenanceController@addnotes')->middleware('auth');
Route::delete('/maintenances/{maintenance}/notes/{note}', 'MaintenanceController@deletenote')->middleware('auth');

//Repair
Route::get('/repairs/create', 'RepairController@create')->middleware('auth');
Route::get('/repairs/open', 'RepairController@open')->middleware('auth');
Route::get('/repairs/closed', 'RepairController@closed')->middleware('auth');
Route::post('/repairs/selectedJob', 'RepairController@selectedJob')->middleware('auth');
Route::post('/repairs/add', 'RepairController@store')->middleware('auth');
Route::get('/repairs/{repair}', 'RepairController@show')->middleware('auth');
Route::patch('/repairs/{repair}', 'RepairController@update')->middleware('auth');
Route::delete('/repairs/{repair}', 'RepairController@destroy')->middleware('auth');
Route::get('/repairs/{repair}/techdetails', 'RepairController@techdetails')->middleware('auth');
Route::patch('/repairs/{repair}/techdetails', 'RepairController@techupdate')->middleware('auth');
Route::get('/repairs/{repair}/jobdetails', 'RepairController@repairjob')->middleware('auth');
Route::get('/repairs/{repair}/round', 'RepairController@round')->middleware('auth');
Route::get('/repairs/{repair}/file', 'RepairController@file')->middleware('auth');
Route::post('/repairs/{repair}/file', 'RepairController@uploadfile')->middleware('auth');
Route::delete('/repairs/{repair}/file/{file}', 'RepairController@deletefile')->middleware('auth');
Route::get('/repairs/{repair}/notes', 'RepairController@notes')->middleware('auth');
Route::post('/repairs/{repair}/notes', 'RepairController@addnotes')->middleware('auth');
Route::delete('/repairs/{repair}/notes/{note}', 'RepairController@deletenote')->middleware('auth');

//Reports-old
Route::get('/reports/old/sitereport', 'ReportOldController@sitereport')->middleware('auth');
Route::post('/reports/old/sitereport/generate', 'ReportOldController@sitereportgenerate')->middleware('auth');
Route::get('/reports/old/groupreport', 'ReportOldController@groupreport')->middleware('auth');
Route::post('/reports/old/groupreport/generate', 'ReportOldController@groupreportgenerate')->middleware('auth');
Route::get('/reports/old/calloutreport', 'ReportOldController@calloutreport')->middleware('auth');
Route::post('/reports/old/calloutreport/generate', 'ReportOldController@calloutreportgenerate')->middleware('auth');
Route::get('/reports/old/maintenancereport', 'ReportOldController@maintenancereport')->middleware('auth');
Route::post('/reports/old/maintenancereport/generate', 'ReportOldController@maintenanecreportgenerate')->middleware('auth');
Route::get('/reports/old/pitcleaning', 'ReportOldController@pitcleaning')->middleware('auth');
Route::post('/reports/old/pitcleaning/generate', 'ReportOldController@pitcleaninggenerate')->middleware('auth');
Route::get('/reports/old/period', 'ReportOldController@period')->middleware('auth');
Route::post('/reports/old/period/generate', 'ReportOldController@periodgenerate')->middleware('auth');
Route::post('/reports/selectedJob', 'ReportOldController@selectedJob')->middleware('auth');

//Reports-new
Route::get('/reports/new/sitereport', 'ReportNewController@sitereport')->middleware('auth');
Route::post('/reports/new/sitereport/generate', 'ReportNewController@sitereportgenerate')->middleware('auth');
Route::get('/reports/new/groupreport', 'ReportNewController@groupreport')->middleware('auth');
Route::get('/reports/new/groupreport/pdf', 'ReportNewController@pdf')->middleware('auth');
Route::post('/reports/new/groupreport/generate', 'ReportNewController@groupreportgenerate')->middleware('auth');
Route::get('/reports/new/calloutreport', 'ReportNewController@calloutreport')->middleware('auth');
Route::post('/reports/new/calloutreport/generate', 'ReportNewController@calloutreportgenerate')->middleware('auth');
Route::get('/reports/new/maintenancereport', 'ReportNewController@maintenancereport')->middleware('auth');
Route::post('/reports/new/maintenancereport/generate', 'ReportNewController@maintenanecreportgenerate')->middleware('auth');
Route::get('/reports/new/pitcleaning', 'ReportNewController@pitcleaning')->middleware('auth');
Route::post('/reports/new/pitcleaning/generate', 'ReportNewController@pitcleaninggenerate')->middleware('auth');
Route::get('/reports/new/period', 'ReportNewController@period')->middleware('auth');
Route::post('/reports/new/period/generate', 'ReportNewController@periodgenerate')->middleware('auth');
Route::post('/reports/selectedJob', 'ReportNewController@selectedJob')->middleware('auth');

//Custom reports
Route::get('/reports/new/custom-report', 'ReportNewController@customReportCompliance')->middleware('auth');

Route::view('/callouts/plugin', 'callouts.plugin')->middleware('auth');;
Route::view('/callouts/blank', 'callouts.blank')->middleware('auth');;

/**
 * Lift Task
 *  */
//Jobs
Route::get('/tasks/l/all', 'TaskController@index_lift')->middleware('auth');
Route::get('/tasks/e/all', 'TaskController@index_escalator')->middleware('auth');
Route::get('/tasks/create', 'TaskController@create')->middleware('auth');
Route::post('/tasks', 'TaskController@store')->middleware('auth');
Route::get('/task/{type}/{id}', 'TaskController@show')->middleware('auth');
Route::post('/task/{type}/{id}', 'TaskController@update')->middleware('auth');


