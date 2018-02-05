@include('layouts.header')
<div class="container sitecontainer bgw">
	<div class="row">
		<div class="col-md-12 m22 single-post">
			<div class="widget">
				<div class="large-widget m30">
					<div class="post-desc">

						<div class="page-404-content">
							<div class="row">
								<div class="col-sm-6 hidden-xs">
									<img alt="404-page" src="<?php echo SITE_PATH; ?>/images/image-404.jpg">
								</div>
								<div class="col-sm-6 col-xs-12">
									<h2>
									500
									<span>Error!</span>
									</h2>
									<p>
									Sorry, something went wrong. <br>Please go to
									<a href="<?php echo SITE_PATH; ?>/">Home </a>.
									</p>
								</div>
							</div>
						</div>

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
@include('layouts.footer')