<?php
namespace App\Http\Controllers;

use DB;

use Mail;

use App\User;

use App\Subscription;

use App\Payment;

use Session;

use Validator;

use Hash;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\LoginFormRequest;

use App\Http\Requests\RegisterFormRequest;

use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller {
	
	public function showPayments() {
		\App::setLocale(Session::get('locale'));
		$planArray	= array(1 => trans('words.1_year_plan'), trans('words.free_plan'), trans('words.voucher'));
		view()->share('planArray', $planArray);
		$userArray	= Auth::user();
		if($userArray->user_type == 4) {
			$subscriptions		= Payment::orderBy('id', 'desc')->get();
			view()->share('payments', $subscriptions);
		
			return view('payment.payments');
		} else {
			return redirect('index');
		}
		
	}
	public function showSubscriptions() {
		\App::setLocale(Session::get('locale'));
		$planArray	= array(1 => trans('words.1_year_plan'), trans('words.free_plan'), trans('words.voucher'));
		view()->share('planArray', $planArray);
		$userArray	= Auth::user();
		if($userArray->user_type == 2) {
			$subscriptions		= Subscription::where('vet_id', '=', $userArray->id)->orderBy('id', 'desc')->get();
		} else if($userArray->user_type == 4) {
			$subscriptions		= Subscription::where('status', '=', 1)->orderBy('id', 'desc')->get();
		}
		view()->share('subscriptions', $subscriptions);
		
		return view('payment.subscriptions');
	}
	public function showSubscribe() {
		\App::setLocale(Session::get('locale'));
		$planArray	= array(1 => trans('words.1_year_plan'), trans('words.free_plan'), trans('words.voucher'));
		view()->share('planArray', $planArray);
		return view('payment.subscribe');
	}
	public function doSubscribeChargeIban(Request $request) {
		\App::setLocale(Session::get('locale'));
		$validator = Validator::make($request->all(), [
			'iban'	=> 'required',
			'name'	=> 'required'
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			
			$email	= Auth::user()->email;
			
			\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
			//	Source Creation
			$source = \Stripe\Source::create(array(
			  "type" => "sepa_debit",
			  "sepa_debit" => array("iban" => $request->input('iban')),
			  "currency" => "eur",
			  "owner" => array(
				"name" => $request->input('name'),
			  ),
			));

			//	Customer Creation
			$customer = \Stripe\Customer::create(array(
				"email" 	=> $email,
				"source" 	=> $source->id,
				'metadata'	=> array('Firstname' => Auth::user()->firstname, 'Lastname' => Auth::user()->lastname)
			  
			));
			$last4				= $customer->sources->data[0]->sepa_debit->last4;
			$mandate_reference	= $customer->sources->data[0]->sepa_debit->mandate_reference;
			$mandate_url		= $customer->sources->data[0]->sepa_debit->mandate_url;
			$euCountries	= array(14, 21, 56, 68, 73, 74, 82, 85, 105, 107, 119, 125, 126, 134, 152, 153, 173, 191, 192, 197);
			if(in_array(Auth::user()->country, $euCountries)) {
				$plan	= SITE_SUBSCRIPTION_PLAN_ID_EUR;
				$currency	= 'EUR';
			} else {
				$plan	= SITE_SUBSCRIPTION_PLAN_ID_USD;
				$currency	= 'USD';
			}
			//	Assign Subscription to Customer
			$subscription	= \Stripe\Subscription::create([
				'customer'	=> $customer->id,
				'items'		=> [['plan' => $plan]],
			]);
			//	Change status of existing plans
			Subscription::where('vet_id', '=', Auth::user()->id)->update(['status' => 0]);
			
			//	Add new subscription
			$sub			= new Subscription();
			$sub->vet_id	= Auth::user()->id;
			$sub->plan_id	= 1;
			$sub->customer_id		= $customer->id;
			$sub->subscription_id	= $subscription->id;
			$sub->method	= 2;
			$sub->is_stripe	= 1;
			//$sub->start_date= date('Y-m-d');
			//$sub->end_date	= date('Y-m-d', strtotime('+1 year'));
			$sub->payment_status	= 0;
			$sub->last4				= $last4;
			$sub->mandate_reference	= $mandate_reference;
			$sub->mandate_url		= $mandate_url;
			$sub->currency	= $currency;
			//$sub->status	= 1;
			$sub->save();
			
			$user	= Auth::user();
			$data	= array('name' => $user->firstname.' '.$user->lastname);
			Mail::send('emails.subscription-notification', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
			});
			return redirect('subscription')->with('message', trans('words.ctrl_subscription_success'));
			
		}
	}
	public function doSubscribeCharge(Request $request) {
		\App::setLocale(Session::get('locale'));
		\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
		$token	= $request->input('stripeToken');
		$email	= Auth::user()->email;
		// Customer Creation
		$customer	= \Stripe\Customer::create(array(
			'email'	=> $email,
			'source'=> $token,
			'metadata'	=> array('Firstname' => Auth::user()->firstname, 'Lastname' => Auth::user()->lastname)
		));
		$euCountries	= array(14, 21, 56, 68, 73, 74, 82, 85, 105, 107, 119, 125, 126, 134, 152, 153, 173, 191, 192, 197);
		if(in_array(Auth::user()->country, $euCountries)) {
			$plan	= SITE_SUBSCRIPTION_PLAN_ID_EUR;
			$currency	= 'EUR';
		} else {
			$plan	= SITE_SUBSCRIPTION_PLAN_ID_USD;
			$currency	= 'USD';
		}
			
		//	Assign Subscription to Customer
		$subscription	= \Stripe\Subscription::create([
			'customer'	=> $customer->id,
			'items'		=> [['plan' => $plan]],
		]);
		$last4	= $customer->sources->data[0]->last4;
		//	Change status of existing plans
		Subscription::where('vet_id', '=', Auth::user()->id)->update(['status' => 0]);
		
		//	Add new subscription
		$sub			= new Subscription();
		$sub->vet_id	= Auth::user()->id;
		$sub->plan_id	= 1;
		$sub->customer_id		= $customer->id;
		$sub->subscription_id	= $subscription->id;
		$sub->is_stripe	= 1;
		$sub->method	= 1;
		$sub->payment_status	= 0;
		$sub->last4	= $last4;
		$sub->currency	= $currency;
		//$sub->start_date= date('Y-m-d');
		//$sub->end_date	= date('Y-m-d', strtotime('+1 year'));
		//$sub->status	= 1;
		$sub->save();
		
		$user	= Auth::user();
		$data	= array('name' => $user->firstname.' '.$user->lastname);
		Mail::send('emails.subscription-notification', $data, function($message) use ($user)
		{
			$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
		});
		return redirect('subscription')->with('message', trans('words.ctrl_subscription_success'));
		
	}
	public function showChangeDetails() {
		\App::setLocale(Session::get('locale'));
		$planArray	= array(1 => trans('words.1_year_plan'), trans('words.free_plan'), trans('words.voucher'));
		view()->share('planArray', $planArray);
		return view('payment.change-payment-details');
	}
	public function doChangeDetails(Request $request) {
		\App::setLocale(Session::get('locale'));
		$sub	= Subscription::where('vet_id', '=', Auth::user()->id)->where('is_stripe', '=', 1)->orderBy('created_at', 'desc')->first();
		$token	= $request->input('stripeToken');
		$email	= Auth::user()->email;
		\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
		try {
			$customer = \Stripe\Customer::retrieve($sub->customer_id); // stored in your application
			$customer->source = $token; // obtained with Checkout
			$customer->save();
			
			if(isset($customer->sources->data[0]->last4)) {	// iban
				$last4	= $customer->sources->data[0]->last4;
				$sub->last4	= $last4;
			} else if(isset($customer->sources->data[0]->sepa_debit->last4)) { // card
				$last4				= $customer->sources->data[0]->sepa_debit->last4;
				$mandate_reference	= $customer->sources->data[0]->sepa_debit->mandate_reference;
				$mandate_url		= $customer->sources->data[0]->sepa_debit->mandate_url;
				$sub->last4			= $last4;
				$sub->mandate_reference	= $mandate_reference;
				$sub->mandate_url		= $mandate_url;
			}
			$sub->save();
			return redirect('subscription')->with('message', trans('words.ctrl_card_updated'));
		}
		catch(\Stripe\Error\Card $e) {

			// Use the variable $error to save any errors
			// To be displayed to the customer later in the page
			$body	= $e->getJsonBody();
			$err 	= $body['error'];
			$error	= $err['message'];
			return redirect('subscription')->withErrors('message', $error);
		}
		
	}
	public function cancelSubscription($id) {
		\App::setLocale(Session::get('locale'));
		\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
		
		if(Auth::user()->user_type == 4) {
			$sub	= Subscription::where('id', '=', $id)->first();
			if($sub) {
				$subscription = \Stripe\Subscription::retrieve($sub->subscription_id);
				$subscription->cancel(['at_period_end' => true]);
				$sub->cancel_status	= 1;
				$sub->save();
				return redirect('subscription')->with('message', trans('words.subscription_cancelled'));
			} else {
				return redirect('subscription')->withErrors('message', trans('words.footer_script_something_went_wrong'));
			}
		} else if(Auth::user()->user_type == 2) {
			$sub	= Subscription::where('vet_id', '=', Auth::user()->id)->where('id', '=', $id)->first();
			if($sub) {
				$subscription = \Stripe\Subscription::retrieve($sub->subscription_id);
				$subscription->cancel(['at_period_end' => true]);
				$sub->cancel_status	= 1;
				$sub->save();
				return redirect('subscription')->with('message', trans('words.subscription_cancelled'));
			} else {
				return redirect('subscription')->withErrors('message', trans('words.footer_script_something_went_wrong'));
			}
		} else {
			return redirect('subscription')->withErrors('message', trans('words.footer_script_you_are_restricted'));
		}
	}
	public function doChangeIbanDetails(Request $request) {
		\App::setLocale(Session::get('locale'));
		$validator = Validator::make($request->all(), [
			'iban'	=> 'required',
			'name'	=> 'required'
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			
			\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
			//	Source Creation
			$source = \Stripe\Source::create(array(
			  "type" => "sepa_debit",
			  "sepa_debit" => array("iban" => $request->input('iban')),
			  "currency" => "eur",
			  "owner" => array(
				"name" => $request->input('name'),
			  ),
			));
			
			$sub	= Subscription::where('vet_id', '=', Auth::user()->id)->where('is_stripe', '=', 1)->orderBy('created_at', 'desc')->first();
			try {
				$customer = \Stripe\Customer::retrieve($sub->customer_id); // stored in your application
				$customer->source = $source->id; // obtained with Checkout
				$customer->save();
				
				if(isset($customer->sources->data[0]->last4)) {	// iban
					$last4	= $customer->sources->data[0]->last4;
					$sub->last4	= $last4;
				} else if(isset($customer->sources->data[0]->sepa_debit->last4)) { // card
					$last4				= $customer->sources->data[0]->sepa_debit->last4;
					$mandate_reference	= $customer->sources->data[0]->sepa_debit->mandate_reference;
					$mandate_url		= $customer->sources->data[0]->sepa_debit->mandate_url;
					$sub->last4			= $last4;
					$sub->mandate_reference	= $mandate_reference;
					$sub->mandate_url		= $mandate_url;
				}
				$sub->save();
				return redirect('subscription')->with('message', trans('words.ctrl_card_updated'));
			}
			catch(\Stripe\Error\Card $e) {

				// Use the variable $error to save any errors
				// To be displayed to the customer later in the page
				$body	= $e->getJsonBody();
				$err 	= $body['error'];
				$error	= $err['message'];
				return redirect('subscription')->withErrors('message', $error);
			}
			
		}
	}
	public function doAssignSubscription(Request $request) {
		\App::setLocale(Session::get('locale'));
		if(Auth::user()->user_type == 4) {
			$validator = Validator::make($request->all(), [
				'vet_id'	=> 'required',
				'plan'		=> 'required'
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			} else {
				
				if($request->input('plan') != 3) {
					//	Change status of existing plans
					Subscription::where('vet_id', '=', $request->input('vet_id'))->update(['status' => 0]);
					//	Assign subscription
					$sub			= new Subscription();
					$sub->vet_id	= $request->input('vet_id');
					$sub->plan_id	= $request->input('plan');
					
					$method	= trans('words.free');
					$sub->voucher	= $request->input('voucher_term');
					$sub->start_date= date('Y-m-d');
					$sub->end_date	= date('Y-m-d', strtotime('+1 year'));
					$sub->status	= 1;
					$sub->save();
				
				} else {
					//	Get the last and ongoing plan
					$sub	= Subscription::where('vet_id', '=', $request->input('vet_id'))->where('status', '=', 1)->orderBy('id', 'desc')->first();
					
					if($sub) {
						//	Change status of existing plans
						Subscription::where('vet_id', '=', $request->input('vet_id'))->where('id', '!=', $sub->id)->update(['status' => 0]);
						$sub->end_date	= date('Y-m-d', strtotime('+'.$request->input('voucher_term'), strtotime($sub->end_date)));
						$sub->status	= 1;
						$sub->save();
					} else {
						//	Change status of existing plans
						Subscription::where('vet_id', '=', $request->input('vet_id'))->update(['status' => 0]);
						$method	= trans('words.voucher');
						//	Assign subscription
						$sub			= new Subscription();
						$sub->vet_id	= $request->input('vet_id');
						$sub->plan_id	= $request->input('plan');
						
						$sub->voucher	= $request->input('voucher_term');
						$sub->start_date= date('Y-m-d');
						$sub->end_date	= date('Y-m-d', strtotime('+'.$request->input('voucher_term')));
						$sub->status	= 1;
						$sub->save();
				
					}
				}
				
				$user	= User::find($request->input('vet_id'));
				$data	= array('name' => $user->firstname.' '.$user->lastname,'method' => $method);
				Mail::send('emails.admin-subscription-notification', $data, function($message) use ($user)
				{
					$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
				});
				return redirect('view-user/'.$request->input('vet_id'))->with('message', trans('words.ctrl_subscription_assigned'));
			}
		}
	}
	public function stripeCall(Request $request) {
		
		// Retrieve the request's body and parse it as JSON
		$input = @file_get_contents("php://input");
		$event_json = json_decode($input);
		//mail('deepanchakravarthi.k@gmail.com', 'TEST 1', $event_json->data->object->customer.' '.$event_json->data->object->lines->data[0]->id);
		//mail('deepanchakravarthi.k@gmail.com', 'TEST STRIPE - '.time(), print_r($event_json, 1));
		if($event_json->type == 'invoice.payment_succeeded') {
			//	amount, charge, cus_id, sub_id
			$sub		= Subscription::where('customer_id', '=', $event_json->data->object->customer)->where('subscription_id', '=', $event_json->data->object->lines->data[0]->id)->orderBy('id', 'desc')->first();
			$payment			= new Payment();
			$payment->vet_id	= $sub->vet_id;
			$payment->amount	= floatval($event_json->data->object->amount_due/100);
			$payment->charge_id	= $event_json->data->object->charge;
			$payment->customer_id		= $event_json->data->object->customer;
			$payment->subscription_id	= $event_json->data->object->lines->data[0]->id;
			$payment->status	= 1;
			$payment->save();
			//	update status
			$sub->start_date= date('Y-m-d');
			if($sub->end_date == '0000-00-00') {
				$sub->end_date	= date('Y-m-d', strtotime('+1 year'));
			} else {
				$sub->end_date	= date('Y-m-d', strtotime('+1 year', strtotime($sub->end_date)));
			}
			$sub->status	= 1;
			$sub->payment_status	= 1;
			$sub->save();
		} else if($event_json->type == 'invoice.payment_failed') {
			//	amount, charge, cus_id, sub_id
			$sub	= Subscription::where('customer_id', '=', $event_json->data->object->customer)->where('subscription_id', '=', $event_json->data->object->lines->data[0]->id)->orderBy('id', 'desc')->first();
			$payment			= new Payment();
			$payment->vet_id	= $sub->vet_id;
			$payment->amount	= floatval($event_json->data->object->amount_due/100);
			$payment->charge_id	= $event_json->data->object->charge;
			$payment->customer_id		= $event_json->data->object->customer;
			$payment->subscription_id	= $event_json->data->object->lines->data[0]->id;
			$payment->status	= 2;
			$payment->save();
			//	update status
			$sub->status	= 0;
			$sub->save();
		} else if($event_json->type == 'customer.subscription.deleted') {
			$sub	= Subscription::where('customer_id', '=', $event_json->data->object->customer)->where('subscription_id', '=', $event_json->data->object->lines->data[0]->id)->orderBy('id', 'desc')->first();
			//	update status
			$sub->cancel_status	= 0;
			$sub->save();
		}
		
		http_response_code(200);
	}
	
	public function checkSubscriptionEndTime() {
		$subscriptions	= Subscription::where('status', '=', 1)->where('end_date', '<', date('Y-m-d'))->get();
		if($subscriptions) {
			foreach($subscriptions as $key => $value) {
				$sub	= Subscription::find($value->id);
				$sub->status	= 0;
				$sub->save();
			}
		}
	}
}