<?php

/* @var $this yii\web\View */

// use yii\helpers\Html;
// use yii\helpers\Url;
use yii\widgets\LinkPager;

?>


<!-- Header -->
<?php echo $this->render('../../common/_header.php'); ?>


<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<!-- Nav -->
				<?php echo $this->render('../../common/_navbar', ['active'=>'notifications']); ?>
			</div>
			<div class="col-md-8" id="information">
				<section class="notifications-section" >
					<h1 class="page-title">Notifications</h1>
					<div id="notifications-list">	
						<?php
							$jsUserNotification = [];
							if (isset($notifications) && count($notifications) > 0) {
								foreach ($notifications as $notification) {
									$jsUserNotification[] = '"'.$notification->id.'"';
									// var_dump($jsUserNotification);
								?>
									<div id="notification-wrapper-<?php echo $notification->id; ?>" class="panel panel-default <?php if ($notification->seen == 0) echo 'new-notification'; ?>" <?php if ($notification->seen == 0) echo 'unseen-id="'.$notification->id.'"'; ?>>
										<div class="panel-heading ">
											<a href="#notification-<?php echo $notification->id; ?>" data-toggle="collapse" aria-expanded="true" class="spoiler-trigger collapsed">
												<div class="clearfix">
													<div class="title"><?php echo $notification->title; ?></div>
													<div class="date-time"><?php echo date("d-m-y H:i", $notification->created); ?></div>
												</div>
												<i class="material-icons">keyboard_arrow_down</i>
											</a>
										</div>
										<div id="notification-<?php echo $notification->id; ?>" class="panel-collapse collapse">
											<div class="panel-body">
												<table class="table notifications-table">
													<tbody>
														<tr>
															<td><?php echo $notification->content; ?></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								<?php
								}
							}
							echo '<script>
								window.userNotification1 = ['.join(',', $jsUserNotification).'];
							</script>';

						?>
					</div>
				</section>
				<div class="paginationAll"> 
					
				<?php
					// отображаем постраничную разбивку
					echo LinkPager::widget([
						'pagination' => $pagination,
						'registerLinkTags' => true
					]);
				?>
				</div>
			</div>
		</div>
	</div>
</main>

<!-- Confirm notification popup -->
<?php //  echo $this->render('../../common/_notification_info_popup');?>