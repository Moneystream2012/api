<?php

/**
 * Dashboard view.
 */

use yii\helpers\Html;

if ($user->status > 0) $parkTarget = '#parking-confirmation-popup';
else $parkTarget = '#init-activation-popup';

?>

<!-- Header -->
<?php echo $this->render('../../common/_header.php'); ?>

<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<!-- Nav -->
				<?php echo $this->render('../../common/_navbar', ['active'=>'dashboard']); ?>
			</div>
	
			<div class="col-md-10">
				<!-- Park Section -->
				<section class="park-section">
					<div class="row">
						<?php
							$jsParkingTypes = [];
							$jsSelectedParkingTypeId = 0;
							$selectedParkingType = null;
							$first = true; 
							if (isset($parkingTypes) && count($parkingTypes) > 0) {
								foreach ($parkingTypes as $type) {
									if ($first) {
										$jsSelectedParkingTypeId = $type->id;
										$selectedParkingType = $type;
									}
									$jsParkingTypes[] = '"'.$type->id.'" : {"title":"'.$type->title.'", "rate":'.$type->rate.', "id":'.$type->id.', "period":'.$type->period.'}';

									?>
										<div class="col-md-4 col-sm-4">
											<div class="park-item item-<?php echo $type->id.($first ? ' active' : ''); ?>" onclick="setParkingType(<?php echo $type->id; ?>);">
												<div class="circle-block">
													<input type="text" onclick="setParkingType(<?php echo $type->id; ?>);" value="0" rel="<?php echo $type->rate; ?>" data-min="0" data-max="600" data-linecap="round" class="circle" />
													<div class="counter" style="font-size:27px;" onclick="setParkingType(<?php echo $type->id; ?>);"><?php echo $type->rate; ?>%</div>
												</div>
												<h3><?php echo $type->title; ?></h3>
											</div>
										</div>
									<?php
									if ($first) $first = false;
								}
							}
							echo '<script>
								window.parkingTypes = {'.join(',', $jsParkingTypes).'};
								window.selectedParkingTypeId = '.$jsSelectedParkingTypeId.';
							</script>';
						?>
					</div>
				</section>

				<!-- Park Coins Section -->
				<section class="park-coins-section">
					<div class="top-panel">
					<!-- class="section-title"  -->
						<h3 style="color: #24E1BA;line-height: 1;margin: 0;font-size: 16px;font-family: 'RobotoMedium', sans-serif;">Park coins</h3>
					</div>
					<div class="body-panel">
						<div class="row">
							<div class="col-md-6 col-sm-6 border-right">
								<div class="park-coins-item">
									<p>Parking type:</p>
									<div class="radio-group clearfix">
										<?php
											if (isset($parkingTypes) && count($parkingTypes) > 0) {
												$first = true;
												foreach ($parkingTypes as $type) {
													?>
														<div class="radio-button">
														<input id="radio<?php echo $type->id; ?>" onclick="setParkingType(<?php echo $type->id; ?>);" type="radio" name="radios1" <?php echo ($first ? 'checked="checked"' : ''); ?> />
														<label for="radio<?php echo $type->id; ?>"><?php echo $type->title; ?></label>
													</div>
													<?php
													if ($first) $first = false;
												}
											}
										?>
									</div>
								</div>
								<div class="park-coins-item">
									<p style="padding-top: 10px;">Amount:</p>
									<div class="input-group">
										<input id="inputAmount" type="text" placeholder="0.00000000" class="form-control" />
										<div class="input-group-addon">MNX</div>
									</div>
									<p style="font-size: 10px; color: #595A5D; font-family: RobotoRegular; padding: 14px 0 0 5px;">Fee: 0.00001 MNX</p>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="park-coins-item">
									<p>Parking rate:</p>
									<!-- ( <?php echo $selectedParkingType->period/24/60/60; ?>d ) -->
									<div class="rate"><?php echo ($selectedParkingType ? $selectedParkingType->rate : '0'); ?>% </div>
								</div>
								<div class="park-coins-item">
									<p>Expected return:</p>
									<div class="return"><span id="new-parking-profit-value" style="font-size:34px;">0.00000000</span> <span>MNX</span></div>
								</div>
							</div>
						</div>
					</div>
					<div class="bottom-panel">
						<!-- <a href="#confirmation-green-popup" class="call-popup cancel-button">Cancel</a> -->
						<a href="<?php echo $parkTarget; ?>" id="validate-new-parking-data-button" class="button-bordered call-popup">Create</a>
						<!-- #parking-confirmation-popup -->
						<!-- <button id="validate-new-parking-data-button" class="button-bordered">Create</button> -->
					</div>
				</section>
		
				<!-- List of parkings -->
				<section class="table-section">
					<h4 class="table-title">Active parkings</h4>
					<table class="table" >
						<thead>
							<tr>
								<th>Parking ID</th>
								<th>Status</th>
								<th>Created</th>
								<th>Type</th>
								<th>Rate</th>
								<th>Amount</th>
								<th>Return</th>
								<th>Time left</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody  id="user-dashboard-parking-list" style="height: 400px;">
						
							<?php
								if (isset($parkings) && count($parkings) > 0) {
									/** @var object $parkingService Parking service instance. */
									$parkingService = $this->context->getService('Parking');

									/** @var array $parkingTypesCache Parking types. */
									$parkingTypesService = $this->context->getService('ParkingType');

									foreach ($parkings as $parking) {
										$type = 'Undefined';
										$parkingType = $parkingTypesService->getFromCache($parking->type_id);
										if ($parkingType)
											$type = $parkingType->title;

										$remain = $parking->expired - time();

										$days = str_pad(floor($remain / (3600 * 24)), 2, '0', STR_PAD_LEFT);
										$hours = str_pad(floor($remain / 3600), 2, '0', STR_PAD_LEFT);
										$minutes = str_pad(ceil($remain / 60), 2, '0', STR_PAD_LEFT);
										?>
											<tr id="user-dashboard-parking-<?php echo $parking->id; ?>">
												<td><?php echo $parking->id; ?></td>
												<td><?php echo $parkingService->getStatusAsString($parking->status); ?></td>
												<td><?php echo $parkingService->formatDate($parking->created); ?></td>
												<td><?php echo $type; ?></td>
												<td><?php echo $parking->rate; ?>%</td>
												<td><?php echo number_format($parking->amount,8); ?> MNX</td>
												<td><?php echo number_format($parking->return_amount ,8); ?> MNX</td>
												<td class="parking_expire_row"><?php echo $days.':'.$hours.':'.$minutes; ?></td>
												<td>
													<?php if ($parkingService->canBeCanceled($parking)) { ?>
														<a href="#cancel-parking-popup" data-id="<?php echo $parking->id; ?>" class="cancel-link cancel-parking-link call-popup">Cancel</a>
													<?php } ?>
												</td>
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
				</section>

				<!-- Payouts -->
				<section class="table-section">
					<h4 class="table-title">Latest payouts</h4>
					<table class="table">
						<thead>
							<tr>
								<th class="text-left" style="width: 550px;">Transaction ID</th>
								<th>Time</th>
								<th class="text-right">Return</th>
							</tr>
						</thead>
						<tbody id="user-dashboard-payout-list">
							<?php
								if (isset($payouts) && count($payouts) > 0) {
									foreach ($payouts as $payout) {
										?>
											<tr>
												<td class="text-left"><?php echo Html::a($payout->transaction_id, 'http://minexexplorer.com/?r=explorer/tx&hash='.$payout->transaction_id, ['target'=>'_blank' ,'class' => 'address-link ']); ?></td>
												<td><?php echo date("d.m.y H:i", $payout->created); ?></td>
												<td class="text-right"><?php echo number_format($payout->amount, 8) ?> MNX</td>
											</tr>
										<?php
									}
								} else {
									?>
										<tr id="parking-list-hint"><td colspan="9" style="width: 945px; height: 150px"><img src="/img/trans_ic.png" alt="P" ><br><br><span style="color: #8c8c8c;">No payout yet</span></td></tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</section>
			</div>
		</div>
	</div>
</main>




<div class="popup_forms">

	<!-- Parking creation popup -->
	<?php echo $this->render('../../common/_new_parking_popup.php');?>

	<!-- Parking creation confirmation popup -->
	<?php echo $this->render('../../common/_new_parking_confirm_popup'); ?>

	<!-- Parking canceletion popup -->
	<?php echo $this->render('../../common/_parking_cancel_popup.php'); ?>

	<!-- Parking canceletion feedback popup -->
	<?php echo $this->render('../../common/_parking_canceled_popup.php'); ?>
</div>