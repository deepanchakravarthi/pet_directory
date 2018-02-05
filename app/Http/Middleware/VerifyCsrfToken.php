<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
		'stripe/notification',
		'api/v1/search',
		'api/v1/search-result-response',
		'api/v1/register-owner',
		'api/v1/register-vet',
		'api/v1/register-authority',
		'api/v1/login',
		'api/v1/forgot-password',
		'api/v1/pets',
		'api/v1/create-pet',
		'api/v1/view-pet/{id}/user/{user_id}',
		'api/v1/edit-pet',
		
		'api/v1/pet/confirm-found',
		'api/v1/pet/confirm-lost',
		'api/v1/pet/confirm-death',
		'api/v1/pet/confirm-offer',
		'api/v1/pet/accept-offer/{id}/user/{id}',
		'api/v1/pet/confirm-addnote',
		'api/v1/edit-profile',
		'api/v1/edit-profile-vet',
		'api/v1/edit-profile-authority',
		'api/v1/users/{id}',
		'api/v1/view-user/{id}',
		'api/v1/create-user',
		'api/v1/create-vet',
		'api/v1/create-authority',
		'api/v1/subscription/{id}',
		'api/v1/subscription-charge-iban',
		'api/v1/subscription-charge',
		'api/v1/change-payment-details',
		'api/v1/change-payment-details-iban',
		'api/v1/search-result-response-authority',
		'api/v1/cancel-subscription/{id}/user_id/{user_id}'
        //
    ];
	//add an array of Routes to skip CSRF check
	//private $openRoutes = ['free/route', 'free/too'];

	//modify this function
	/*public function handle($request, Closure $next)
		{
			//add this condition 
		foreach($this->openRoutes as $route) {

		  if ($request->is($route)) {
			return $next($request);
		  }
		}
		
		return parent::handle($request, $next);
	  }*/
}
