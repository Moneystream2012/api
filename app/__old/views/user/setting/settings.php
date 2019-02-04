<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>


	<!-- Header -->
	<?php echo $this->render('../../common/_header.php'); ?>
	<!-- Main -->
	<main id="main">
		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<!-- Sidebar -->
					<?php echo $this->render('../../common/_navbar', ['active'=>'setting']); ?>
				</div>
				<div class="col-md-8">
					<!-- Settings Section -->
					<section class="settings-section">
						<h1 class="page-title">Settings</h1>
						<div class="panel panel-default">
							<div class="panel-heading">
								<a id="copy-address-btn"  class="spoiler-trigger collapsed">
									<div class="clearfix">
										<div class="title">My address: </div> <span id="user-address-span"><?php echo Yii::$app->user->identity->address;?></span>
										<div class="status">Copy</div>
									</div>
								</a>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<a href="#settings-1" data-toggle="collapse" class="spoiler-trigger collapsed">
									<div class="clearfix">
										<div class="title">Change password</div>
										<div class="status">Change</div>
										<i class="material-icons">keyboard_arrow_down</i>
									</div>
								</a>
							</div>
							<div id="settings-1" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="settings-inner password-settings">
										<form id="change-password-form" data-toggle="validator" class="main-form">
											<div class="form-group has-feedback">
												<label>Old password</label>
												<input type="password" name="old_password" id="current-password" placeholder="Old password" required class="form-control">
												<div class="help-block with-errors"></div>
											</div>
											<div class="form-group has-feedback">
												<label>New password</label>
												<input type="password" name="new_password" id="new-password" placeholder="New password" required class="form-control">
												<div class="help-block with-errors"></div>
											</div>
											<div class="form-group has-feedback">
												<label>Repeat new password</label>
												<input type="password" name="confirm_password" placeholder="Repeat password" id="confirm-new-password" data-match="#inputPassword" required class="form-control">
												<div class="help-block with-errors"></div>
											</div>
										</form>
									</div>
									<div class="buttons-group">
										<a class="button-bordered" href="#" onclick="changePassword()">Change</a>
										<!-- <?php echo Html::a('Change', Url::to(['user/setting/change-password']), ['class'=>'button-bordered']); ?> -->
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<a href="#settings-2" data-toggle="collapse" class="spoiler-trigger collapsed">
									<div class="clearfix">
										<div class="title">Two-factor authentication</div>
										<div class="status">Enable</div>
										<i class="material-icons">keyboard_arrow_down</i>
									</div>
								</a>
							</div>
							<div id="settings-2" class="panel-collapse collapse">
								<div class="panel-body">
									<?php if ($user->twofa_enabled == 0) { ?>
										<div class="settings-inner" id="twofa-inner-block">
											<p>1. Install Google Authenticator</p>
											<ul class="links">
												<li><a href="#">iPhone iOS</a></li>
												<li><a href="#">Android</a></li>
											</ul>
											<p>2. Scan the QR-code or enter the code using Google Authenticator</p>
											<div class="p-code">
												<div class="qr-code-img"><img style="border-radius: 7px;" src="<?php if ($dataFor2FA['status'] == 1) echo urldecode($dataFor2FA['data']['qrCodeUrl']); ?>" alt="alt" id="qr-code-image" /></div>
												<div class="qr-code" id="secret-code"><?php if ($dataFor2FA['status'] == 1) echo $dataFor2FA['data']['secret']; ?></div>
											</div>
											<?php echo Html::a('Refresh', '#', ['class'=>'cancel-button', 'id'=>'setting-refresh-2fa-button']); ?>
											<br>
											<p>3. Enter the code from Google Authenticator</p>
											<form class="main-form">
												<input id="twofa-otp-code" type="text" name="twofa-code" placeholder="OTP code" required class="form-control" />
											</form>
										</div>
									<?php } else { ?>
										<div class="settings-inner" id="twofa-inner-block">
											<p>Enter the code from Google Authenticator to disable 2FA</p>
											<form class="main-form">
												<input id="twofa-otp-code" type="text" name="twofa-code" placeholder="OTP code" required class="form-control" />
											</form>
										</div>
									<?php } ?>
									<div class="buttons-group">
										<?php echo Html::a('Enable', '#', ['class'=>'button-bordered', 'id'=>'switch-2fa-button']); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading">
								<a href="#settings-3" data-toggle="collapse" class="spoiler-trigger collapsed">
									<div class="clearfix">
										<div class="title">Email notification</div>
										<div class="status">Enable</div>
										<i class="material-icons">keyboard_arrow_down</i>
									</div>
								</a>
							</div>
							<div id="settings-3" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="settings-inner password-settings">
										<div class="main-form">
											<div class="has-feedback">
												<label>Email notification</label>
												<input type="email" name="email_notification" id="notification-email" placeholder="Email" required class="form-control" onchange="notificationEmail()" value="<?php echo Yii::$app->user->identity->email; ?>" >
												<div class="checkbox ">
												<!-- enableNotificationEmail() -->
 												<label><input type="checkbox" id="enable-notification-email" onchange="enableNotificationEmail()" <?php if(Yii::$app->user->identity->email_notification == 1){
 												  echo 'checked '; } ?> value="" >Enable</label>
												</div>
												<div class="help-block with-errors"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</main>

	<!-- Alerts -->
	<!-- <div class="info-alerts">
		<div class="alert alert-dismissible alert-success">
			<button type="button" data-dismiss="alert" class="close">×</button><span>Parking has been canceled</span>
		</div>
		<div class="alert alert-dismissible alert-success">
			<button type="button" data-dismiss="alert" class="close">×</button><span>Parking has been canceled</span>
		</div>
		<div class="alert alert-dismissible alert-danger">
			<button type="button" data-dismiss="alert" class="close">×</button><span>You have not enought Minexcoins on your wallet</span>
		</div>
	</div> -->