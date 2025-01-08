<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

	<!-- start hero section -->
	<section class="hero">
		<div class="hero-slider">
			<div class="hero-slide">
				<div class="hero-slide-image">
					<img src="<?= base_url() . 'images/main-banner.png' ?>" alt="Slide Image" />
				</div>

				<div class="hero-slide-content">
					<div class="row">
						<div class="columns no-float">
							<div class="hero-slide-text">
								<h2>Delhi Motors Admin Home Page</h2>

								<p> </p>

<!--								<form action="<?= base_url() . 'search' ?>" class="hero-search-form">
									<input type="text" name="mls_id" placeholder="MLS#" />

									<button type="submit" class="button">
										Search <i class="far fa-arrow-right small-margin-left"></i>
									</button>
								</form>-->

					
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end hero section -->

	<!-- start main -->
	<main role="main" class="no-padding">
		<!-- start spots section -->
		<section class="spots">
			<div class="row">
				<div class="column no-float">
					<div class="spots-inner no-border">
						<div class="spots-block">
							<a href="#">
								<img src="<?= base_url() . 'images/spot-ads.png' ?>" alt="">
							</a>
						</div>

						<div class="spots-block">
							<a href="#">
								<img src="<?= base_url() . 'images/spot-ads.png' ?>" alt="">
							</a>
						</div>

						<div class="spots-block">
							<a href="#">
								<img src="<?= base_url() . 'images/spot-ads.png' ?>" alt="">
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end spots section -->
	</main>
	<!-- start main  -->

	<!-- start action section -->
	<section class="action">
		<div class="row">
<!--			<div class="column no-float">
				<h2>Agents and Advertisers. Get Started Today!</h2>

				<?php if (!session()->get('agent_id')) { ?>
					<a href="<?= base_url() . 'login' ?>" class="button alt-01">
						Login/List <i class="far fa-arrow-right small-margin-left"></i>
					</a>
				<?php } else { ?>
					<a href="<?php echo base_url() . 'add-list'; ?>" class="button alt-01">
						Login/List <i class="far fa-arrow-right small-margin-left"></i>
					</a>
				<?php } ?>

				<a href="<?php echo base_url() . 'advertise'; ?>" class="button">
					Advertise <i class="far fa-arrow-right small-margin-left"></i>
				</a>
			</div>-->
		</div>

		<div class="action-bg">
			<img src="<?= base_url() . 'images/action-bg.png' ?>" alt="">
		</div>
	</section>
	<!-- end action section -->

<?= $this->endSection() ?>
