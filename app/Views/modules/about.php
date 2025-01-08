<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">About Commission Verification</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<p>CommissionVerification.com was created for agents to share the commission and concession amounts offered agents and buyers on their MLS listing. Our easy-to-use, Agent to Agent, platform offers listing agents a place to post their agent cooperation details. Agents may also post their property showing instructions for agents to review along with their personal photo or company logo.</p>

			<h2>List Your Property On CommissionVerification.com</h2>

			<ul>
				<li>Listing Agents post their listing commission and concession amounts to their individual accounts for 6 months, or until Withdrawn, Sold or Cancelled. No listing fees.</li>
				<li>Agent name, license number, MLS ID number, and listing street address, is required.</li>
				<li>This platform will display listing Agent offered commission and/or concession amounts on behalf of their owners/ sellers who wish to utilize the benefits associated with an MLS listing.</li>
				<li>Agents personal photo or logo posted to the listing.</li>
				<li>Showing instructions with Agent name and contacts.</li>
				<li>Our platform is Agent to Agent so licensed real estate agents only.</li>
			</ul>
		</div>

		<div class="sidebar column">
			<div class="sidebar-inner">
				<section class="sidebar-block">
					<h2>Quick links</h2>

					<ul>
						<li><a href="<?= base_url() . 'nar-resources-start-date-august-17-2024'; ?>">NAR Resources: Start Date August 17th 2024</a></li>
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
