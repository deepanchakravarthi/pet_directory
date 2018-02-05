<?php
define('SITE_NAME', 'PET-ID.INFO');
define('SITE_PATH', 'http://localhost/pet_directory/demo');
define('SITE_PLAN_COST', '25.00');
define('SITE_STRIPE_SK', 'sk_test_hoPIlYUpBMCAT0RddtT8dbYE');	// T
define('SITE_STRIPE_PK', 'pk_test_LGqUjEtms6Fja343vlSCxi3s');	// T
define('SITE_SUBSCRIPTION_PLAN_ID_EUR', 'pet-id_1year_EUR');
define('SITE_SUBSCRIPTION_PLAN_ID_USD', 'pet-id_1year_USD');
define('SITE_STRIPE_WHSEC', 'whsec_gUavOCJOL2DPyQO0Xbt1zhXURwpXFKut');

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

Route::get('/', array('uses' => 'HomeController@showHome'));
Route::get('index', array('uses' => 'HomeController@showHome'));
Route::get('index/{locale}', function ($locale) {
	//session(['locale' => $locale]);
	Session::put('locale', $locale);
	return back();
});
Route::post('stripe/notification', array('uses' => 'PaymentController@stripeCall'));
Route::get('cron/deactive-invalid-subs', array('uses' => 'PaymentController@checkSubscriptionEndTime'));

Route::get('env', array('uses' => 'HomeController@showEnv'));

//	authentication
Route::get('where-are-you', array('uses' => 'UserController@showPreRegister'));
Route::get('register', array('uses' => 'UserController@showRegister'));
Route::post('register', array('uses' => 'UserController@doRegister'));
Route::post('register-vet', array('uses' => 'UserController@doRegisterVet'));
Route::post('register-authority', array('uses' => 'UserController@doRegisterAuthority'));
Route::get('login', array('uses' => 'UserController@showLogin'));
Route::post('login',  array('uses' => 'UserController@doLogin'));
Route::get('logout', array('uses' => 'UserController@doLogout'));

Route::post('contact', array('uses' => 'HomeController@postContact'));
Route::get('forgot-password', array('uses' => 'UserController@showForgotPassword'));
Route::post('forgot-password', array('uses' => 'UserController@doForgotPassword'));
Route::get('reset-password/{token}', array('uses' => 'UserController@showReset'));
Route::post('reset-password', array('uses' => 'UserController@doReset'));
Route::get('confirm/{id}', array('uses' => 'UserController@doConfirm'));

Route::post('search',  array('uses' => 'PetController@doPetSearch'));
Route::get('search',  array('uses' => 'HomeController@showHome'));	
Route::post('search-result-response', array('uses' => 'PetController@doPostSearchResult'));

Route::get('aboutus', array('uses' => 'PetController@showAboutus'));
Route::get('contact', array('uses' => 'PetController@showContactus'));
Route::get('imprint', array('uses' => 'PetController@showImprint'));

Route::post('api/v1/search',  array('uses' => 'ApiController@doPetSearch'));
Route::post('api/v1/search-result-response', array('uses' => 'ApiController@doPostSearchResult'));
Route::post('api/v1/register-owner', array('uses' => 'ApiController@doRegister'));
Route::post('api/v1/register-vet', array('uses' => 'ApiController@doRegisterVet'));
Route::post('api/v1/register-authority', array('uses' => 'ApiController@doRegisterAuthority'));
Route::post('api/v1/login',  array('uses' => 'ApiController@doLogin'));
Route::post('api/v1/forgot-password', array('uses' => 'ApiController@doForgotPassword'));

Route::post('api/v1/pets', array('uses' => 'ApiController@showMyPets'));
Route::post('api/v1/create-pet', array('uses' => 'ApiController@doInsertPet'));
Route::get('api/v1/view-pet/{id}/user/{user_id}', array('uses' => 'ApiController@viewPet'));
Route::post('api/v1/edit-pet', array('uses' => 'ApiController@doUpdatePet'));
Route::post('api/v1/pet/confirm-found', array('uses' => 'ApiController@doPetFound'));
Route::post('api/v1/pet/confirm-lost', array('uses' => 'ApiController@doPetLost'));

Route::post('api/v1/pet/confirm-death', array('uses' => 'ApiController@doPetDeath'));
Route::post('api/v1/pet/confirm-offer', array('uses' => 'ApiController@doPetOffer'));
Route::get('api/v1/pet/accept-offer/{id}/user/{user_id}', array('uses' => 'ApiController@doAcceptOffer'));
Route::post('api/v1/pet/confirm-addnote', array('uses' => 'ApiController@doAddNote'));

Route::post('api/v1/edit-profile', array('uses' => 'ApiController@doUpdateProfile'));
Route::post('api/v1/edit-profile-vet', array('uses' => 'ApiController@doUpdateProfileVet'));
Route::post('api/v1/edit-profile-authority', array('uses' => 'ApiController@doUpdateProfileAuthority'));
Route::get('api/v1/users/{id}', array('uses' => 'ApiController@showMyUsers'));
Route::get('api/v1/view-user/{id}', array('uses' => 'ApiController@doViewUser'));

