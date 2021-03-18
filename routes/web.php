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


Route::get('/test', function () {
    return view('admincontactmail');
});

 Route::get('/', 'HomeController@index')->name('index');
 
 Route::get('/order_index', function () {
    return view('ordernow/index');
});

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
 Route::post('get_city_list',	 		  'Admin\AuthController@get_city_list');
 Route::get('public/admin/login',	      'Admin\AuthController@login');

/* @END: Front End Routes */

Route::get('admin/', 							'Admin\AuthController@login');
//Route::get('/', 			   					'Admin\AuthController@login');
Route::get('admin/login', 						'Admin\AuthController@login');
Route::post('admin/login_process', 				'Admin\AuthController@login_process');
Route::get('admin/forget_password', 			'Admin\AuthController@forget_password');
Route::post('admin/forget_password_process', 	'Admin\AuthController@forget_password_process');
Route::get('admin/logout',		 				'Admin\AuthController@logout');
Route::post('admin/capture_payment',		 	'Admin\MobileapiController@capture_payment');
Route::post('admin/offer_capture_payment',		'Admin\MobileapiController@offer_capture_payment');
Route::get('admin/hardcoded_receipt',		 	'Admin\MobileapiController@hardcoded_receipt');
Route::post('/admin/getvarient',		 		'Admin\BookingController@getvarient');
Route::post('/admin/getvarientnexa',		 	'Admin\BookingController@getvarientnexa');
Route::post('/admin/getvarientcomm',		 	'Admin\BookingController@getvarientcomm');
Route::post('/admin/getcolor',		 			'Admin\BookingController@getcolor');
Route::post('/admin/getcolornexa',		 		'Admin\BookingController@getcolornexa');
Route::post('/admin/getcolorcomm',		 		'Admin\BookingController@getcolorcomm');
Route::post('/admin/getprice',		 			'Admin\BookingController@getprice');
Route::get('/admin/change_password',		 	'Admin\AuthController@change_password');
Route::post('/admin/change_password_process',	'Admin\AuthController@change_password_process');
Route::post('/admin/getcity',		 			'Admin\BookingController@getcity');
Route::post('/admin/getarea',		 			'Admin\BookingController@getarea');
Route::post('/admin/getpincode',		 		'Admin\BookingController@getpincode');

/*********************************@RAJ FRONT_ROUTES @****************************************/
//sign up routes
Route::get('/sign-up',		 	 				'Front\SignUpController@index');
Route::post('/store_basic_details', 	 		'Front\SignUpController@storeBasicDetails');
Route::post('/get_plan_details', 	 			'Front\SignUpController@getSubscriptionPlanDetails');
Route::post('/subscribe-info', 	 				'Front\SignUpController@getSubscribePlan');
Route::post('/check_valid_pin', 	 			'Front\SignUpController@getCheckValidPin');
Route::post('/get_subscription_plan_price', 	'Front\SignUpController@getSubPlanPrice');
Route::post('/checkout_sub', 						'Front\SignUpController@checkout');
Route::post('/pay-success', 					'Front\SignUpController@paySuccess');
Route::get('/thankyou', 						'Front\SignUpController@thankyou');
Route::get('/sign-in',							['as'=>'signinModal','uses'=> 'Front\SignUpController@signinModal']);
Route::post('/check-login', 					'Auth\LoginController@checkLogin');
Route::post('/check-otp', 						'Auth\LoginController@checkOtp');


Route::group(['middleware' => 'subscriber'], function () {
	// Only authenticated users may access this route...
	Route::get('/dashboard', 					'Front\SubscriptionUserController@index');
	Route::get('/mysubscription', 				'Front\SubscriptionUserController@mySubscription');	
	Route::get('/profile', 						'Front\SubscriptionUserController@index');
	Route::post('/details',	  					'Front\SubscriptionUserController@subscriber_details');
	//Route::post('/chat/{id}',	  				'Front\SubscriptionUserController@subscriber_details');
	Route::get('/chat', 						'Front\SubscriptionUserController@getChatList');
	Route::get('/goforchat/{id}', 				'Front\SubscriptionUserController@chatWithNutrionist');

	Route::get('/logout', function(){
		Auth::logout();		
		Session::flush();
		return Redirect::to('subscribe-info');
	});

	//route for meal program
	Route::get('/mealprogram', 					'Front\UserMealProgramController@mealProgram');
	Route::get('/subscriber_calendar', 			'Front\UserMealProgramController@getCalendar');

	
	
});


