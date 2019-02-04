<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<script>var rates = [<?php echo $parkingTypes[0]['rate'].",".$parkingTypes[1]['rate'].",".$parkingTypes[2]['rate'] ?>];</script>
	<div id="preloader">
		<div class="cssload-whirlpool"></div>
	</div>
	
	<!-- Navbar -->
	<nav id="main-navbar">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="<?php echo Yii::$app->getHomeUrl(); ?>" class="logo"><img src="img/logo.svg" alt="logo">
						<div class="logo-descr">MinexBank</div>
					</a>
					
					<div class="main-menu-toggle-2">
						<div class="one"></div>
						<div class="two"></div>
						<div class="three"></div>
					</div>
					
					<div class="right-side">
						<ul>
							<li><a href="<?php echo Yii::$app->getHomeUrl(); ?>">Home</a></li>
							<li><a href="<?php echo Url::to(['user/terms'])?>" target="_blank">Conditions</a></li>
							<li><a href="https://minexcoin.com/html/download/wpeng.pdf" target="_blank">About</a></li>
							<li><a href="<?php if(!Yii::$app->user->isGuest) { echo Url::to(['user/dashboard/index']);}else{ echo Url::to(['user/signin']);} ?>" class="sign-in">Sign In</a></li>
							<li><a href="<?php if(!Yii::$app->user->isGuest) { echo Url::to(['user/dashboard/index']);}else{ echo Url::to(['user/signup']);} ?>" class="sign-up">Sign Up</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</nav>
	
	<!-- Header -->
	<header id="main-header">
		<div class="text-centered"><a href="/" class="big-logo"><img src="img/logo.svg" alt="logo">
			<div class="logo-descr">MinexBank</div></a>
			<h1>First Trustless Bank</h1><a href="<?php if(!Yii::$app->user->isGuest) { echo Url::to(['user/dashboard/index']);}else{ echo Url::to(['user/signin']);} ?>" class="button-bordered">Get start</a>
		</div>
	</header>
	
	<!-- What is Section -->
	<section id="what-is">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>What is MinexBank</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="what-is-descr">
						<p>MinexBank is an algorithm for controlling the volatility of Minexcoin price. Due to this algorithm, the price of Minexcoin is stabilized by reducing or increasing interest rates and interventions on the market. Thanks to this mechanism, everyone can get Minexcoin for free as an interest for their own balance assets in MNX, without transferring funds to anyone.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 wow fadeInUp">
					<div class="what-is-img"><img src="img/what-is-img.png" alt="alt"></div><a href="<?php if(!Yii::$app->user->isGuest) { echo Url::to(['user/dashboard/index']);}else{ echo Url::to(['user/signup']);} ?>" class="button">Try Now</a>
				</div>
			</div>
		</div>
	</section>


	<!-- Parkings Section -->
	<section id="parkings">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>MinexBank parkings</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="parkings-img"><img src="img/timer.png" alt="alt" class="gif-img"></div>
					<div data-animation="fadeInLeft" class="parkings-descr has-animation">
						<p>Parking is a confirmation of the intention of Minexcoin holder not to bring the coins from the wallet to the market within the specified period of time. This intention is confirmed by the Minexcoin owner by creating an application in the MinexBank algorithm.</p>
					</div>
					<a href="https://minexcoin.com/html/download/wpeng.pdf" target="_blank" class="button-bordered">Learn more</a>
				</div>
        </div>
      </div>
    </section>
	<!-- Work Section -->
    <section id="work">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>How MinexBank works</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="work-carousel owl-carousel owl-theme">
						<div class="item item-1">
							<h3>How does MinexBank control Minexcoin volatility?</h3>
							<p>To stabilize the price of Minexcoin, the MinexBank algorithm increases or reduces interest rates for parking operations depending on the supply and demand on the market.</p>
							<div class="item-img"><img src="img/work-slide-1.png" alt="alt"></div>
						</div>
						<div class="item item-2">
							<h3>Where is the money for paying interest coming from?</h3>
							<p>MinexBank makes payments on parking operations at the expense of its own reserves.Reserves are formed due to fixed percentage of deductions made by miners in favor of MinexBank for each successfully solved block of Minexcoin.</p>
							<h4>Miners</h4>
							<div class="item-img"><img src="img/work-slide-2.png" alt="alt"></div>
							<h4>MinexBank Reserve</h4>
						</div>
						<div class="item item-3">
							<h3>Objective of MinexBank establishing</h3>
							<p>The objective of MinexBank is to regulate volatility of Minexcoin on the market in order to create the prerequisites for the development of Minexcoin as a global mean of payment and reserve currency on the blockchain technology.</p>
							<div class="item-img"><img src="img/work-slide-3.png" alt="alt"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12"><a href="https://minexcoin.com/html/download/wpeng.pdf" target="_blank" class="button-bordered">Learn more</a></div>
			</div>
		</div>
	</section>
	
	<!-- Benefits Section -->
	<section id="benefits">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>Benefits of MinexBank</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="benefits-descr" >
						<p>MinexBank has a number of advantages that makes its solutions innovative for the fintech industry of the XXI century.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<div data-animation="zoomIn" class="benefits-item has-animation">
						<div class="benefits-title">
							<div class="benefits-icon"><img src="img/benefits-icon-1.svg" alt="alt"></div>
							<h4>Trustless party</h4>
						</div>
						<div class="benefits-boby" >
							<p>Unlike traditional banks, in MinexBank you do not need to transfer your funds to anyone in order to receive interest on open deposits. All you need is to “freeze” funds on your own wallet without fear of losing funds as the result of unauthorized access to the centralized traditional bank.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div data-animation="zoomIn" class="benefits-item has-animation">
						<div class="benefits-title">
							<div class="benefits-icon"><img src="img/benefits-icon-2.svg" alt="alt"></div>
							<h4>Anonymity</h4>
						</div>
						<div class="benefits-boby" >
							<p>MinexBank doesn’t collect and store your personal data. In order to use the bank functions, you just need to specify you Minexcoin wallet address.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div data-animation="zoomIn" class="benefits-item has-animation">
						<div class="benefits-title">
							<div class="benefits-icon"><img src="img/benefits-icon-3.svg" alt="alt"></div>
							<h4>Transparency</h4>
						</div>
						<div class="benefits-boby" >
							<p>Thanks to the blockchain technology, you can monitor all transactions of the bank in real time operation.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div data-animation="zoomIn" class="benefits-item has-animation">
						<div class="benefits-title">
							<div class="benefits-icon"><img src="img/benefits-icon-4.svg" alt="alt"></div>
							<h4>Secure access</h4>
						</div>
						<div class="benefits-boby" >
							<p>Access to MinexBank is protected by the two-factor authorization and fingerprint verification system (for mobile devices that support such function).</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div data-animation="zoomIn" class="benefits-item has-animation">
						<div class="benefits-title">
							<div class="benefits-icon"><img src="img/benefits-icon-5.svg" alt="alt"></div>
							<h4>Mobile</h4>
						</div>
						<div class="benefits-boby" >
							<p>Your MinexBank is always with you in the mobile application for Android. Its intuitive interface will allow you to master new application in the shortest time possible.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div data-animation="zoomIn" class="benefits-item has-animation">
						<div class="benefits-title">
							<div class="benefits-icon"><img src="img/benefits-icon-6.svg" alt="alt"></div>
							<h4>Support 24/7</h4>
						</div>
						<div class="benefits-boby" >
							<p>Our support service will answer all your questions in real time. All MinexBank users can reckon on the support service 24 hours a day, 7 days a week.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!-- Current Section -->
	<section id="current">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>Current rates</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="current-descr">
						<p>Below you can find the existing interest parkings rates. During the day, the rates may change both upward and downward, depending on the demand and supply of Minexcoin (MNX) on the market.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<?php
					if (isset($parkingTypes) && count($parkingTypes) > 0) {
						foreach ($parkingTypes as $type) {
							?>
								<div class="col-md-4 col-sm-4">
									<div class="current-rate-item">
										<div class="circle-block">
											<input type="text" value="0" rel="<?php echo $type->rate; ?>" data-min="0" data-max="100" data-linecap="round" class="big-circle">
											<div class="counter"><?php echo $type->rate; ?>% <span><?php echo $type->title; ?></span></div>
										</div>
										<button id="per-day-button" type="button" class="button-bordered"><a href="<?php if(!Yii::$app->user->isGuest) { echo Url::to(['user/dashboard/index']);}else{ echo Url::to(['user/signin']);} ?>" style="    color: #24E1BA;">Park Now</a></button>
									</div>
								</div>
							<?php	
						}
					}
				?>
			</div>
		</div>
	</section>
	
	<!-- Calculator Section -->
	<section id="calculator">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>Parking Calculator</h2>
					</div>
				</div>
			</div>
				<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="current-descr" >
						<p>This option allows you to calculate the precise income that will be received after the expiration of the chosen parking period.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab1">Daily parking</a></li>
						<li><a data-toggle="tab" href="#tab2">Weekly parking</a></li>
						<li><a data-toggle="tab" href="#tab3">Yearly parking</a></li>
					</ul>
					<div class="tab-content">
						<div id="tab1" class="tab-pane fade in active" style="min-height: 200px;">
							<p>By choosing this function, you confirm the intention not to reduce the amount of funds in your wallet less than the amount specified during the parking placing within 24 hours.</p>
							<div class="form-group">
								<label>Parking amount</label>
								<div class="input-group">
									<input id="input-pa-1" type="text" placeholder="0.00000000" class="form-control">
									<div class="input-group-addon">MNX</div>
								</div>
							</div>
						</div>
						<div id="tab2" class="tab-pane fade" style="min-height: 200px;">
							<p>By choosing this function, you confirm the intention not to reduce the amount of funds in your wallet less than the amount specified during the parking placing within 7 days.</p>
							<div class="form-group">
								<label>Parking amount</label>
								<div class="input-group">
									<input id="input-pa-2" type="text" placeholder="0.00000000" class="form-control">
									<div class="input-group-addon">MNX</div>
								</div>
							</div>
						</div>
						<div id="tab3" class="tab-pane fade" style="min-height: 200px;">
							<p>By choosing this function, you confirm the intention not to reduce the amount of funds in your wallet less than the amount specified during the parking placing within 365 days.</p>
							<div class="form-group">
								<label>Parking amount</label>
								<div class="input-group">
									<input id="input-pa-3" type="text" placeholder="0.00000000" class="form-control">
									<div class="input-group-addon">MNX</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="progress-wrap">
						<div class="progress-item">
							<div class="progress-descr">Parking rate</div>
							<div class="progress">
								<div id="parking-rate" role="progressbar" aria-valuenow=" <?php echo $parkingTypes[0]['rate']; ?>" aria-valuemin="0" aria-valuemax="100" style="width:10%" class="progress-bar"><?php echo $parkingTypes[0]['rate']; ?>%</div>
							</div>
						</div>
						<div class="progress-item">
							<div class="progress-descr">Parking duration</div>
							<div class="progress">
								<div id="parking-duration" role="progressbar" aria-valuenow="<?php echo $parkingTypes[1]['rate']; ?>" aria-valuemin="0" aria-valuemax="100" style="width:15%" class="progress-bar">24 hours</div>
							</div>
						</div>
						<div class="progress-item">
							<div class="progress-descr">Your parking amount</div>
							<div class="progress">
								<div id="your-parking-amount" role="progressbar" aria-valuenow="<?php echo $parkingTypes[2]['rate']; ?>" aria-valuemin="0" aria-valuemax="100" style="width:100%" class="progress-bar">0.00000000 MNX</div>
							</div>
						</div>
						<div class="progress-item">
							<div class="progress-descr">Expected profit</div>
							<div class="profit-value">0.00000000 MNX</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!-- Pauouts Section -->
	<section id="pauouts">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>Latest payouts</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<table class="table pauouts-table">
						<thead>
							<tr>
								<th>Transactions</th>
								<th>Time</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
					
						<?php
							if (isset($payouts) && count($payouts) > 0) {
								foreach ($payouts as $payout) {
									?>
										<tr>
											<td><?php echo Html::a($payout->transaction_id, 'http://minexexplorer.com/?r=explorer/tx&hash='.$payout->transaction_id, ['target'=>'_blank' ,'class' => 'address-link','style' =>'color:#26C8A9;']); ?></td>
											<td nowrap><?php echo date("d.m.y H:i", $payout->created); ?></td>
											<td nowrap>
												<div class="amount-value"><?php echo number_format($payout->amount, 8) ?> MNX</div>
											</td>
										</tr>
								<?php
							}
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<!-- Steps Section -->
	<section id="steps">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>How to park coins</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="step-descr">
						<p>In order to use parking option, make the following steps.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="steps-number-wrap">
						<div class="steps-number steps-number-1 active">1</div>
						<div class="steps-number steps-number-2">2</div>
						<div class="steps-number steps-number-3">3</div>
						<div class="steps-number steps-number-4">4</div>
						<div class="steps-number steps-number-5">5</div>
						<!-- <div class="steps-number steps-number-6">6</div> -->
					</div>
					<div class="steps-descr-wrap">
						<div class="steps-descr steps-descr-1 active" style="min-height: 150px;" >
							<h5 style="text-align: center;">Download and install XCoin Wallet </h5>
							<br>
							<p style="text-align: center;"><a href="https://drive.google.com/open?id=0B1dlB9NaqPEEV2Jmd1hLdE5CZWM" target="_blank">(Download link)</a></p>
						</div>
						<div class="steps-descr steps-descr-2" style="min-height: 150px;" >
							<!-- <h5>Transfer the coins to your Minexcoin address</h5> -->
<p style="text-align: center;">Create receiving address marked “MyMinexBank” in the downloaded Xcoin wallet (File -> Receiving addresses -> + New)
							</p>
						</div>
						<div class="steps-descr steps-descr-3" style="min-height: 150px;" >
					<!-- 		<h5>Complete registration in MinexBank</h5> -->
							<p style="text-align: center;">To do it: The first step: specify your Minexcoin Address (File-> Receiving addresses) with the label “MyMinexBank” and the password that you will use for authorization.</p>
						</div>
						<div class="steps-descr steps-descr-4" style="min-height: 150px;" >
							<!-- <h5>Confirm your account</h5> -->
							<p>The second step: MinexBank should receive confirmation that the address is yours. To do this, select “File-> Sign message” in the XCoin Wallet.</p>
 
<p>
	
 In the first field, enter the address that you have used for registration during the 1st step.
In the second field, write the word “minexbank” without quotes and spaces and press “sign message”.
Then, copy your signature and paste it into the corresponding field of the registration form in MinexBank and press “confirm”.}
</p>
						</div>
						<div class="steps-descr steps-descr-5" style="min-height: 150px;" >
						<br>
						<br>
							<h5 style="text-align: center;">Congratulations, you have registered in MinexBank.</h5>
