<?php
	/* @var $this yii\web\View */
	
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	?>
<!-- Header -->
<?php echo $this->render('../../admin/common/_header.php'); ?>
<!-- Main -->
<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<!-- Nav -->
				<?php echo $this->render('../../admin/common/_navbar', ['active'=>'setting']); ?>
			</div>
			<div class="col-md-7">
				<!-- Table Section -->
				<section class="settings-section">
				<h1 class="page-title">Settings</h1>
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="#settings-1" data-toggle="collapse" class="spoiler-trigger collapsed">
								<div class="clearfix">
									<div class="title">Payout server address</div>
									<div class="status">Change</div>
									<i class="material-icons">keyboard_arrow_down</i>
								</div>
							</a>
						</div>
						<div id="settings-1" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="settings-inner ">
									<form data-toggle="validator" class="main-form">

										<div class="form-group has-feedback">
											<p>Current payout server address:</p>
											<p><?php echo isset($data['payout_server_address']) ? $data['payout_server_address'] : "No payout server address"; ?></p>
											<label>New payout server address</label>
											<input type="text" id="new-payout-address" placeholder="New payout server address" required class="form-control">
											<div class="help-block with-errors"></div>
										</div>

									</form>
								</div>
								<div class="buttons-group">
									<a class="button-bordered" href="#" onclick="changePayoutServerAddress()">Change</a>
									<!-- <?php //echo Html::a('Change', Url::to(['user/setting/change-password']), ['class'=>'button-bordered']); ?> -->
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="#settings-2" data-toggle="collapse" class="spoiler-trigger collapsed">
								<div class="clearfix">
									<div class="title">Bank сhange address</div>
									<div class="status">Change</div>
									<i class="material-icons">keyboard_arrow_down</i>
								</div>
							</a>
						</div>
						<div id="settings-2" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="settings-inner ">
									<form data-toggle="validator" class="main-form">

										<div class="form-group has-feedback">
											<p>Current bank сhange address:</p>
											<p><?php  echo isset($data['bank_change_address']) ? $data['bank_change_address'] : "No bank change address";  ?></p>
											<label>New bank сhange address</label>
											<input type="text" id="new-change-address" placeholder="New bank сhange address" required class="form-control">
											<div class="help-block with-errors"></div>
										</div>

									</form>
								</div>
								<div class="buttons-group">
									<a class="button-bordered" href="#" onclick="changeBankChangeAddress()">Change</a>
									<!-- <?php //echo Html::a('Change', Url::to(['user/setting/change-password']), ['class'=>'button-bordered']); ?> -->
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="#settings-3" data-toggle="collapse" class="spoiler-trigger collapsed">
								<div class="clearfix">
									<div class="title">Quantity strings cron</div>
									<div class="status">Change</div>
									<i class="material-icons">keyboard_arrow_down</i>
								</div>
							</a>
						</div>
						<div id="settings-3" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="settings-inner ">
									<form data-toggle="validator" class="main-form">

										<div class="form-group has-feedback">
											<p>Current quantity strings cron: <?php echo  isset($data['quantity_strings_cron']) ? "(".$data['quantity_strings_cron'].")" : "No quantity strings cron"; ?></p>
											<label>New quantity strings cron</label>
											<input type="text" id="new-quantity-strings-cron" placeholder="New quantity strings" required class="form-control">
											<div class="help-block with-errors"></div>
										</div>

									</form>
								</div>
								<div class="buttons-group">
									<a class="button-bordered" href="#" onclick="changeQuantityStringsCron()">Change</a>
									<!-- <?php //echo Html::a('Change', Url::to(['user/setting/change-password']), ['class'=>'button-bordered']); ?> -->
								</div>
							</div>
						</div>
					</div>										
				</section>
			</div>
		</div>
	</div>
</main>
<!-- Footer -->
<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-2">
				<div class="copyright"></div>
			</div>
		</div>
	</div>
</footer>