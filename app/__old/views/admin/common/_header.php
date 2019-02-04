<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
if(Yii::$app->user->identity->role < 1) return Yii::$app->getResponse()->redirect(Url::to(['user/dashboard/index']));
?>

<!-- Preloader -->
<div id="preloader">
	<div class="cssload-whirlpool"></div>
</div>
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
          			</div><a href="<?php echo Url::to(['user/dashboard/index']); ?>" class="logo"><img src="img/logo.svg" alt="logo">
					<div class="logo-descr">MinexBank</div></a>
					<div class="right-side">
						<div class="login">Admin</div>
						<a href="<?php echo Url::to(['user/signout']); ?>" class="log-out-link"><i class="material-icons">exit_to_app</i><span>Log out</span></a>
					</div>
				</div>
			</div>
		</div>
	</nav>
</header>