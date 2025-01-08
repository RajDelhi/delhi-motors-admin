<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">NAR Resources: Mandatory Buyers Broker Agreements</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<h2>Effective August 17, 2024</h2>

			<p>Effective August 17, 2024, the settlement terms mandate that MLSs must require all participants/subscribers providing brokerage services to a buyer must have a written agreement before touring a listing (services such as but not limited to identifying potential properties, arranging for the buyer to tour a property, performing or facilitating negotiations on behalf of the buyer, presenting offers by the buyer, or other services for the buyer). That agreement must describe the broker’s compensation and must include:</p>

			<ul>
				<li>A specific and conspicuous disclosure of the amount or rate of compensation the Participant will receive or how this amount will be determined, to the extent that the Participant will receive compensation from any source</li>
				<li>The amount of compensation in a manner that is objectively ascertainable and not open-ended.</li>
				<li>A term that prohibits the Participant from receiving compensation for brokerage services from any source that exceeds the amount or rate agreed to in the agreement with the buyer</li>
				<li>A conspicuous statement that broker fees and commissions are not set by law and are fully negotiable. (This could be on a separate agreement but is required)</li>
			</ul>

			<p>MLS Participants who simply market their services or just talk to a buyer—like at an open house or by providing an unrepresented buyer access to a house they have listed will not at that time be required to obtain a Buyer’s Broker Agreement.</p>

			<ul>
				<li>The obligation to enter into a written buyer agreement is triggered just prior to an MLS Participant taking a buyer to tour a home, regardless of what other acts the MLS Participant performs for the buyer.</li>
				<li>An MLS Participant performing only ministerial acts—and who has not taken the buyer to tour a home—is not working with the buyer and therefore does not yet need to enter into a written buyer agreement. (Updated 7/23/24)</li>
				<li>The “working with” language is intended to distinguish MLS Participants who provide brokerage services to a buyer—such as identifying potential properties, arranging for the buyer to tour a property, performing or facilitating negotiations on behalf of the buyer, presenting offers by the buyer, or other services for the buyer —from MLS Participants who simply market their services or just talk to a buyer—like at an open house or by providing an unrepresented buyer access to a house they have listed.</li>
				<li>If the MLS Participant is working only as an agent or subagent of the seller, then the participant is not “working with the buyer.” In that scenario, an agreement is not required because the participant is performing work for the seller and not the buyer.</li>
				<li>A written buyer agreement is required prior to a buyer “touring a home.” An MLS Participant “working with” a buyer can enter into the written buyer agreement at any point but must do so by no later than prior to the buyer “touring a home,” unless state law requires a written buyer agreement earlier in time (Updated 7/23/24)
				<li>Touring a home means when the buyer and/or the MLS Participant, or other agent, at the direction of the MLS Participant working with the buyer, enter the house. This includes when the MLS Participant or other agent, at the direction of the MLS Participant, working with the buyer enters the home to provide a live, virtual tour to a buyer not physically present.</li>
			</ul>
		</div>

		<div class="sidebar column">
			<div class="sidebar-inner">
				<section class="sidebar-block">
					<h2>Quick links</h2>

					<ul>
						<li><a href="<?= base_url() . 'nar-resources-start-date-august-17-2024'; ?>">NAR Resources: Start Date August 17th 2024</a></li>
						<li class="active"><a href="<?= base_url() . 'nar-resources-mandatory-buyers-broker-agreements'; ?>">NAR Resources: Mandatory Buyers Broker Agreements</a></li>
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
