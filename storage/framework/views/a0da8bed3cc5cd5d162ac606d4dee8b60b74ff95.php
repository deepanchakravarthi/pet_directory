<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<section class="service-title" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.aboutus')); ?></h2>
				</div>
			</div>
		</div>
	</section>
    <section class="testimonial main-block center-block">
        <div class="container">
            <div class="row">
				<div class="col-md-1"></div>
                <div class="col-md-10">
                    <p><?php echo e(trans('words.about_us_line1')); ?></p>
					<p><?php echo e(trans('words.about_us_line2')); ?></p>
					<p><?php echo e(trans('words.about_us_line3')); ?></p>
					<p><?php echo e(trans('words.about_us_line4')); ?></p>
					<p><?php echo e(trans('words.about_us_line5')); ?></p>
                </div>
            </div>
        </div>
    </section>
<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>