/**********************************************************************************************/

/*******************************@Bhushan Notification Route@***********************************/
Route::get('/notifyadmin','Admin\NotificationController@notify');

/*********************************@BHUSHUAN ADMIN ROUTES@**************************************/
Route::group(['prefix' => 'admin','middleware' => 'admin'], function () 
{
	
	Route::get('/dashbord',		 	      'Admin\DashboardController@dashbord');
	Route::post('/getSubscriberDatadash', 'Admin\DashboardController@get_expiry_subcriber');
	
	//notification show
	Route::post('/notification_data',  'Admin\NotificationController@dbnotification');
	Route::get('/notification/{id}',   'Admin\NotificationController@notification');
	Route::get('/manage_notification', 'Admin\NotificationController@index');


	//user table 
	/*Route::get('/manage_users',		 'Admin\UserController@index');
	Route::get('/add_user',		 	 'Admin\UserController@add');
	Route::post('/store_user',		 'Admin\UserController@store');
	Route::get('/edit_user/{id}',	 'Admin\UserController@edit');
	Route::post('/update_user/{id}', 'Admin\UserController@update');
	Route::get('/delete_user/{id}',	 'Admin\UserController@delete');
	Route::post('/getArea',	 		 'Admin\UserController@getArea');*/
	
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
	Route::post('/status_role',	     'Admin\RoleController@status');
	//gst Master Routes
	
	Route::get('/manage_gst',		 'Admin\GstController@index');
	Route::get('/add_gst',		 	 'Admin\GstController@add');
	Route::post('/store_gst',		 'Admin\GstController@store');
	Route::get('/edit_gst/{id}',	 'Admin\GstController@edit');
	Route::post('/update_gst/{id}',  'Admin\GstController@update');
	Route::get('/delete_gst/{id}',	 'Admin\GstController@delete');

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
	Route::post('/getAreamultiarea',	 'Admin\AjaxController@getAreamultiarea');
	Route::post('/getSubscriber',	 	 'Admin\AjaxController@getSubscriber');


	//plan master routes
	
	Route::get('/manage_plan',		  'Admin\PlanController@index');
	Route::get('/add_plan',		 	  'Admin\PlanController@add');
	Route::post('/store_plan',		  'Admin\PlanController@store');
	Route::get('/edit_plan/{id}',	  'Admin\PlanController@edit');
	Route::post('/update_plan/{id}',  'Admin\PlanController@update');
	Route::get('/delete_plan/{id}',	  'Admin\PlanController@delete');
	Route::post('/plan_status',	      'Admin\PlanController@status');

	//Subscription master routes

	 Route::get('/manage_subscription_plan',	   'Admin\SubscriptionController@index');
	 Route::get('/add_subscription_plan',		   'Admin\SubscriptionController@add');
	 Route::post('/store_subscription_plan',	   'Admin\SubscriptionController@store');
	 Route::get('/edit_subscription_plan/{id}',	   'Admin\SubscriptionController@edit');
	 Route::post('/update_subscription_plan/{id}', 'Admin\SubscriptionController@update');
	 Route::get('/delete_subscription_plan/{id}',  'Admin\SubscriptionController@delete');
	 Route::post('/status_subscription_plan',	   'Admin\SubscriptionController@status');
	 Route::post('/status_duration_plan',	       'Admin\SubscriptionController@status_duration');
	 Route::post('/subscription_plan_details',	   'Admin\SubscriptionController@detail');
	
	//user manager  routes

	 Route::get('/manage_user_manager',	      'Admin\OperationManagerController@index');
	 Route::get('/add_user_manager',		  'Admin\OperationManagerController@add');
	 Route::post('/store_user_manager',	      'Admin\OperationManagerController@store');
	 Route::get('/edit_user_manager/{id}',	  'Admin\OperationManagerController@edit');
	 Route::post('/update_user_manager/{id}', 'Admin\OperationManagerController@update');
	 Route::get('/delete_user_manager/{id}',  'Admin\OperationManagerController@delete');
	 Route::post('/status_user_manager',	  'Admin\OperationManagerController@status');

	//operation manager routes
	
	 Route::get('/manage_location',		  'Admin\LocationsController@index');
	 Route::get('/add_location',		  'Admin\LocationsController@add');
	 Route::post('/store_location',		  'Admin\LocationsController@store');
	 Route::get('/edit_location/{id}',	  'Admin\LocationsController@edit');
	 Route::post('/update_location/{id}', 'Admin\LocationsController@update');
	 Route::get('/delete_location/{id}',  'Admin\LocationsController@delete');
	 Route::post('/status_location',	  'Admin\LocationsController@status');

	// Menu category routes
	 Route::get('/manage_menucategory',		 'Admin\MenuCategoryController@index');
	 Route::get('/add_menucategory',		 'Admin\MenuCategoryController@add');
	 Route::post('/store_menucategory',		 'Admin\MenuCategoryController@store');
	 Route::get('/edit_menucategory/{id}',	 'Admin\MenuCategoryController@edit');
	 Route::post('/update_menucategory/{id}','Admin\MenuCategoryController@update');
	 Route::get('/delete_menucategory/{id}', 'Admin\MenuCategoryController@delete');
	
	// Menu Specification routes
	 Route::get('/manage_menu_specification', 		'Admin\MenuSpecificationController@index');
	 Route::get('/add_menu_specification',	 		'Admin\MenuSpecificationController@add');
	 Route::post('/store_menu_specification', 		'Admin\MenuSpecificationController@store');
	 Route::get('/edit_menu_specification/{id}',	'Admin\MenuSpecificationController@edit');
	 Route::post('/update_menu_specification/{id}',	'Admin\MenuSpecificationController@update');
	 Route::get('/delete_menu_specification/{id}', 	'Admin\MenuSpecificationController@delete');

	// Menu Routes
	 Route::get('/manage_menu', 		'Admin\MenuController@index');
	 Route::get('/add_menu',	 		'Admin\MenuController@add');
	 Route::post('/store_menu', 		'Admin\MenuController@store');
 	 Route::get('/edit_menu/{id}',		'Admin\MenuController@edit');
 	 Route::post('/update_menu/{id}',	'Admin\MenuController@update');
	 Route::get('/delete_menu/{id}', 	'Admin\MenuController@delete');


	 //Assign Menu To subscription Plan Routes
	 Route::get('/manage_assign_sub_plan_menu', 		'Admin\AssignSubscriptionPlanMenuController@index');
	 Route::get('/add_assign_sub_plan_menu',	 		'Admin\AssignSubscriptionPlanMenuController@add');
	 Route::post('/store_assign_sub_plan_menu', 		'Admin\AssignSubscriptionPlanMenuController@store');
 	 Route::get('/edit_assign_sub_plan_menu/{id}',		'Admin\AssignSubscriptionPlanMenuController@edit');
 	 Route::post('/update_assign_sub_plan_menu/{id}',	'Admin\AssignSubscriptionPlanMenuController@update');
	 Route::get('/delete_assign_sub_plan_menu/{id}', 	'Admin\AssignSubscriptionPlanMenuController@delete');
	 Route::post('/getdays',	         			    'Admin\AssignSubscriptionPlanMenuController@get_days');
	Route::post('/default_menu_add',					'Admin\AssignSubscriptionPlanMenuController@default_menu_add');
	Route::post('/default_menu_edit',					'Admin\AssignSubscriptionPlanMenuController@default_menu_edit');
	Route::post('/store_meal_plan',						'Admin\AssignSubscriptionPlanMenuController@store_meal_plan');
	Route::post('/update_meal_plan',					'Admin\AssignSubscriptionPlanMenuController@update_meal_plan');

	// Assign location wise menu Routes  
	Route::get('/manage_assign_location_menu', 		 'Admin\AssignLocationMenuController@index');
	Route::get('/add_assign_location_menu',	 		 'Admin\AssignLocationMenuController@add');
	Route::post('/store_assign_location_menu', 		 'Admin\AssignLocationMenuController@store');
	Route::get('/edit_assign_location_menu/{id}',	 'Admin\AssignLocationMenuController@edit');
	Route::post('/update_assign_location_menu/{id}', 'Admin\AssignLocationMenuController@update');
	Route::get('/delete_assign_location_menu/{id}',  'Admin\AssignLocationMenuController@delete');
	Route::post('/status_assign_menu',	  		     'Admin\AssignLocationMenuController@status');
	Route::post('/assign_menu_details',	  		     'Admin\AssignLocationMenuController@detail');

	//Kitchen Routes
	Route::get('/manage_kitchen',	      'Admin\KitchenController@index');
	Route::get('/add_kitchen',		      'Admin\KitchenController@add');
	Route::post('/store_kitchen',	 	  'Admin\KitchenController@store');
	Route::get('/edit_kitchen/{id}',	  'Admin\KitchenController@edit');
	Route::post('/update_kitchen/{id}',   'Admin\KitchenController@update');
	Route::get('/delete_kitchen/{id}',    'Admin\KitchenController@delete');
	Route::post('/status_kitchen',	      'Admin\KitchenController@status');
	Route::post('/kitchen_details',	      'Admin\KitchenController@detail');

	//Assign Nutritionist Routes
	Route::get('/manage_assign_nutritionist',	      'Admin\AssignNutritionistController@index');
	Route::get('/add_assign_nutritionist',		      'Admin\AssignNutritionistController@add');
	Route::post('/store_assign_nutritionist',	 	  'Admin\AssignNutritionistController@store');
	Route::get('/edit_assign_nutritionist/{id}',	  'Admin\AssignNutritionistController@edit');
	Route::post('/update_assign_nutritionist/{id}',   'Admin\AssignNutritionistController@update');
	Route::get('/delete_assign_nutritionist/{id}',    'Admin\AssignNutritionistController@delete');
	Route::post('/status_assign_nutritionist',	      'Admin\AssignNutritionistController@status');
	Route::post('/assign_nutritionist_details',	      'Admin\AssignNutritionistController@detail');
	Route::post('/get_user_list',	                  'Admin\AssignNutritionistController@get_user_list');
	Route::post('/assign_users_details',	          'Admin\AssignNutritionistController@assign_users_details');
	
	//subscriber Routes 
	Route::get('/manage_subscriber',	    		  'Admin\SubscriberController@index');
	Route::post('/getSubscriberData',	              'Admin\SubscriberController@getSubscriberData');

	Route::get('/manage_new_subscriber',	    	  'Admin\SubscriberController@newindex');
	Route::post('/getNewSubscriberData',	    	  'Admin\SubscriberController@getNewSubscriberData');

	Route::get('/manage_expire_subscriber',	    	  'Admin\SubscriberController@expindex');
	Route::post('/getExpireSubscriberData',	    	  'Admin\SubscriberController@getExpireSubscriberData');

	Route::get('/add_subscriber',		    'Admin\SubscriberController@add');
    Route::post('/store_subscriber',	    'Admin\SubscriberController@store');
	Route::get('/edit_subscriber/{id}',	    'Admin\SubscriberController@edit');
    Route::post('/update_subscriber/{id}',  'Admin\SubscriberController@update');
	Route::get('/delete_subscriber/{id}',   'Admin\SubscriberController@delete');
    Route::post('/verify_subscriber',	    'Admin\SubscriberController@verify_subscriber');
    Route::post('/subscriber_details',	    'Admin\SubscriberController@subscriber_details');
    Route::get('/subscriber_pdf/{id}',	    'Admin\SubscriberController@subscriber_pdf');
    Route::get('/subscriber_bill_pdf/{id}', 'Admin\SubscriberController@subscriber_bill_pdf');
    
    //Meal Program Subscriber 
    Route::get('/add_subscriber_meal_program/{id}',   'Admin\SubscriberMealProgramController@add');
    Route::post('/view_subscriber_meal_program',      'Admin\SubscriberMealProgramController@view_details');
    Route::post('/store_subscriber_health_details',	  'Admin\SubscriberMealProgramController@store');
    Route::post('/edit_subscriber_default_menu',	  'Admin\SubscriberMealProgramController@menu_edit');
    Route::post('/get_menu_dropdown',				  'Admin\SubscriberMealProgramController@get_menu');
    Route::post('/get_menu_macros',					  'Admin\SubscriberMealProgramController@get_menu_macros');
    Route::post('/store_change_menu',				  'Admin\SubscriberMealProgramController@store_change_menu');
   
    //Subscriber Calender
    Route::get('/manage_subscriber_calender', 'Admin\SubscriberCalenderController@index');
	Route::post('/getMealDetails',			  'Admin\SubscriberCalenderController@getMealDetails');
    Route::get('/traits', 'Admin\DashboardController@traits');

});


/**********************************************************************************************/