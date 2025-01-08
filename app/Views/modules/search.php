<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Search</h1>

			<form class="banner-search" action="<?= base_url() . 'search' ?>">
				<input type="text" name="mls_id"
					placeholder="<?php echo !empty($mls_data['mls_id']) ? $mls_data['mls_id'] : ""; ?>" />

				<button type="submit" class="button">
					Search <i class="far fa-arrow-right small-margin-left"></i>
				</button>
			</form>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<?php if (!empty($mls_data)) { ?>
			<div class="column full-width">
				<h2 class="heading">MLS Listing: <?php echo $mls_data['mls_id']; ?></h2>
			</div>

			<div class="content column">
				<div class="content-result">
					<h5>Address:</h5>
					<address><?php echo $mls_data['mls_address1']; ?>,<br><?php echo $mls_data['mls_city']; ?>,
						<?php echo $mls_data['mls_state']; ?> 	<?php echo $mls_data['mls_zip']; ?></address>

					<h5>Concessions:</h5>
					<p><?php echo $mls_data['mls_concessions']; ?></p>

					<h5>Commission:</h5>
					<p><?php echo $mls_data['mls_commission']; ?></p>

					<h5>Showing Instructions: </h5>
					<p><?php echo $mls_data['mls_showing_instructions']; ?></p>

					<hr>

					<h5>Name</h5>
					<p><?php echo $mls_data['agent_first_name'] . ' ' . $mls_data['agent_last_name']; ?></p>

					<h5>Company</h5>
					<p><?php echo $mls_data['agent_company']; ?></p>

					<h5>Phone</h5>
					<p><?php echo $mls_data['agent_phone']; ?></p>

					<h5>Email</h5>
					<p><?php echo $mls_data['agent_email']; ?></p>
				</div>
			</div>
		<?php } else { ?>
			<div class="column full-width">
				<h2 class="heading"></h2>
			</div>
			<div class="content column">
				<div class="content-result">No Record found</div>
			</div>
		<?php } ?>
		<div class="sidebar column">
			<div class="sidebar-inner">
				<section class="spots">
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
				</section>
			</div>
		</div>
	</div>
</main>
<!-- start main  -->

<!-- start spots section -->
<section class="spots">
	<div class="row">
		<div class="column no-float">
			<div class="spots-inner">
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

<?= $this->endSection() ?>