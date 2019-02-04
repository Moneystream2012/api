<?php

/**
 * 2FA setting page.
 */

use yii\helpers\Html;

?>

<!-- Header -->
<?php echo $this->render('../../common/_header.php'); ?>

<div class="row">
	<div class="col-md-2">
		<!-- Nav -->
		<?php echo $this->render('../../common/_navbar'); ?>
	</div>
	
	<div class="col-md-10">
		<div class="row">
			<div class="col-md-9 col-sm-8">
				<div class="main-content">
					<div class="row">
						<div class="col-md-12">
							<div class="chart-block">
								<?php
								if (isset($response)) {
									if ($response['status'] == 0) {
										?>
										<div class="alert alert-danger fade in alert-dismissable">
										<?php echo $response['error'] ?>
										</div>
										<?php
									} elseif ($response['status'] == 1) {
										?>
										<div class="alert alert-success fade in alert-dismissable">
											<?php echo $response['data'] ?>
										</div>
										<?php
									}
								}
								?>
								<?php if (Yii::$app->user->identity->twofa_enabled == 1) { ?>
								<div class="">
									<?php echo Html::beginForm(); ?>
										<div style="height:20px;"></div>
										<div class="row">
											<div class="col-md-12">
												<h2>Turn off two-factor authentication</h2>
											</div>
										</div>
										<div style="height:20px;"></div>
										<div class="row">
											<div class="col-md-4">Google Authenticator</div>
											<div class="col-md-8"><input class="text-center" type="text" name="pass" autocomplete="off" /></div>
										</div>
										<div style="height:20px;"></div>
										<div class="row">
											<div class="col-md-12 text-center">
												<center>
													<button type="submit" class="button button-info" name="switch">Disable</button>
												</center>
											</div>
										</div>
									<?php echo Html::endForm(); ?>
								</div>
								<?php } else { ?>
								<div class="">
										<?php echo Html::beginForm(); ?>
										<div class="row">
											<div class="col-md-12">
												<h2>Two-factor authentication</h2>
												<p><b>1.</b> Install Google Authenticator</p>
												<p>
													<ul class="list-unstyled">
														<li>
															<a href="https://itunes.apple.com/app/google-authenticator/id388497605?mt=8" target="_blank"><i class="fa fa-apple"></i> <span>iPhone iOS</span></a>
														</li>
														<li>
															<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank"><i class="fa fa-android"></i> <span>Android</span></a>
														</li>
													</ul>
												</p>
											</div>
										</div>
										<div style="height:20px;"></div>
										<div class="row">
											<div class="col-md-12">
												<p><b>2.</b> Scan the QR-code or enter the code using Google Authenticator</p>
												<center>
													<?php
													if (isset($data) && $data['status'] == 1) {
														?>
														<p><kbd><?php echo $data['data']['secret']; ?></kbd></p>
														<img src="<?php echo urldecode($data['data']['qrCodeUrl']); ?>" />
														<?php
													}
													?>
												</center>
											</div>
										</div>
										<div style="height:20px;"></div>
										<div class="row">
											<div class="col-md-12">
												<p><b>3.</b> Enter the password from Google Authenticator</p>
											</div>
											<div class="col-md-4 text-right">Password:</div>
											<div class="col-md-8"><input class="text-center" type="text" name="pass" autocomplete="off" /></div>
										</div>
										<div style="height:20px;"></div>
										<div class="row">
											<div class="col-md-12 text-center">
												<center>
													<button type="submit" style="background:#1d75b7;border:#1d75b7;" class="button button-info" name="switch">Enable</button>
												</center>
											</div>
										</div>
									<?php echo Html::endForm(); ?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" style="text-align:center;">
							<div class="copyright" style="color:#888;">Copyrigh ©2016 MinexSystems. All Rights Reserved.</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>