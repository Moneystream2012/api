<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $response array */

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
				echo '<div class="text-danger text-center">'.$response['error'].'</div>';	
			}
		?>

		<?php echo Html::beginForm('', 'post', ['id'=>'confirm-form', 'class'=>'main-form']); ?>
			<div class="form-group">
				<label class="control-label">1. Sign this word in MinexWallet</label>
				<div class="input-group">
					<input id="wordInput" type="text" name="word" placeholder="" value="minexbank" required readonly class="form-control"><span class="input-group-btn">
					<button id="copy-button" type="button" class="btn btn-default"><i class="material-icons">content_copy</i></button></span>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label">2. Put your signature on the field below</label>
				<input type="text" name="signature" placeholder="" required class="form-control">
			</div>

			<?php echo Html::submitButton('Confirm', ['class'=>'button', 'name'=>'verify']); ?>
		<?php echo Html::endForm(); ?>
	</div>
</main>