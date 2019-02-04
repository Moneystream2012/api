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
				<?php echo $this->render('../../admin/common/_navbar', ['active'=>'subscribers']); ?>
			</div>
			<div class="col-md-7">
				<!-- Table Section -->
				<section class="table-section">
					<div class="title-block clearfix">
						<h1 class="page-title">Subscribers</h1>
						<div class="total-subscribers">Total (<?php if(isset($subscribers) && count($subscribers) > 0){ echo count($subscribers); }?>)</div>
					</div>
					<table class="table subscribers-table border-rounded-table">
						<thead>
							<tr>
								<th>Email</th>
								<th> </th>
							</tr>
						</thead>
						<tbody>
							<?php
								if (isset($subscribers) && count($subscribers) > 0) {
									foreach ($subscribers as $subscriber) {
										?>
							<tr>
								<td><?php echo $subscriber['email']; ?></td>
								<td><?php echo date("Y-m-d H:i:s", $subscriber['created']); ?></td>
							</tr>
							<?php
								}
								}
								?>
						</tbody>
					</table>
					<?php
						echo LinkPager::widget([
							'pagination' => $pagination,
							'registerLinkTags' => true
						]);
						?>
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