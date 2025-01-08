<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">NAR Resources Start Date August 17 th 2024.</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<h2>August 17, 2024:</h2>

			<p>Any offers of compensation CANNOT BE INCLUDED IN THE MLS OR ANY OTHER ANCILLARY SERVICE PROVIDED BY realMLS. To do so puts yourself, your brokerage, the MLS and the Association at risk of being in violation of the settlement. This is a part of the settlement agreement and will be aggressively monitored.</p>

			<p>No reference to compensation can be entered into any part of a listing or any third-party ancillary product. Offers of compensation or any reference to an offer of compensation cannot be entered in:</p>

			<ul>
				<li>Any fill in the blank data field of a listing</li>
				<li>Directions</li>
				<li>Public Remarks</li>
				<li>Supplement</li>
				<li>Private Remarks</li>
				<li>Documents</li>
				<li>Photos</li>
				<li>Tours/Videos</li>
				<li>Open Houses</li>
				<li>3rd Party programs such as Showingtime etc.</li>
			</ul>

			<p>Some examples of terms that will be monitored are compensation, commission, bonus, concession and seller to pay if used as a form of an offer to pay compensation. If you enter “Seller to pay closing costs”, or “concession offered for flooring” that is acceptable.</p>
		</div>

		<div class="sidebar column">
			<div class="sidebar-inner">
				<section class="sidebar-block">
					<h2>Quick links</h2>

					<ul>
						<li class="active"><a href="<?= base_url() . 'nar-resources-start-date-august-17-2024'; ?>">NAR Resources: Start Date August 17th 2024</a></li>
						<li><a href="<?= base_url() . 'nar-resources-mandatory-buyers-broker-agreements'; ?>">NAR Resources: Mandatory Buyers Broker Agreements</a></li>
						<li><a href="<?= base_url() . 'nar-resources-contract-signed-prior-to-august-17'; ?>">NAR Resources: Contract Signed Prior to August 17th</a></li>
						<li><a href="<?= base_url() . 'nar-resources-written-buyer-agreements'; ?>">NAR Resources: Written Buyer Agreements</a></li>
					</ul>
				</section>
			</div>
		</div>
	</div>
</main>
<!-- start main  -->

<!-- start action section -->
<section class="action">
	<div class="row">
		<div class="column no-float">
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
		</div>
	</div>

	<div class="action-bg">
		<img src="<?= base_url() . 'images/action-bg.png' ?>" alt="">
	</div>
</section>
<!-- end action section -->

<?= $this->endSection() ?>
