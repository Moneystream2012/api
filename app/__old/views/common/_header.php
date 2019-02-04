<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<!-- Preloader -->
<div id="preloader">
	<div class="cssload-whirlpool"></div>
</div>

<style>

</style>
<script>

/*	 $(document).ready(function(){
	 	$( "#refreshBalance" ).click(function() {
   			 //alert($( this ).css( "transform" ));
   			 if (  $( this ).css( "transform" ) == 'none' ){
   			     $(this).css("transform","rotate(360deg)");
   			 } else {
   			     $(this).css("transform","" );
   			 }
});
	});*/
</script>
<!-- Mobile Navbar -->
<nav id="sidenav"></nav>

<!-- Header -->
<header id="header">
	<!-- Navbar -->
	<nav id="navbar">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="main-menu-toggle">
              		<div class="one"></div>
              		<div class="two"></div>
              		<div class="three"></div>
              		</div><a href="<?php echo Yii::$app->getHomeUrl(); ?>" class="logo"><img src="img/logo.svg" alt="logo">
					<div class="logo-descr">MinexBank</div></a>
					<div class="right-side">
						<?php
							if (!Yii::$app->user->isGuest && Yii::$app->user->identity->status == 1) {
								$data = $this->context->getService('Parking')->getInfo(Yii::$app->user->identity);

								?>	
								<div class="info-block" style="margin-right: 15px;padding-top: 5px;"><i class="material-icons" id="refreshBalance">refresh</i></div>
									<div class="info-block">
										<div class="info-block-title">Available for parking:</div>
										<div class="info-block-counter" id="available"><?php echo number_format($data['available'] ? : 0, 8); ?> MNX</div>
									</div>
									<div class="info-block">
										<div class="info-block-title">Parked:</div>
										<div class="info-block-counter" id="parked"><?php echo number_format($data['parked'] ? : 0, 8); ?> MNX</div>
									</div>
									<div class="info-block">
										<div class="info-block-title">Balance:</div>
										<div class="info-block-counter" id="balance"><?php echo number_format(Yii::$app->user->identity->balance ? : 0, 8); ?> MNX</div>
									</div>
								<?php
							} else {
								?>
									<div class="status">Status: <span class="red-color"><?php echo (!Yii::$app->user->isGuest && Yii::$app->user->identity->status > 0) ? 'Confirmed' : Html::a('Unconfirmed', '#init-activation-popup', ['class'=>'call-popup', 'style' => 'color:#DF2F2F' ]); ?></span></div>
								<?php
							}
						?>
						<a href="<?php echo Url::to(['user/signout']); ?>" class="log-out-link"><i class="material-icons">exit_to_app</i><span>Log out</span></a>
					</div>
				</div>
			</div>
		</div>
	</nav>
</header>

<!-- Init activation popup -->
<?php echo $this->render('_init_activation_popup'); ?>