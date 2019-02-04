<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<!-- Preloader -->
<div id="preloader">
	<div class="cssload-whirlpool"></div>
</div>
<!-- Main -->
<main id="full-height">
	<div class="form-wrap"><a href="<?php echo Url::to(['user/signout']); ?>" class="logo"><img src="img/logo.svg" alt="logo">
		<div class="logo-descr">MinexBank</div></a>
		<?php echo Html::beginForm('', 'post', ['class' => 'main-form', 'data-toggle' => 'validator', 'id'=>'sign-in-form']); ?>

		<div class="form-group has-feedback">
			<?php echo Html::textInput('code', '', ['placeholder'=>'OTP code', 'class'=>'form-control', 'required'=>'required']); ?>
			<div class="help-block with-errors"></div>
		</div>

		<?php echo Html::submitButton('Confirm', ['class'=>'button', 'name'=>'confirm']) ?>

		<?php echo Html::endForm(); ?>

		<div class="bottom-links"><a href="/?r=user/discard-2fa" class="sign-up-link">Discard</a></div>
	</div>
</main>
 
<!-- Footer -->
<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="copyright">MinexSystems</div>
			</div>
		</div>
	</div>
</footer>

<script>
	window.onload = function() {
		<?php
			if (isset($response) && $response['status'] == 0)
				echo 'notifier.error("'.$response['response'].'");';
		?>
	}
</script>