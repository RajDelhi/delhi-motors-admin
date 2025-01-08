<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Terms of Service</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<h2>Agreement to List Commission and Concession Listings.</h2>

			<p>The following agreement is an agreement for listing commissions and concessions, advertisement of the Agent/Broker listing, personal contacts, and personal photo or logo for an MLS listing. It is understood that the Agent/Broker has a MLS listing agreement signed by the owner/seller of said property. The Agent/Broker is solely responsible for information posted.</p>

			<p>Further, the Agent/Broker agrees to change the listing page status within 48 hours after the property has been Withdrawn, Cancelled or Closed. There are no listing fees for the Agent/Broker for a listing. The listing will be listed for 6 months on CommissionVerification.com. An expire notification will be sent 10 days before the listing expires. However, the agent/broker may Cancel the listing for any reason at any time.</p>

			<p>CommissionVerification.com will be held harmless for any legal issues. Examples of, but not in its entirety: for disseminating names, addresses, commission, or concession amounts, for incorrect commission and/or concession amounts, incorrect showing instructions, or status of listing. CommissionVerification.com reserves the right to send notifications to the agent/broker.</p>
		</div>

		<div class="sidebar column">
			<div class="sidebar-inner">
				<section class="sidebar-block">
					<h2>Quick links</h2>

					<ul>
						<ul>
						<li><a href="<?= base_url() . 'nar-resources-start-date-august-17-2024'; ?>">NAR Resources: Start Date August 17th 2024</a></li>
						<li><a href="<?= base_url() . 'nar-resources-mandatory-buyers-broker-agreements'; ?>">NAR Resources: Mandatory Buyers Broker Agreements</a></li>
						<li><a href="<?= base_url() . 'nar-resources-contract-signed-prior-to-august-17'; ?>">NAR Resources: Contract Signed Prior to August 17th</a></li>
						<li><a href="<?= base_url() . 'nar-resources-written-buyer-agreements'; ?>">NAR Resources: Written Buyer Agreements</a></li>
					</ul>
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