<!-- 							<p>Choose the parking type (daily, monthly or annual) and specify the amount that you want to park. After confirmation of the application by the system, parking will be created and after the end of the parking period you will be charged interest to the address specified during registration.</p> -->
						</div>
<!-- 						<div class="steps-descr steps-descr-6" style="min-height: 150px;" >
	<h5>Create wallet 6</h5>
	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has Lorem Ipsum is simply </p>
	<p>dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the</p>
</div> -->
						<button id="prev"></button>
						<button id="next"></button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12"><a href="<?php if(!Yii::$app->user->isGuest) { echo Url::to(['user/dashboard/index']);}else{ echo Url::to(['user/signin']);} ?>" class="button-bordered">Park Now</a></div>
			</div>
		</div>
	</section>

	<!-- Mobile Section -->
	<section id="mobile">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>MinexBank for mobile</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="mobile-carousel owl-carousel owl-theme">
						<div class="item">
							<h3>User friendly design</h3>
							<p>User comes first. Intuitive design will help you to master functionality of the application in a few minutes.</p>
							<div class="item-img"><img src="img/mobile-1.png" alt="alt"></div>
						</div>
						<div class="item">
							<h3>Notifications</h3>
							<p>Be the first to learn about changing interest rates for parking operations.</p>
							<div class="item-img"><img src="img/mobile-2.png" alt="alt"></div>
						</div>
						<div class="item">
							<h3>Fingerprint access</h3>
							<p>With the help of fingerprint verification, you can increase the level of protection from unauthorized access to the control panel of the MinexBank services.</p>
							<div class="item-img"><img src="img/mobile-3.png" alt="alt"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<style></style>
				<div class="col-md-12"><a href="#google-play-link-popup" class="call-popup" style="border:none;max-width: 150px;margin: 0 auto; display: block;"><img src="img/android.png" alt="Download" style="max-width: 200px; max-height: 50px;"></a></div>
			</div>
		</div>
	</section>

	<!-- Notices Section -->
	<section id="notices">
		<div class="container">
			<?php /*
			<div class="row">
				<div class="col-md-12">
					<div data-animation="fadeInUp" class="section-title has-animation">
						<h2>Notices</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="notices-wrap">
						<div class="notices-item">
							<div class="notices-title">
								<h4>Lorem Ipsum is simply dummy text of the printing and typesetting</h4>
							</div>
							<div class="notices-descr">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown </p>
							</div>
						</div>
						<div class="notices-item">
							<div class="notices-title">
								<h4>Lorem Ipsum is simply dummy</h4>
							</div>
							<div class="notices-descr">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown rfwefdfd f df sadfs fsdf sd sdfsd fsd sdfs fs fs fs sf sfd </p>
							</div>
						</div>
						<div class="notices-item">
							<div class="notices-title">
								<h4>Lorem Ipsum is simply dummy text of the printing and typesetting</h4>
							</div>
							<div class="notices-descr">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown</p>
							</div>
						</div>
					</div>
				</div>
			</div> //*/ ?>
			<div class="row">
				<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
					<div class="form-title">
						<h3>Subscribe on updates</h3>
					</div>
					<form id="subscribe-form" class="main-form" method="post"  onsubmit="subscribeEmail(); return false;">
						<div class="form-group">
							<input type="email"  id="email-subscribe" placeholder="Your email" required class="form-control">
						</div>
						<button type="submit" class="button">Subscribe</button>
					</form>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer id="main-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="social-list">
						<li><a href="https://minexcoin.herokuapp.com/"><img src="img/social-1.svg" alt="sluck"></a></li>
						<li><a href="https://twitter.com/MinexBank"><img src="img/social-2.svg" alt="twitter"></a></li>
						<li><a href="#"><img src="img/social-3.svg" alt="github"></a></li>
						<li><a href="https://www.facebook.com/minexbank/"><img src="img/social-4.svg" alt="facebook"></a></li>
						<li><a href="https://www.youtube.com/channel/UC0W1HCOVEOyCse6yQbRDfxg"><img src="img/social-5.svg" alt="youtube"></a></li>
						<li><a href="https://t.me/minexbank"><img src="img/social-6.svg" alt="telegram"></a></li>
					</ul>
					<div class="copyright">MinexSystems</div>
				</div>
			</div>
		</div>
	</footer>

<div class="hidden">
	<div id="google-play-link-popup" class="popup">
		<div class="top-panel">
			<div class="popup-title">Google app</div>
			<button type="button" class="close-popup"><i class="material-icons">close</i></button>
		</div>
		<div class="body-panel">
			<p>Will be available soon</p>
		</div>
		<div class="botton-panel">
			<button type="button" id="close-activation-info-button" class="button-bordered close-popup">Close</button>
		</div>
	</div>
</div>