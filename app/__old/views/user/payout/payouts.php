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
					<?php echo $this->render('../../common/_navbar', ['active'=>'payouts']); ?>
				</div>
				<div class="col-md-10">
					<!-- Table Section -->
					<section class="table-section">
						<h4 class="table-title">Payouts</h4>
						<table class="table">
							<thead>
								<tr>
									<th class="text-left" style="width: 550px;">Transaction ID</th>
									<th>Time</th>
									<th class="text-right">Return</th>
								</tr>
							</thead>
							<tbody id="user-payouts-payout-list">
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
									} else {
									?>
										<tr id="parking-list-hint"><td colspan="9" style="width: 945px; height: 150px"><img src="/img/trans_ic.png" alt="P" ><br><br><span style="color: #8c8c8c;">No payout yet</span></td></tr>
									<?php
								}
								?>
							</tbody>
						</table>
						<div class="paginationAll"> 
						<?php
							// отображаем постраничную разбивку
							echo LinkPager::widget([
								'pagination' => $pages,
								'registerLinkTags' => true
							]);
						?>
						</div>
					</section>
				</div>
			</div>
		</div>
	</main>
	<!-- Footer -->
