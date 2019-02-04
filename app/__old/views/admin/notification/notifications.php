<?php
use yii\widgets\LinkPager;
$parkingService = $this->context->getService('User');
if(isset($_GET['id'])) $userInfo = $parkingService->getInfo($_GET['id']);
?>


<!-- Header -->
<?php echo $this->render('../../admin/common/_header.php'); ?>
<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
		<!-- Nav -->
		<?php echo $this->render('../../admin/common/_navbar', ['active' => 'notifications']); ?>
	</div>


          <div class="col-md-8">
            <!-- Create Notification Section -->
            <section class="create-notification-section">
              <h1 class="page-title">Notifications</h1>
              <form data-toggle="validator" class="main-form create-notification-form">
                <div class="form-title">Create notification <?php if(isset($userInfo)) echo " for user ".$userInfo['address']; ?> </div>
                <div class="form-group has-feedback">
                  <input type="text" name="title" placeholder="Title" id="notification-title" required class="form-control">
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                  <textarea name="title" placeholder="(You can use html-tags)" id="notification-content" rows="5" required class="form-control"></textarea>
                  <xmp style="font-size: 10px;">Example:  <ul><li>Daily: <b>5%</b></li><li>Weekly: <b>10%</b></li><li>Yearly: <b>15%</b></li></ul></xmp>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="buttons-group">
                  <button type="button" class="cancel-button">Cancel</button>
                  <a href="#confirmation-green-popup" id="buttonNewNotification" class="button-bordered call-popup"  >Send</a>
                </div>
              </form>
            </section>
            <!-- Notifications Section -->
            <section class="notifications-section">
              <h1 class="page-title">Latest Notifications</h1>

						<?php
					if (isset($notifications) && count($notifications) > 0) {
						foreach ($notifications as $notification) {
							?>
				              <div class="panel panel-default new-notification">
				                <div class="panel-heading"><a href="#notification-<?php echo $notification->id; ?>" data-toggle="collapse" class="spoiler-trigger collapsed">
				                    <div class="clearfix">
				                      <div class="title"><?php echo $notification->title; ?></div>
				                      <div class="date-time"><?php echo date("d:m:Y H:i:s", $notification->created); ?></div>
				                    </div><i class="material-icons">keyboard_arrow_down</i></a></div>
				                <div id="notification-<?php echo $notification->id; ?>" class="panel-collapse collapse">
				                	<div class="panel-body">
										<?php echo $notification->content; ?>                  
									</div>
				                </div>
				              </div>
								
							<?php
						}
					}
				?>

		<div class="paginationAll"> 
		<?php
		// отображаем постраничную разбивку
			echo LinkPager::widget([
				'pagination' => $pagination,
				'registerLinkTags' => true
			]);
		?> 
		</div>
            </section>
            
          </div>
        </div>
      </div>
    </main>

    <!-- Hidden Popup -->

    <div class="hidden">
      <div id="confirmation-green-popup" class="popup small-popup">
        <div class="top-panel">
          <div class="popup-title">Confirmation</div>
          <button type="button" class="close-popup"><i class="material-icons">close</i></button>
        </div>
        <div class="body-panel">
          <p>Are you really want to send this notification?</p>
        </div>
        <div class="botton-panel">
          <button type="button" class="button-bordered close-popup">No</button>
          <button type="button" id="confirm" class="button-bordered close-popup close-park-button">Yes</button>
        </div>
      </div>
    </div>








<!-- Confirm notification popup -->
<!-- <?php //echo $this->render('../../admin/common/_new_notification_popup');?> -->

