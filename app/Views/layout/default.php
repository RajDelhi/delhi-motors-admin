<!DOCTYPE html>
<html>

<head>
	<title><?= esc($page_title) ?></title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="description" content="Website description" />
	<meta name="robots" content="noindex, nofollow" /><!-- change into index, follow -->

	<!-- Include Normalize CSS File  -->
	<link rel='stylesheet' href='<?= base_url() . 'styles/vendor/normalize.min.css' ?>' type='text/css' media='all' />

	<!-- Include the necessary external library CSS files and remove any that are not required.  -->
	<link rel='stylesheet' href='<?= base_url('styles/vendor/all.min.css?') ?>' />
	<link rel="stylesheet" href="<?= base_url("styles/vendor/slick.min.css?") ?>" />
	<link rel="stylesheet" href="<?= base_url("styles/vendor/lity.min.css?") ?>" />
	<link rel="stylesheet" href="<?= base_url("styles/vendor/normalize.min.css?") ?>" />
	<link rel="stylesheet" href="<?= base_url("styles/vendor/simplebar.min.css?") ?>" />

	<!-- This is essential custom CSS written to match the HTML output. -->
	<link rel="stylesheet" href="<?= base_url("styles/webfonts.css?") ?>" />
	<link rel="stylesheet" href="<?= base_url("styles/critical.css?") ?>" />
	<link rel='stylesheet' href="<?= base_url("styles/homepage-style.css?") ?>" />
	<link rel='stylesheet' href="<?= base_url("styles/subpage-style.css?") ?>" />
	<link rel="stylesheet" href="<?= base_url("styles/style.css?") ?>" />

	<script type="text/javascript" src="https://www.bugherd.com/sidebarv2.js?apikey=dispeosdr4jt0ezjcakawa" async="true"></script>
</head>

<body class="home" style="display: none;">
	<!-- Skip to content" link for keyboard accessibility -->
	<a href="#main" class="scroll-to" data-scroll-to-id="main" style="display:none;" id="skiptocontent">
		SKIP TO CONTENT<i class="fas fa-caret-down small-margin-left"></i>
	</a>

	<!-- Mobile navigation menu -->
	<nav id="mobile-navigation" class="menu-main-navigation-container">
		<ul id="menu-main-navigation" class="mobile-navigation-menu">
<!--			<li><a href="<?= base_url() . 'advertise'; ?>">Advertise</a></li>-->
			<?php if (!session()->get('emp_id')) { ?>
<!--				<li><a href="<?= base_url() . 'login' ?>">Login/List</a></li>-->
			<?php } else { ?>
				<?php $emp_name = session()->get('emp_first_name') ?>
				<li><a href="<?= base_url() . 'logout' ?>">Logout <?= "($emp_name)"; ?></a></li>
				<li><a href="<?= base_url() . 'agent-profile' ?>">Profile</a></li>
				<li><a href="<?= base_url() . 'dashboard' ?>">Dashboard</a></li>
			<?php } ?>
