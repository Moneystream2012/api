<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<!-- <div class="site-login">
	<div class="signUpForm">
		<h2><?php echo Html::encode($this->title) ?></h2>
		<?php
			$form = ActiveForm::begin(['id'=>'signin-form']);
		?>
		
		<?php echo $form->field($model, 'address')->textInput(['autofocus' => true, 'required'=>'required', 'placeholder'=>'Bitcoin address']) ?>
		<br />
		<br />

		<?php echo $form->field($model, 'password')->passwordInput(['required'=>'required', 'placeholder'=>'Password']) ?>
		<br />
		<br />

		<?php echo Html::submitButton('Sign in', ['class'=>'submitForm', 'name'=>'signin-button']) ?>
		<br />
		<br />

		<?php
			echo $form->field($model, 'rememberMe')->checkbox([
				'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
			]);
		?>

		<?php echo Html::a('Sign up', Url::to(['user/signup'])); ?>


		<?php ActiveForm::end(); ?>
	</div>
</div> -->


<!-- <!DOCTYPE html>
<html lang="ru">
  <head> -->
    <!-- Meta -->
<!--     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"> -->
    <!-- SEO Meta -->
<!--     <meta name="description" content="">
    <meta name="keywords" content=""> -->
    <!-- Favicon -->
<!--     <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png"> -->
    <!-- Title -->
    <title>Sign In</title>
    <!-- CSS -->
 <!--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/main.css"> -->
    <!-- IE8 --><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div class="cssload-whirlpool"></div>
    </div>
    <!-- Main -->
    <main id="full-height">
      <div class="form-wrap"><a href="<?php echo Yii::$app->getHomeUrl(); ?>"  class="logo"><img src="img/logo.svg" alt="logo">
          <div class="logo-descr">MinexBank</div></a>
		<?php $form = ActiveForm::begin(['id'=>'sign-in-form', 'options' => ['class' => 'main-form','data-toggle' => 'validator'] ]); ?>

        <!-- <form id="sign-in-form" data-toggle="validator" class="main-form"> -->
          <div class="form-group has-feedback">
        <?php echo $form->field($model, 'address')->label(false)->textInput(['autofocus' => true,  'required'=>'required', 'placeholder'=>'Minexcoin address']) ?>
            <!-- <input type="text" name="address" placeholder="Minexcoin adress" required class="form-control"> -->
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group has-feedback">
  		<?php echo $form->field($model, 'password')->label(false)->passwordInput(['required'=>'required', 'placeholder'=>'Password']) ?>
            <!-- <input type="password" name="password" placeholder="Password" required class="form-control"> -->
            <div class="help-block with-errors"></div>
          </div>
  		<?php echo Html::submitButton('Sign in', ['class'=>'button', 'name'=>'signin-button']) ?>
       <!--    <button type="submit" class="button">Sign In</button> -->
        <!-- </form> -->
		<?php ActiveForm::end(); ?>

        <div class="bottom-links"><a href="<?php echo Url::to(['user/signup'])?>" class="sign-up-link">Sign Up</a></div>
      </div>
    </main>
         <!-- <div class="bottom-links"><?php echo Html::a('Sign up', Url::to(['user/signup'])); ?> </div> -->
 
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
    <!-- JS -->
<!--     <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.matchHeight-min.js"></script>
    <script src="js/SmoothScroll.js"></script>
    <script src="js/jquery.knob.min.js"></script>
    <script src="js/jquery.magnific-popup.js"></script>
    <script src="js/validator.min.js"></script>
    <script src="js/common.js"></script> -->
  </body>
</html>