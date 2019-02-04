<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<!-- Preloader -->
<div id="preloader">
	<div class="cssload-whirlpool"></div>
</div>

<!-- Main -->
<main id="full-height">
	<div class="form-wrap">
		<a href="<?php echo Yii::$app->getHomeUrl(); ?>" class="logo"><img src="img/logo.svg" alt="logo">
			<div class="logo-descr">MinexBank</div>
		</a>
		
		<?php 
			if (isset($response['error'])) {
				echo '<div class = "text-danger text-center">'.$response['error'].'</div>';	
			}
		?>
		<br>

		<?php echo Html::beginForm('', 'post', ['id'=>'sign-up-form','class' => 'main-form','data-toggle' => 'validator']); ?>
			<div class="form-group has-feedback">
				<input type="text" name="address" placeholder="Minexcoin address" required class="form-control">
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group has-feedback">
				<input id="inputPassword" type="password" name="password" placeholder="Password" required class="form-control">
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="repassword" placeholder="Repeat password" data-match="#inputPassword" required class="form-control">
				<div class="help-block with-errors"></div>
			</div>
			<?php echo Html::submitButton('Sign Up', ['class'=>'button', 'name'=>'signup-button', 'value'=>'Sign Up']); ?>
		<?php echo Html::endForm(); ?>

		<div class="bottom-links"><a href="<?php echo Url::to(['user/signin'])?>" class="sign-up-link">Sign In</a></div>
		<div class="text-center" style="padding-top: 100px; font-family:'RobotoMedium', sans-serif; font-size: 12px; color: #535555;">
			<p style="margin-bottom: 0;">Signin up signifies that you have</p>
			<p >read and agree to the <a href="<?php echo Url::to(['user/terms'])?>" target="_blank" style="color: #24e1ba;">Terms and conditions</a></p>
		</div>
	</div>
</main>