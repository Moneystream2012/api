
<!-- <script type="text/javascript">
	$(document).ready(function(){
		$("#init-activation-popup").modal('show');
	});
</script> -->




<!-- <div id="new-notification-popup" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header" style="border-bottom: 0; ">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Confirmation</h4>
			</div>
			<div class="modal-body text-center">
				<p>Are you really want to send  this notification?</p>
			</div>
			<div class="modal-footer" style=" border-top: 0; text-align:center;  ">
				<button type="button" class="btn btn-default " data-dismiss="modal" style="border-radius: 0; width: 100px; background: white;" >
					No
				</button>
				<button type="button" id="confirm" class="btn btn-default " data-dismiss="modal" style="border-radius: 0; width: 100px; background: #ececec;">Yes</button>
			</div>
		</div>
	</div>
</div> -->

<!-- <script type="text/javascript">
	var setListenerForConfirmation = true;

	function notificationInfoSlide(id) {
	// $(".buttonClick").click(function () {
	$('#notification-content-box-'+id).slideToggle("slow");
	}
	
	$('#buttonNewNotification').click(function() {
		// $("#confirmation-green-popup").modal('show');
		window.title = $('#notification-title').val();
		window.content = $('#notification-content').val();
		if (!title) return;

		if (setListenerForConfirmation) {
			$("#confirm").click(function(){
				$.post('?r=admin/notification/add-notification',
					window.data,
					handleNotidicationResponse
				);
			});
			setListenerForConfirmation = false;
		}
	
		window.data = {
			"title":title,
			"content":content,
			"_csrf":"<?php //echo Yii::$app->request->getCsrfToken(); ?>"
		};

		function handleNotidicationResponse(response) {
			if( response.status = 1){
				$("#notification-title").val(""); 
				$("#notification-content").val("");
			} else { response.error}
		}
	});
</script> -->