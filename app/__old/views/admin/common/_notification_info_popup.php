<!-- 
<script type="text/javascript">
	$(document).ready(function(){
		$("#notification-info-popupl").modal('show');
	});
</script> -->


<div id="notification-info-popup" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Notification</h4>
			</div>
			<div class="modal-body ">
				<div id="notification-content-popup"></div>
			</div>
			<div class="modal-footer text-center " style="border-top: 0; text-align:center;  ">
				<button type="button" class="btn btn-default text-center" data-dismiss="modal" style="border-radius: 0; width: 100px; background: white;" >Close</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	function notificationInfoPopup(content) {
		$("#notification-info-popup").click(function () {
			console.log(content)
		$('#notification-content-popup').slideToggle( "slow", function() {
    	content;
  });


});

		// $('#notification-content-popup').html(content);
		// $("#notification-info-popup").modal('show');	
	};
</script>
