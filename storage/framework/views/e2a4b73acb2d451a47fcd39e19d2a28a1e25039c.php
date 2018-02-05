<!-- Stored in resources/views/index.blade.php -->
<?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!--============================= SLIDER =============================-->
    <section class="slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="slider-content">
                        <h1><?php echo e(trans('words.search_slider_text1')); ?></h1>
                        <h3><?php echo e(trans('words.search_slider_text2')); ?></h3>
						<?php echo Form::open(array('url' => SITE_PATH.'/search', 'class' => 'form-wrap mt-5', 'onsubmit' => 'return validateSearchForm();')); ?>

							<div class="btn-group" role="group" aria-label="">
								<p id="tooltip" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php echo e(trans('words.search_slider_form1')); ?>"></p>
								<input type="text" placeholder="<?php echo e(trans('words.search_slider_form2')); ?>" name="id" id="id" class="btn-group1">
								<select class="btn-group2" name="id_type" style="-webkit-appearance: none;-moz-appearance: none;-webkit-border-radius: 0px;background-image: url('https://image.flaticon.com/icons/svg/60/60781.svg');background-position: 99% 50%;background-repeat: no-repeat;background-size: 16px;">
									<option value="chip_id"><?php echo e(trans('words.chip_id')); ?></option>
									<option value="pet_id"><?php echo e(trans('words.pet_id')); ?></option>
									<option value="tattoo_id"><?php echo e(trans('words.tattoo')); ?></option>
								</select>
								<button type="submit" class="btn-form" id="search_button"><i class="pe-7s-search"></i>&nbsp;<?php echo e(trans('words.search')); ?></button>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//END SLIDER -->
    <!--============================= HOW IT WORK =============================-->
    <section class="howit-work main-block center-block" id="howitworks">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo e(trans('words.search_how1')); ?> <span><?php echo e(trans('words.id')); ?></span> <?php echo e(trans('words.search_how2')); ?></h2>
                    <h6><?php echo e(trans('words.search_how_text1')); ?></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="howit-wrap">
                        <img src="<?php echo e(SITE_PATH); ?>/images/chip.png">
                        <h4><?php echo e(trans('words.chip')); ?></h4>
                        <p><?php echo e(trans('words.chip_text')); ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="howit-wrap">
                        <img src="<?php echo e(SITE_PATH); ?>/images/tattoo.png">
                        <h4><?php echo e(trans('words.tattoo')); ?></h4>
                        <p><?php echo e(trans('words.tattoo_text')); ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="howit-wrap">
                        <img src="<?php echo e(SITE_PATH); ?>/images/tag.png">
                        <h4><?php echo e(trans('words.tag')); ?></h4>
                        <p><?php echo e(trans('words.tag_text')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//END HOW IT WORK -->
<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>