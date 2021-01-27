<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* @START: Front End Routes */


Route::get('/clear', function() {

	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	Artisan::call('config:cache');
	Artisan::call('view:clear');
 
	return "Cleared!";
 
 });
 
 Route::get('/', 'HomeController@index')->name('index');
 
 Route::get('dynamicModal/{id}',[
	 'as'=>'dynamicModal',
	 'uses'=> 'HomeController@loadModal'
 ]);
 
 Route::get('dynamicMenuModal/{id}',[
	 'as'=>'dynamicMenuModal',
	 'uses'=> 'MenuController@loadModal'
 ]);
 
 Route::post('/subscribe', 'HomeController@subscription');
 Route::get('/about', 'AboutController@index')->name('about');
 Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
 Route::get('/menu', 'MenuController@index')->name('menu');
 Route::get('/page-not-found', 'PageNotFoundController@index')->name('page-not-found');
 
 Route::get('/blog', 'BlogController@index')->name('blog');
 /*Route::get('/blog_detail/{id}', 'BlogController@blog_detail')->name('blog_detail');*/
 Route::get('/blog_detail/{any}', 'BlogController@blog_detail')->name('blog_detail');
 
 Route::post('/comment/store_comment', 'CommentController@store')->name('store_comment');
 Route::post('/comment/update_comment/{id}', 'CommentController@update')->name('update_comment');
 Route::any('/comment/new_comment', 'CommentController@new_comment')->name('new_comment');
 
 Route::get('/contact', 'ContactController@index')->name('contact');
 Route::get('/subscribe-info', 'SubscribeinfoController@index')->name('subscribe-info');
 Route::post('/contact-store', 'ContactController@store')->name('store');
 Route::any('/mail', 'ContactController@sendMail')->name('sendMail');
 Route::post('/newsletter_store', 'HomeController@store')->name('store');
 
 Route::get('/faq', 'FaqController@index')->name('faq');
 Route::get('/privacy_policy', 'PrivacyPolicyController@index')->name('privacy_policy');
 Route::get('/terms_conditions', 'TermsConditionsController@index')->name('index');
 
 
 /*Razorpay*/
 Route::post('/page/payment','PaymentController@index');
 Route::post('/capture_payment','PaymentController@capture_payment');
 Route::get('success','PaymentController@success');
 Route::get('failed','PaymentController@failed');
 
 Route::post('/survey','LandingController@store_survey');
 Route::post('/subscription','LandingController@store_subscription');
 
 Route::any('/register','LandingRegisterController@user_register');
 Route::post('/frontend/submitform/submitAddform', 'AjaxController@submitAddform');
 Route::get('/thank-you', 'ThankYouController@index')->name('thank_you');
 
 Route::get('/subscribe-now', 'SubscribeController@index')->name('index');
 Route::get('getSubscribeNowPlanDuration/{id}', 'SubscribeController@SubscribeNowPlanDuration')->name('SubscribeNowPlanDuration');
 Route::post('subscription_payment', 'SubscribeController@subscription_payment')->name('subscription_payment');
 Route::get('subscription-success','SubscribeController@subscription_success');
 Route::get('subscription-failed','SubscribeController@subscription_failed');
 Route::any('search','SubscribeController@search');
 Route::any('searchform','SubscribeController@searchform');
 
 Route::get('/subscribe-now', 'SubscribeController@index')->name('index');
 
 //Route::any('postDetails', 'SubscribeController@postDetails')->name('postDetails');
 Route::any('postPersonalDetails', 'SubscribeController@postPersonalDetails')->name('postPersonalDetails');
 Route::any('postFormDetails', 'SubscribeController@postFormDetails')->name('postFormDetails');
 Route::any('getMealTypeDataAjax', 'SubscribeController@getMealTypeDataAjax')->name('getMealTypeDataAjax');
 
 
 
 Route::get('subscription-payment/{any}', 'SubscribeController@subscription_payment1')->name('subscription_payment');

/* @END: Front End Routes */



Route::get('admin/', 									'Admin\AuthController@login');
//Route::get('/', 									'Admin\AuthController@login');
Route::get('admin/login', 								'Admin\AuthController@login');
Route::post('admin/login_process', 						'Admin\AuthController@login_process');
Route::get('admin/forget_password', 					'Admin\AuthController@forget_password');
Route::post('admin/forget_password_process', 			'Admin\AuthController@forget_password_process');
Route::get('admin/logout',		 						'Admin\AuthController@logout');
Route::post('admin/capture_payment',		 			'Admin\MobileapiController@capture_payment');
Route::post('admin/offer_capture_payment',		 			'Admin\MobileapiController@offer_capture_payment');

Route::get('admin/hardcoded_receipt',		 			'Admin\MobileapiController@hardcoded_receipt');

Route::post('/admin/getvarient',		 				'Admin\BookingController@getvarient');
Route::post('/admin/getvarientnexa',		 				'Admin\BookingController@getvarientnexa');
Route::post('/admin/getvarientcomm',		 				'Admin\BookingController@getvarientcomm');

Route::post('/admin/getcolor',		 					'Admin\BookingController@getcolor');
Route::post('/admin/getcolornexa',		 					'Admin\BookingController@getcolornexa');
Route::post('/admin/getcolorcomm',		 					'Admin\BookingController@getcolorcomm');

Route::post('/admin/getprice',		 					'Admin\BookingController@getprice');

Route::get('/admin/change_password',		 					'Admin\AuthController@change_password');
Route::post('/admin/change_password_process',		 					'Admin\AuthController@change_password_process');


Route::post('/admin/getcity',		 					'Admin\BookingController@getcity');
Route::post('/admin/getarea',		 					'Admin\BookingController@getarea');
Route::post('/admin/getpincode',		 				'Admin\BookingController@getpincode');

