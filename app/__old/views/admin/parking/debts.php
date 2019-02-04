<?php

/* @var $this yii\web\View */

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
				<?php echo $this->render('../../admin/common/_navbar', ['active' => 'debts']); ?>
			</div>
			<div class="col-md-8">
				<section class="debts-section">
					<h1 class="page-title">Debts</h1>
						<?php
							if (isset($debts) && count($debts) > 0) {
								foreach ($debts as $debt) {
									?>
										<div class="debts-item">
											<div class="row">
												<div class="col-md-4 col-sm-4">
													<div class="debts-title"><?php echo $debt['type']->title; ?></div>
												</div>
												<div class="col-md-4 col-sm-4">
													<div class="debts-date"><?php echo date("d-m-Y H:i", $debt['type']->created); ?></div>
												</div>
												<div class="col-md-4 col-sm-4">
													<div class="debts-value"><?php echo number_format($debt['sum'] ? : 0, 8); ?> MNX</div>
												</div>
											</div>
										</div>
									<?php
								}
							}
						?>
				</section>
			</div>
		</div>
	</div>
</main>
<!-- 		<p>Debts</p>
	<div class="row" style="border:1px solid #ababab; background:#ececec;  margin-top: 5px;  color:#49b1f7; ">
		<div class="col-md-4"><?php echo $debt['type']->title; ?></div>
		<div class="col-md-4"><?php echo date("d-m-Y H:i", $debt['type']->created); ?></div>
		<div class="col-md-4 text-center"><?php echo number_format($debt['sum'] ? : 0, 8); ?> MNX</div>
	</div> -->



	</div>
</div>