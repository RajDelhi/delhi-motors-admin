<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Advertise</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<p>Since our founding in 1999, all of us at FlatFee.com have worked hard under the belief that we must
				provide consumers with alternate ways to sell and buy a house. When technology started to play a more
				influential role in every aspect of the real estate industry back in the late 1990’s, we saw the need
				for change become more obvious and more urgent.</p>

			<p>Now the Multiple listing Service ( MLS ) allows the MLS listings to be seen on Realtor.com, Zillow,
				Trulia, Homes.com, along with their own public site….<br>The public has endless ways to view for-sale
				and rental properties.</p>

			<h2>List Your Property on FlatFee.com</h2>

			<p>Today, sellers can now gain the exposure they need with access to the MLS simply by paying a flat listing
				fee with a list for sale by owner instead of the traditional listing commission, a savings of thousands
				of dollars. This is the concept behind the FlatFee.com program, which we felt could provide the control
				for buyer and seller, enabling them to save money at the same time.</p>

			<p>It is the operating goal of FlatFee.com to embrace advances in technology without losing personal touch
				and professional service in our interactions with customers. We took great care to open an office that
				runs efficiently and provides a professional flat fee MLS listing service for sellers.</p>

			<p>Once the public discovered they had a choice in how they could sell a house, the concept flourished. With
				Cliff Glansen’s 10 years of experience as a broker, you can be sure that listing your home with
				FlatFee.com is the right choice to make.</p>

			<h2>Experience the Convenience of Modern MLS Listings</h2>

			<p>Our mission at FlatFee.com is providing you, as an owner, control over the listing and sale process of
				your property. This coupled with the listing commission savings allows you to be part of the entire MLS
				process without being a licensed agent.</p>

			<p>In addition of having your for-sale and/or rental MLS listing linked to Realtor.com, Zillow.com,
				Trulia.com for nationwide public exposure you will receive all public inquiries sent to our office. Each
				local MLS is comprised of hundreds of brokers and agents. Your MLS listing will be seen by those same
				brokers and agents. They will contact you directly with questions, to schedule showings and ultimately
				present offers to you.</p>
		</div>
		<?php echo view("layout/quickLink"); ?>
	</div>
</main>
<!-- start main  -->

<!-- start action section -->
<?php  echo view("layout/action");   ?>
<!-- end action section -->

<?= $this->endSection() ?>