Route::group(['prefix' => 'admin','middleware' => 'admin'], function () 
{
	Route::get('/dashbord',		 	 'Admin\AuthController@dashbord');

	//user table
	
	Route::get('/manage_users',		 'Admin\UserController@index');
	Route::get('/add_user',		 	 'Admin\UserController@add');
	Route::post('/store_user',		 'Admin\UserController@store');
	Route::get('/edit_user/{id}',	 'Admin\UserController@edit');
	Route::post('/update_user/{id}', 'Admin\UserController@update');
	Route::get('/delete_user/{id}',	 'Admin\UserController@delete');
	Route::post('/getArea',	 		 'Admin\UserController@getArea');

	//Module Master Routes
	
	Route::get('/manage_module',		 'Admin\ModuleController@index');
	Route::get('/add_module',		 	 'Admin\ModuleController@add');
	Route::post('/store_module',		 'Admin\ModuleController@store');
	Route::get('/edit_module/{id}',	 	 'Admin\ModuleController@edit');
	Route::post('/update_module/{id}', 	 'Admin\ModuleController@update');
	Route::get('/delete_module/{id}',	 'Admin\ModuleController@delete');

	//Role Master Routes
	
	Route::get('/manage_role',		 'Admin\RoleController@index');
	Route::get('/add_role',		 	 'Admin\RoleController@add');
	Route::post('/store_role',		 'Admin\RoleController@store');
	Route::get('/edit_role/{id}',	 'Admin\RoleController@edit');
	Route::post('/update_role/{id}', 'Admin\RoleController@update');
	Route::get('/delete_role/{id}',	 'Admin\RoleController@delete');

	//Role Permisssions
	
	Route::get('/manage_permission',		 'Admin\PermissionController@index');
	Route::get('/add_permission',		 	 'Admin\PermissionController@add');
	Route::post('/store_permission',		 'Admin\PermissionController@store');
	Route::get('/edit_permission/{id}',	     'Admin\PermissionController@edit');
	Route::post('/update_permission/{id}',   'Admin\PermissionController@update');
	Route::get('/delete_permission/{id}',	 'Admin\PermissionController@delete');
	Route::post('/getmenu',	 				 'Admin\PermissionController@get_menu');
	Route::post('/getmenulist',	 			 'Admin\PermissionController@get_menu_list');

    //Nutritionsit Master Routes
	
	Route::get('/manage_nutritionsit',		 'Admin\NutritionsitController@index');
	Route::get('/add_nutritionsit',		 	 'Admin\NutritionsitController@add');
	Route::post('/store_nutritionsit',		 'Admin\NutritionsitController@store');
	Route::get('/edit_nutritionsit/{id}',	 'Admin\NutritionsitController@edit');
	Route::post('/update_nutritionsit/{id}', 'Admin\NutritionsitController@update');
	Route::get('/delete_nutritionsit/{id}',	 'Admin\NutritionsitController@delete');
	Route::post('/status_nutritionsit',	     'Admin\NutritionsitController@status');
	Route::post('/calender',	             'Admin\NutritionsitController@calender');

	//ajax state city routes
	
	Route::post('/getCity',	 			 'Admin\AjaxController@getCity');
	Route::post('/getArea',	 			 'Admin\AjaxController@getArea');

	//plan master routes
	
	Route::get('/manage_plan',		  'Admin\PlanController@index');
	Route::get('/add_plan',		 	  'Admin\PlanController@add');
	Route::post('/store_plan',		  'Admin\PlanController@store');
	Route::get('/edit_plan/{id}',	  'Admin\PlanController@edit');
	Route::post('/update_plan/{id}',  'Admin\PlanController@update');
	Route::get('/delete_plan/{id}',	  'Admin\PlanController@delete');
	Route::post('/plan_status',	      'Admin\PlanController@status');

	//Subscription master routes
	
	Route::get('/manage_subscription_plan',		   'Admin\SubscriptionController@index');
	Route::get('/add_subscription_plan',		   'Admin\SubscriptionController@add');
	Route::post('/store_subscription_plan',		   'Admin\SubscriptionController@store');
	Route::get('/edit_subscription_plan/{id}',	   'Admin\SubscriptionController@edit');
	Route::post('/update_subscription_plan/{id}',  'Admin\SubscriptionController@update');
	Route::get('/delete_subscription_plan/{id}',   'Admin\SubscriptionController@delete');
	Route::post('/status_subscription_plan',	   'Admin\SubscriptionController@status');
	Route::post('/subscription_plan_details',	   'Admin\SubscriptionController@detail');
	
	//operation manager  routes
	
	Route::get('/manage_operation_manager',		 'Admin\OperationManagerController@index');
	Route::get('/add_operation_manager',		 'Admin\OperationManagerController@add');
	Route::post('/store_operation_manager',		 'Admin\OperationManagerController@store');
	Route::get('/edit_operation_manager/{id}',	 'Admin\OperationManagerController@edit');
	Route::post('/update_operation_manager/{id}','Admin\OperationManagerController@update');
	Route::get('/delete_operation_manager/{id}', 'Admin\OperationManagerController@delete');
	Route::post('/status_operation_manager',	  'Admin\OperationManagerController@status');

	//operation manager routes
	
	Route::get('/manage_location',		  'Admin\LocationsController@index');
	Route::get('/add_location',		  'Admin\LocationsController@add');
	Route::post('/store_location',		  'Admin\LocationsController@store');
	Route::get('/edit_location/{id}',	  'Admin\LocationsController@edit');
	Route::post('/update_location/{id}', 'Admin\LocationsController@update');
	Route::get('/delete_location/{id}',  'Admin\LocationsController@delete');
	Route::post('/status_location',	  'Admin\LocationsController@status');


});