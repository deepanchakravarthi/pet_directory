<?php
require_once('lib/stripe/init.php');

$stripe = array(
  "secret_key"      => "sk_test_hoPIlYUpBMCAT0RddtT8dbYE",
  "publishable_key" => "pk_test_LGqUjEtms6Fja343vlSCxi3s"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
//	Source Creation
$source = \Stripe\Source::create(array(
  "type" => "sepa_debit",
  "sepa_debit" => array("iban" => "DE89370400440532013000"),
  "currency" => "eur",
  "owner" => array(
    "name" => "Jenny Rosen",
  ),
));

//	Customer Creation
$customer = \Stripe\Customer::create(array(
  "email" => "second_customer@test.com",
  "source" => $source->id,
));
//print_r($customer->sources->data[0]->sepa_debit);
echo '<br>'.$customer->sources->data[0]->sepa_debit->last4;
echo '<br>'.$customer->sources->data[0]->sepa_debit->mandate_reference;
echo '<br>'.$customer->sources->data[0]->sepa_debit->mandate_url;
echo '<br><br><br>===>';
print_r($customer);
echo '<br><br><br>';

//	Assign Subscription to Customer
$subscription	= \Stripe\Subscription::create([
	'customer'	=> $customer->id,
	'items'		=> [['plan' => 'my_first_plan_id']],
]);
  
print_r($subscription);
?>