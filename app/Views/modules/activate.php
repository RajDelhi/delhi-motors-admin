<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title"></h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<p> <?php echo !empty($msg)?$msg:""; ?></p>

		</div>



	</div>
</main>
<!-- start main  -->

<!-- start action section -->
<section class="action">
	<div class="row">
		<div class="column no-float">
			<h2>Get Started Today!</h2>

			<a href="#" class="button alt-01">List Your Home</a>

			<a href="#" class="button"><span>Use Our</span> Savings Calculator</a>
		</div>
	</div>

	<div class="action-bg">
		<img src="images/action-bg.png" alt="">
	</div>
</section>
<!-- end action section -->
<?= $this->endSection() ?>
