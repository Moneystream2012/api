<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>


<!-- Header -->
<?php echo $this->render('../../admin/common/_header.php'); ?>
<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<!-- Nav -->
				<?php echo $this->render('../../admin/common/_navbar'); ?>
			</div>

			<div class="col-md-7">
				<!-- User Info Section -->
				<section class="user-info-section">
					<h1 class="page-title">User info</h1>
					<div class="user-info">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 border-right">
								<div class="user-info-item">
									<div class="user-info-title">Minexcoin adress:</div>
									<p class="address"><?php echo $user->address ?></p>
								</div>
								<div class="user-info-item">
									<div class="user-info-title">Account status:</div>
									<p class="red-color"><?php if($user->status = 0 ) echo 'Unconfirmed'; else echo 'Confirmed';   ?></p>
								</div>
								<div class="user-info-item">
									<div class="user-info-title">Balance:</div>
									<p><?php echo number_format($user->balance, 8) ?> MNX</p>
								</div>
								<div class="user-info-item">
									<div class="user-info-title">Registration time:</div>
									<p><?php echo date("d:m:y H:i", $user->created); ?></p>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="user-info-item">
									<div class="user-info-title">Android:</div>
									<p>Yes</p>
								</div>
								<div class="user-info-item">
									<div class="user-info-title">Email:</div>
									<p class="red-color"><?php echo $user->email ? : 'No' ?></p>
								</div>
								<div class="user-info-item">
									<div class="user-info-title">Country:</div>
									<p><?php echo $user->country ? :  'USA' ?></p>
								</div>
								<div class="user-info-item">
									<div class="user-info-title">Language:</div>
									<p>English</p>
								</div>
							</div>
						</div>
					</div>
				</section>


				<!-- Table Section -->
				<section class="table-section table-with-tabs">
					<div class="row">
						<div class="col-md-12">
							<h4 class="table-title">Parkings</h4>
							<ul class="nav nav-tabs">
								<?php $activeParkings = $filter['activeParkings'];?>
								<?php $completedParkings = $filter['completedParkings'];?>
								<?php $cancelParkings = $filter['cancelParkings'];?>
								<?php $allParkings = $filter['allParkings'];?>
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 1) echo 'class="active"'; ?>>	<?php echo Html::a("Active($activeParkings)" , Url::to(['admin/user/view','id'=>$_GET['id'],'status'=>1])); ?></li>
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 2) echo 'class="active"'; ?>>  <?php echo Html::a("Completed($completedParkings)" , Url::to(['admin/user/view','id'=>$_GET['id'],'status'=>2])); ?></li>
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 0) echo 'class="active"'; ?>>  <?php echo Html::a("Canceled($cancelParkings)" , Url::to(['admin/user/view','id'=>$_GET['id'],'status'=>0])); ?></li>
								<li <?php if (!isset($_GET['status'])) echo 'class="active"'; ?>>  <?php echo Html::a("History($allParkings)" , Url::to(['admin/user/view','id'=>$_GET['id']])); ?></li>
							</ul>
						</div>
					</div>
					<div class="tab-content">
						<div id="tab1" class="tab-pane fade in active">
							<table class="table">
								<thead>
									<tr>
										<th>Time</th>
										<th>Type<i class="material-icons">arrow_drop_down</i></th>
										<th>Time left<i class="material-icons">arrow_drop_down</i></th>
										<th>Balance</th>
										<th>Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (isset($parkings) && count($parkings) > 0) {
										foreach ($parkings as $parking) {
											$type = $this->context->getService('ParkingType')->find(['id'=>$parking->type_id]);
											$typeTitle = $type ? $type->title : 'Undefined';
											?>
											<tr>
												<td><?php echo date("d:m:y H:i", $parking->created); ?></td>
												<td><?php echo $typeTitle; ?></td>
												<td><?php echo date("d:m:y H:i", $parking->expired); ?></td>
												<td><?php echo number_format($parking->amount ? : 0, 8); ?> MNC</td>
												<td><?php echo number_format($parking->amount + $parking->amount * ($parking->rate / 100 /365), 8) ?> MNC</td>
											</tr>
											<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>

			<div class="col-md-2">
				<!-- Actions -->
				<div class="actions-block">
					<div class="block-title">Actions:</div>
					<ul>
						<li><a href="<?php echo Url::to(['admin/support/room','id'=>$supportRoomId]) ?>">Send message</a></li>
						<li><a href="http://minexexplorer.com/?r=explorer/address&hash=<?php echo $user->address; ?>">Blockchain info</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</main>