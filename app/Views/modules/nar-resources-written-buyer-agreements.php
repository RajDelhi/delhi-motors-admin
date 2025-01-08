<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">NAR Resources: Written Buyer Agreements.</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<p>Beginning August 17, 2024, an MLS Participant “working with” a buyer will be required to enter into a written agreement with the buyer prior to touring a home, including both in-person and live virtual tours. This resource provides information about what provisions must be included in the written agreement pursuant to the NAR settlement as well as other provisions that, while not required by the settlement, MLS Participants may consider addressing with their clients.</p>

			<p>As you develop or refresh your agreement forms, keep in mind:</p>

			<ul>
				<li>Agreement forms should account for the choice and optionality consumers and real estate professionals have when negotiating the terms of their relationship permissible under state law.</li>
				<li>Agreement forms should give the real estate professional and consumer the ability to efficiently memorialize the relationship based on the transparent and clear conversation they have when deciding to work together.</li>
			</ul>

			<h2>Mandatory Provisions</h2>

			<p>Pursuant to paragraph 58(vi) of the NAR proposed settlement agreement, written buyer agreements must:</p>

			<ul>
				<li>Specify and conspicuously disclose the amount or rate of any compensation the MLS Participant will receive from any source, or how this amount will be determined;</li>
				<li>The amount of compensation must be objectively ascertainable and may not be open-ended (e.g., “buyer broker compensation shall be whatever amount the seller is offering to the buyer”);</li>
				<li>Include a statement that MLS Participants may not receive compensation from any source that exceeds the amount or rate agreed to with the buyer;</li>
				<li>Disclose in conspicuous language that broker commissions are not set by law and are fully negotiable; and</li>
				<li>Include any provisions required by law.</li>
			</ul>

			<h2>Other Considerations When Entering Into a Buyer Agreement:</h2>

			<p>While not required by NAR policy changes, there are several other considerations and contractual provisions for MLS Participants, associations, MLSs and other forms providers to consider when creating or updating written buyer agreements:</p>

			<ul>
				<li><strong>Format:</strong> Agreements should be organized, written in understandable terms for all parties, and use a clear, readable font size. MLS Participants are cautioned to avoid pre-filling key terms like length of the agreement and compensation, and to avoid changing provisions without legal advice.</li>
				<li><strong>Types of Representation:</strong> To maximize broker and buyer choice, consider all types of written buyer agreements permitted by state law, including short form, limited service, agency, non- agency, transactional, customer, among others.</li>
				<li><strong>Broker Services:</strong> Agreements should clearly articulate the services the MLS Participant will provide buyer.</li>
				<li><strong>Consumer Protection:</strong> Agreements should clearly disclose all contractual obligations of the buyer, duties of confidentiality owed to the buyer, the Equal Housing Opportunity statement. Consider including warnings regarding wire fraud as well as video and audio recording by sellers while touring a home for sale. MLS Participants may also notify consumers that they are providing real estate brokerage services and advise buyers to seek appropriate professional services from inspectors, lenders, attorneys, tax advisors and title agents, among others.</li>
				<li><strong>Term and Termination:</strong> MLS Participants and buyers can negotiate and agree to the duration of the agreement, including whether the term is automatically extended until closing upon purchase contract ratification. Buyer agreements may include provisions addressing termination with cause and without cause by both the buyer and the MLS Participant. Termination by the buyer may also address whether there is a carryover period, where compensation may be owed to the MLS Participant if the buyer terminates the written buyer agreement and subsequently executes a purchase agreement within an agreed upon time following termination of the buyer agreement.</li>
				<li><strong>Compensation and Fees:</strong> In addition to the mandatory provisions above, MLS Participants and buyers may agree to a retainer fee and address whether any retainer is included in total compensation, credited against compensation and/or refundable.</li>
				<li><strong>Conflicts of Interest:</strong> Consider addressing how MLS Participants resolve potential conflicts of interest during the term of the agreement, including disclosure and consent for representing other buyers submitting offers on the same property, dual agency, designated agency, or transaction brokerage.</li>
				<li><strong>Dispute Resolution:</strong> Written buyer agreements may include mandatory or optional alternative dispute resolution, such as mediation or arbitration. The parties may also agree to waive trial by jury and class actions in the event of litigation relating to the agreement.</li>
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
						<li class="active"><a href="<?= base_url() . 'nar-resources-written-buyer-agreements'; ?>">NAR Resources: Written Buyer Agreements</a></li>
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
