<!-- 
<script type="text/javascript">
	$(document).ready(function(){
		$("#activation-info-popupl").modal('show');
	});
</script> -->


<div id="activation-info-popup" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="border-bottom: 0; ">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Confirmation</h4>
			</div>
			<div class="modal-body text-center">
				<p>To confirm your account send 0.000001 MNC</p>
				<p>to adress below </p>
				<img src="https://chart.googleapis.com/chart?cht=qr&chl=Hello+world&chs=255" alt="..." class="img-thumbnail">
				<p style="padding-top: 10px;"><b>DFDSQAFASFASDFASDFASDFFASD</b></p>
				<p>Status:<span id="information-status"> Waiting for deposits</span> </p>
			</div>
			<div class="modal-footer text-center " style="border-top: 0; text-align:center;  ">
				<button type="button" class="btn btn-default text-center" data-dismiss="modal" style="border-radius: 0; width: 100px; background: white;" >Close</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	window.onload = function() {
		$("#confirm").click(function(){
			$("#activation-info-popup").modal('show');
			scanActivationStatus();
		});

		function scanActivationStatus() {
			$.post("<?php echo yii\helpers\Url::to(['user/check-activation']); ?>", {"_csrf":"<?php echo Yii::$app->request->getCsrfToken(); ?>"}, function(response) {
				if (response.status) {
					if (!response.data)
						setTimeout(scanActivationStatus, 1000);
					else
						alert('Account is active now');
				} else
					alert(response.error || 'System error');
			});
		}
	};
</script>
