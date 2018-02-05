<?php
require_once('lib/stripe/init.php');

$stripe = array(
  "secret_key"      => "sk_test_hoPIlYUpBMCAT0RddtT8dbYE",
  "publishable_key" => "pk_test_LGqUjEtms6Fja343vlSCxi3s"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);

	$token	= $_POST['stripeToken'];
	$email	= 'newcustomer@test.com';
	// Customer Creation
	$customer	= \Stripe\Customer::create(array(
		'email'	=> $email,
		'source'=> $token
	));
print_r($customer->sources->data[0]->last4);
echo '<br>===>';
print_r($customer);
echo '<br><br><br>';
	//	Assign Subscription to Customer
	$subscription	= \Stripe\Subscription::create([
		'customer'	=> $customer->id,
		'items'		=> [['plan' => 'my_first_plan_id']],
	]);
  
  print_r($subscription);
?>