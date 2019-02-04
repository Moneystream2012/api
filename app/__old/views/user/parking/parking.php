<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<!-- Header -->
<?php echo $this->render('../../common/_header.php'); ?>
<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<!-- Nav -->
				<?php echo $this->render('../../common/_navbar', ['active'=>'parkings']); ?>
			</div>

			<div class="col-md-10">
				<section class="table-section table-with-tabs">
					<div class="row">
						<div class="col-md-12">
							<h4 class="table-title">Parkings</h4>
							<ul class="nav nav-tabs">
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 1) echo 'class="active"'; ?>>	<?php echo Html::a("Active($activeParkings)" , Url::to(['user/parking/index','status'=>1])); ?></li>
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 2) echo 'class="active"'; ?>>  <?php echo Html::a("Completed($completedParkings)" , Url::to(['user/parking/index','status'=>2])); ?></li>
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 0) echo 'class="active"'; ?>>  <?php echo Html::a("Canceled($cancelParkings)" , Url::to(['user/parking/index','status'=>0])); ?></li>
								<li <?php if (!isset($_GET['status'])) echo 'class="active"'; ?>>  <?php echo Html::a("History($allParkings)" , Url::to(['user/parking/index'])); ?></li>
							</ul>
						</div>
					</div>
					<div class="tab-content">
						<div id="tab1" class="tab-pane fade in active">
						<table class="table">
							<thead>
								<tr>
									<th>Parking ID</th>
									<th>Status</th>
									<th>Created</th>
									<th>Type<i class="material-icons">arrow_drop_down</i></th>
									<th>Rate</th>
									<th>Amount</th>
									<th>Return</th>
									<th>Time left<i class="material-icons">arrow_drop_down</i></th>
									<th>Action</th>
									<!-- <th>Info</th> -->
								</tr>
							</thead>
							<tbody id="user-parking-list">
								<?php
									if (isset($parkings) && count($parkings) > 0) {
										$parkingService = $this->context->getService('Parking');
										
										/** @var array $parkingTypesCache Parking types. */
										$parkingTypesService = $this->context->getService('ParkingType');
										
										foreach ($parkings as $parking) {
											$type = 'Undefined';
											$parkingType = $parkingTypesService->getFromCache($parking->type_id);
											if ($parkingType)
												$type = $parkingType->title;
											
											?>
												<tr id="user-parking-<?php echo $parking->id; ?>">
													<td style="min-width:100px;"><?php echo $parking->id; ?></td>
													<td class="status-prop"><?php echo $parkingService->getStatusAsString($parking->status); ?></td>
													<td style="min-width:130px;"><?php echo $parkingService->formatDate($parking->created); ?></td>
													<td style="min-width:80px;"><?php echo $type; ?></td>
													<td><?php echo $parking->rate; ?>%</td>
													<td><?php echo number_format($parking->amount, 8); ?> MNX</td>
													<td><?php echo number_format($parking->return_amount, 8); ?> MNX</td>
													<td class="expired-prop parking_expire_row" style="min-width:130px;"><?php echo $parkingService->determineTimerValue($parking); ?></td>
													<td class="control-prop">
														<!-- <a href="#" class="cancel-link" onclick="Parking(<?php echo $parking->id; ?>);return false;">Cancel</a> -->
														<?php if ($parkingService->canBeCanceled($parking)) { ?>
															<a href="#cancel-parking-popup" data-id="<?php echo $parking->id; ?>" class="cancel-link cancel-parking-link call-popup">Cancel</a>
														<?php } ?>
													</td>
													<!-- <td><button type="button"><span class="badge pull-center"><?php echo $parking->info; ?>></span></button> </td> -->
												</tr>
											<?php
										}
									} else {
									?>
										<tr id="parking-list-hint"><td colspan="9" style="width: 945px; height: 150px"><img src="/img/park_ic.png" alt="P" ><br><br><span style="color: #8c8c8c;">No parking yet</span></td></tr>
									<?php
								}
								?>
							</tbody>
						</table>
						</div>
					</div>
					<div class="paginationAll"> 
					<?php
						// отображаем постраничную разбивку
						echo LinkPager::widget([
							'pagination' => $pages,
							'registerLinkTags' => true
						]); //
					?>
					</div>
				</section>
			</div>
		</div>
	</div>
</main>
<div class="popup_forms">

	<!-- Parking canceletion popup -->
	<?php echo $this->render('../../common/_parking_cancel_popup.php'); ?>

	<!-- Parking canceletion feedback popup -->
	<?php echo $this->render('../../common/_parking_canceled_popup.php'); ?>
</div>