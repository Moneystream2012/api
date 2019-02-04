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
				<?php echo $this->render('../../admin/common/_navbar', ['active' => 'parkings']); ?>
			</div>
			<div class="col-md-10">
				<!-- Table Section -->
				<section class="table-section table-with-tabs">
					<div class="row">
						<div class="col-md-12">
							<h4 class="table-title">Parkings</h4>
							<ul class="nav nav-tabs">
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 1) echo 'class="active"'; ?>>	<?php echo Html::a("Active($activeParkings)" , ['admin/parking/list','status'=>1]); ?></li>
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 2) echo 'class="active"'; ?>>  <?php echo Html::a("Completed($completedParkings)" , ['admin/parking/list','status'=>2]); ?></li>
								<li <?php if (isset($_GET['status']) &&  $_GET['status'] == 0) echo 'class="active"'; ?>>  <?php echo Html::a("Canceled($cancelParkings)" , ['admin/parking/list','status'=>0]); ?></li>
							</ul>
						</div>
					</div>
					<div class="tab-content">
						<div id="tab1" class="tab-pane fade in active">
							<table class="table border-rounded-table">
								<thead>
									<tr>
										<th>Adress</th>
										<th>Created</th>
										<th>Type<i class="material-icons">arrow_drop_down</i></th>
										<th>Time left<i class="material-icons">arrow_drop_down</i></th>
										<th>Balance</th>
										<th>Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if (isset($models) && count($models) > 0) {
											foreach ($models as $model) {
												?>
													<tr>

														<td class="address-link"><?php echo Html::a($model['address'], ['admin/user/view', 'id'=>$model['userId']], ['class' => 'address-link']); ?></td>
														<td><?php echo date("d:m:Y H:i:s",$model['created']); ?></td>
														<td><?php echo $model['type']; ?></td>
														<td><?php echo date("d:m:Y H:i:s", $model['expired']); ?></td>
														<td><?php echo number_format($model['balance'],8); ?> MNC</td>
														<td><?php echo number_format($model['amount'], 8); ?> MNC</td>
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
