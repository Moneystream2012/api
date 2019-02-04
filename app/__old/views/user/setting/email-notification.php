<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<style type="text/css">
.form-control{
	width: 60%;
}
</style>
<!-- Header -->
<?php echo $this->render('../../common/_header.php'); ?>

<div class="row">
	<div class="col-md-2">
		<!-- Nav -->
		<?php echo $this->render('../../common/_navbar'); ?>
	</div>
	<div class="col-md-10" id="information" >
		<form class="form-horizontal text-cetner" >
			<div class="form-group">
				<label class="col-sm-2 control-label">Notication email</label>
					<div class="col-sm-10">
						<input type="email" id="notification-email" class="form-control">
					</div>
			</div>
				<div class="col-sm-offset-2 col-sm-10" style="padding-top: 20px; border-radius: 0;">
					<button type="button" onclick="notificationEmail()" class="btn btn-default">Submit</button>
				</div>

		</form>

	</div>
</div>
	

<script>
function notificationEmail(){

// if($("#new-password").val().trim() !== $("#confirm-new-password").val().trim()) alert()

	var data = {
		"notificationEmail":$("#notification-email").val(),
		"_csrf": '<?php echo Yii::$app->request->getCsrfToken(); ?>'
	};
	
	$.post("?r=user/setting/email-notification-process", data, function(response) {
		try {
			console.log(response);
			if (response.status) alert('Success');
			else alert(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		alert(e.responseJSON.error);
		console.log(e);
	});
}
</script>