<!--			<li><a href="<?= base_url() . 'about-us'; ?>">About</a></li>-->
		</ul>
		<ul id="mobile-nav-menu" class="mobile-nav-menu hide">
			<li><a href="#">Contact</a></li>
		</ul>
	</nav>

	<!-- Mobile navigation top (moved in JavaScript) -->
	<div class="mobile-navigation-top-inner" id="mobile-navigation-top-inner" style="display:none;">
		<button class="mobile-navigation-close no-background mobile-menu-toggle">
			<span>Close</span><i class="fas fa-x"></i>
		</button>
	</div>

	<!--  start container -->
	<div id="container">
		<!-- Start Preloader Homepage only -->
		<div class="preloader-outer" id="preloader">
			<div class="preloader-inner" id="preloader-inner">
				<div class="preloader-part preloader-part-left">
					<h2 class="no-margin">This Is A Preloader</h2>
				</div>

				<div class="preloader-part preloader-part-right">
					<p>It happens just once per session</p>

					<p>You can make any custom animation happen here</p>
				</div>
			</div>
		</div>
		<!-- End Preloader -->

		<!-- Start Header Mobile -->
		<header class="header header-mobile" id="header-mobile">
			<div class="header-mobile-inner">
				<a class="header-logo" href="#">
                                    Delhi Motors
					<!--<img class="responsive-img" src="<?= base_url() . 'images/logo.svg' ?>" alt="Commission Verification" width="366" height="87" />-->
				</a>

				<aside class="header-mobile-buttons">
					<ul class="no-margin flex-container">
						<li>
							<a class="header-email" href="mailto:help@flatfee.com">
								<strong>Questions?</strong> <i class="fas fa-envelope"></i>
							</a>
						</li>
					</ul>

					<button class="mobile-menu-toggle">
						<i class="fas fa-bars"></i><span class="visually-hidden">Open Menu</span>
					</button>
				</aside>
			</div>
		</header>
		<!-- End Header Mobile -->

		<!-- Start Header Desktop -->
		<header class="header header-desktop" id="header-desktop">
			<div class="row">
				<div class="header-inner">
					<a href="<?= base_url(); ?>" class="">
                                           
						<img class="responsive-img"  src="<?= base_url() . 'images/delhi_motors_logo.png' ?>" alt="Delhi Motorss" />
					</a>

					<aside class="header-right">
						<div class="header-right-bottom">
							<nav id="desktop-navigation" class="menu-main-navigation-container">
								<ul id="menu-main-navigation-1" class="main-navigation-menu">
									<!--<li><a href="<?= base_url() . 'advertise'; ?>">Advertise</a></li>-->
									<?php if (!session()->get('emp_id')) { ?>
										<li><a href="<?= base_url() . 'login' ?>">Login</a></li>
									<?php } else { ?>
										<?php $emp_name = session()->get('emp_first_name') ?>
                                                                                <li><a href="<?= base_url() . 'dashboard' ?>">Dashboard</a></li>
                                                                                <li><a href="<?= base_url() . 'dashboard' ?>">Estimate</a></li>
                                                                                <li><a href="<?= base_url() . 'dashboard' ?>">Billing</a></li>
                                                                                <li><a href="<?= base_url() . 'item-list' ?>">Inventory</a></li>
                                                                                <li><a href="<?= base_url() . 'agent-profile' ?>">Edit Profile</a></li>
										<li><a href="<?= base_url() . 'logout' ?>">Logout <?= "($emp_name)"; ?></a></li>
										
										
									<?php } ?>
<!--									<li><a href="<?= base_url() . 'about-us'; ?>">About</a></li>-->
								</ul>
							</nav>

<!--							<a class="header-email" href="mailto:help@flatfee.com">
								<strong>Questions?</strong> <i class="fas fa-envelope"></i>
							</a>-->
						</div>
					</aside>
				</div>
			</div>
		</header>
		<!-- End Header Desktop -->

		<?= $this->renderSection('content') ?>

		<!--  start footer -->
		<footer class="footer">
			<div class="row">
				<div class="column no-float">
					<div class="footer-inner">
						<div class="footer-logo">
							<img src="<?= base_url('images/delhi_motors_logo') ?> " alt="Delhi Motors">
						</div>

						<div class="footer-info">
							<ul class="footer-nav flex-container no-margin">
                                                            
								<li>© Copyright <?php echo date('Y'); ?> <a href="https://delhimotorsindia.com/">Delhi Motors. All Right Reserved.</a></li>
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- end footer -->
	</div>
	<!--  end wrapper -->

	<!-- Include the necessary external library js files and remove any that are not required.  -->
	<script src="<?= base_url('scripts/vendor/jquery-3.7.1.min.js') ?> "></script>
	<script src="<?= base_url('scripts/vendor/anime.min.js') ?> "></script>
	<script src="<?= base_url('scripts/vendor/lity.min.js') ?> "></script>
	<script src="<?= base_url('scripts/vendor/lozad.min.js') ?> "></script>
	<script src="<?= base_url('scripts/vendor/modernizr.min.js') ?> "></script>
	<script src="<?= base_url('scripts/vendor/slick.min.js') ?> "></script>
	<script src="<?= base_url('scripts/vendor/simplebar.min.js') ?> " defer></script>
	<script src="<?= base_url('scripts/vendor/sticky.min.js') ?> " defer></script>

	<!-- This is essential custom JS written to match the HTML output. -->
	<script src="<?= base_url('scripts/common.js') ?> "></script>
	<script src="<?= base_url('scripts/homepage.js') ?> "></script>
	<script src="<?= base_url('scripts/main.js') ?> "></script>
</body>

</html>
