<?php

/** @var $this yii\web\View */
/** @var \app\models\Payout[] $payouts */
/** @var \yii\data\Pagination $pagination */

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
				<?php echo $this->render('../../admin/common/_navbar', ['active' => 'payouts']); ?>
			</div>
			<div class="col-md-10">
				<!-- Table Section -->
				<section class="table-section table-with-tabs">
					<div class="tab-content">
						<div id="tab1" class="tab-pane fade in active">
							<table class="table border-rounded-table">
								<thead>
									<tr>
										<th class="text-left">Transaction ID</th>
										<th>Time</th>
										<th class="text-right">Return</th>
									</tr>
								</thead>
								<tbody>
									<?php
										 if (isset($payouts) && count($payouts) > 0) {
											 foreach ($payouts as $payout) {
												?>
												<tr>
													<td><a href="http://minexexplorer.com/?r=explorer/tx&hash=<?php echo $payout->transaction_id; ?>" target="_blank" class="address-link"><?php echo $payout->transaction_id; ?></a></td>
													<td><?php echo date("d.m.y H:i", $payout->created); ?></td>
													<td><?php echo number_format($payout->amount, 8) ?> MNX</td>
												</tr>
												<?php
											}
										 }
									?>
								</tbody>
							</table>
							<div class="paginationAll"> 
								<?php
									echo LinkPager::widget([
										'pagination' => $pagination,
										'registerLinkTags' => true
									]);
								?>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</main>