Route::post('api/v1/create-user', array('uses' => 'ApiController@doCreateUser'));
Route::post('api/v1/create-vet', array('uses' => 'ApiController@doCreateVet'));
Route::post('api/v1/create-authority', array('uses' => 'ApiController@doCreateAuthority'));

Route::get('api/v1/subscription/{id}', array('uses' => 'ApiController@showSubscriptions'));
Route::post('api/v1/subscription-charge-iban', array('uses' => 'ApiController@doSubscribeChargeIban'));
Route::post('api/v1/subscription-charge', array('uses' => 'ApiController@doSubscribeCharge'));
Route::post('api/v1/change-payment-details', array('uses' => 'ApiController@doChangeDetails'));
Route::post('api/v1/change-payment-details-iban', array('uses' => 'ApiController@doChangeIbanDetails'));
Route::post('api/v1/search-result-response-authority', array('uses' => 'ApiController@doPostSearchResultAuthority'));
Route::get('api/v1/cancel-subscription/{id}/user_id/{user_id}', array('uses' => 'ApiController@cancelSubscription'));

Route::group(['middlewareGroups' => 'web'], function()
{
	Route::get('my-pets', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@showMyPets'
							]);
	Route::get('create-pet', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@createPet'
							]);
	Route::post('create-pet', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doInsertPet'
							]);
	Route::get('view-pet/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@viewPet'
							]);
	Route::get('edit-pet/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@editPet'
							]);
	
	Route::post('edit-pet/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doUpdatePet'
							]);
	
	Route::post('pet/confirm-found', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doPetFound'
							]);
	Route::post('pet/confirm-lost', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doPetLost'
							]);
	Route::post('pet/confirm-death', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doPetDeath'
							]);
	Route::post('pet/confirm-offer', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doPetOffer'
							]);
	Route::get('pet/accept-offer/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doAcceptOffer'
							]);
	Route::post('pet/confirm-addnote', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doAddNote'
							]);
	Route::get('my-profile', [
							'middleware'=> 'auth',
							'uses'		=> 'UserController@showProfile'
							]);
	Route::get('edit-profile', [
							'middleware'=> 'auth',
							'uses'		=> 'UserController@editProfile'
							]);
	Route::post('edit-profile', [
							'middleware'=> 'auth',
							'uses'		=> 'UserController@doUpdateProfile'
							]);
	Route::post('edit-profile-vet', [
							'middleware'=> 'auth',
							'uses'		=> 'UserController@doUpdateProfileVet'
							]);
	Route::post('edit-profile-authority', [
							'middleware'=> 'auth',
							'uses'		=> 'UserController@doUpdateProfileAuthority'
							]);
	//	Admin
	Route::get('users', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@showMyUsers'
							]);
	Route::get('view-user/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doViewUser'
							]);
	Route::get('edit-user/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doEditUser'
							]);						
	Route::post('edit-user', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doUpdateUser'
							]);
	Route::get('edit-vet/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doEditVet'
							]);						
	Route::post('edit-vet', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doUpdateVet'
							]);
	Route::get('edit-authority/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doEditAuthority'
							]);						
	Route::post('edit-authority', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doUpdateAuthority'
							]);
	Route::get('edit-admin/{id}', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doEditAdmin'
							]);						
	Route::post('edit-admin', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doUpdateAdmin'
							]);
	
	Route::get('create-user', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@createUser'
							]);
	Route::post('create-user', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doCreateUser'
							]);
	Route::get('create-vet', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@createVet'
							]);
	Route::post('create-vet', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doCreateVet'
							]);
	Route::get('create-authority', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@createAuthority'
							]);
	Route::post('create-authority', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doCreateAuthority'
							]);
	Route::get('create-admin', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@createAdmin'
							]);
	Route::post('create-admin', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doCreateAdmin'
							]);
	
	Route::get('subscription', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@showSubscriptions'
							]);
	Route::get('change-subscription', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@showSubscribe'
							]);
	Route::post('subscription-charge', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@doSubscribeCharge'
							]);
	Route::post('subscription-charge-iban', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@doSubscribeChargeIban'
							]);
	Route::get('change-payment-details', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@showChangeDetails'
							]);
	Route::get('payments', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@showPayments'
							]);
	Route::post('change-payment-details', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@doChangeDetails'
							]);
	Route::post('change-payment-iban', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@doChangeIbanDetails'
							]);
	Route::post('search-result-response-authority', [
							'middleware'=> 'auth',
							'uses'		=> 'PetController@doPostSearchResultAuthority'
							]);
	Route::get('create-poster/{id}', array('uses' => 'PetController@createPoster'));
	
	Route::get('cancel-subscription/{id}', array('uses' => 'PaymentController@cancelSubscription'));
	
	Route::post('assign-subscription', [
							'middleware'=> 'auth',
							'uses'		=> 'PaymentController@doAssignSubscription'
							]);
	
});