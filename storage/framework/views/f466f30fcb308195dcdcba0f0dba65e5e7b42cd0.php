<?php	$currentPlan	= '';
		$currentPlanCost= '';
		$isStripe		= 0; ?>
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<style>
/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  background-color: white;
  height: 40px;
  padding: 10px 12px;
  border-radius: 4px;
  border: 1px solid transparent;
  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.change_payment_details')); ?></h2>
				</div>
			</div>
		</div>
	</section>
	<section class="testimonial main-block center-block">
		<div class="container sitecontainer bgw">
			<div class="row">
				<div class="col-md-12 m22 single-post">
					<div class="widget">
						<div class="large-widget m30">
							<div class="post-desc">
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="appoform-wrapper">
											<div class="row">
												<div class="col-md-2 col-sm-12">
												</div>
												<div class="col-md-8 col-sm-12">
													<?php if(Session::has('message')): ?>
													<div class="alert alert-success" role="alert">
														<?php echo e(Session::get('message')); ?>

													</div>
													<?php endif; ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4 col-sm-12">
												</div>
												<div class="col-md-6 col-sm-12">
													<p><?php echo e(trans('words.change_payment_details_text')); ?></p>
													<h5><?php echo e(trans('words.plan')); ?>: <span style="color:#0069D9;font-weight:bold;"><?php echo e($planArray[1]); ?></span> & <?php echo e(trans('words.cost')); ?>: <span style="color:#0069D9;font-weight:bold;"><?php echo e(SITE_PLAN_COST); ?></span></h5>
													<div style="width:100%;padding-left:20px;padding-right:20px;" class="mt-5">
													<?php echo Form::open(array('url' => 'change-payment-details', 'class' => 'row', 'id' => 'payment-form')); ?>

														
															<label for="card-element">
															<?php echo e(trans('words.credit_or_debit_card')); ?>

															</label>
															<div id="card-element" class="col-md-12 col-sm-12">
															<!-- a Stripe Element will be inserted here. -->
															</div>
															
															<!-- Used to display Element errors -->
															<div id="card-errors" role="alert"></div>
														

														<button class="btn btn-primary mt-3"><?php echo e(trans('words.change_details')); ?></button>
													</form>
													</div>
												</div>
											</div>
											
											<!-- end newsletter -->
										</div>
										<!-- end form-container -->
									</div>
									<!-- end col -->
								</div>
								<!-- end row -->

							</div>
							<!-- end post-desc -->
						</div>
						<!-- end large-widget -->
					</div>
					<!-- end widget -->
				</div>
				<!-- end col -->
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</section>
<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script src="https://js.stripe.com/v3/"></script>
<script>
// Create a Stripe client
var stripe = Stripe('<?php echo e(SITE_STRIPE_PK); ?>');

// Create an instance of Elements
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server
      stripeTokenHandler(result.token);
    }
  });
});
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>