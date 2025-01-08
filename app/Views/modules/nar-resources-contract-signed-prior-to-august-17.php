<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">NAR Resources: Contract signed Prior to August 17 th , are they valid?</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<h2>Listing Agreements signed prior to August 17, 2024:</h2>

			<ul>
				<li>If the listing agreement instructs the listing broker to make an offer of compensation without reference to the MLS, no change to the listing agreement is needed, as the listing broker can comply with that instruction without violating the MLS policy change.</li>
				<li>But if the listing agreement specifies that offers of compensation be made “on the MLS”, then yes, the listing broker should work with the seller to amend the listing agreement before the MLS policy change is implemented, to make it clear the listing broker will not make an offer of compensation on the MLS and will not be violating the listing agreement by failing to make an offer of compensation on the MLS.</li>
			</ul>

			<p>If you used the Exclusive Right of Sale Listing Agreements dated 08/2022, check for:</p>

			<ul>
				<li>Single Agent Broker-Lines 234-235</li>
				<li>Transaction Broker-Lines 236-237</li>
				<li>Vacant Land Single Agent Broker-Lines 212-213</li>
				<li>Vacant Land Transaction Broker-Lines 211-212</li>
			</ul>

			<p>If you used the Florida Realtor Exclusive Right of Sale Listing Agreements dated prior to March 2024 (3/2024), then you will need to amend the agreement.</p>

			<h2>Buyers Broker Agreements signed prior to August 17, 2024:</h2>

			<p>Possibly, be sure after the effective date of this policy that all your Buyer Broker Agreements contain:</p>

			<ul>
				<li>A specific and conspicuous disclosure of the amount or rate of compensation the Participant will receive or how this amount will be determined, to the extent that the Participant will receive compensation from any source</li>
				<li>The amount of compensation in a manner that is objectively ascertainable and not open-ended.</li>
				<li>A term that prohibits the Participant from receiving compensation for brokerage services from any source that exceeds the amount or rate agreed to in the agreement with the buyer</li>
				<li>A conspicuous statement that broker fees and commissions are not set by law and are fully negotiable. (This could be on a separate agreement but is required)</li>
			</ul>

			<p>These contracts/forms do not need to be amended to accomplish the new disclosures. Participants/Subscribers can do a separate disclosure to the seller/buyer to satisfy the requirement.</p>
		</div>

		<div class="sidebar column">
			<div class="sidebar-inner">
				<section class="sidebar-block">
					<h2>Quick links</h2>

					<ul>
						<li><a href="<?= base_url() . 'nar-resources-start-date-august-17-2024'; ?>">NAR Resources: Start Date August 17th 2024</a></li>
						<li><a href="<?= base_url() . 'nar-resources-mandatory-buyers-broker-agreements'; ?>">NAR Resources: Mandatory Buyers Broker Agreements</a></li>
						<li class="active"><a href="<?= base_url() . 'nar-resources-contract-signed-prior-to-august-17'; ?>">NAR Resources: Contract Signed Prior to August 17th</a></li>
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
