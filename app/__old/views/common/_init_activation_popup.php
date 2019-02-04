<?php

$user = $this->context->getService('User')->getUser();

?>
<!-- <script type="text/javascript">
	$(document).ready(function(){
		$("#init-activation-popup").modal('show');
	});
</script> -->


<!-- <div class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header" style="border-bottom: 0; ">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Confirmation</h4>
			</div>
			<div class="modal-body text-center">
				<p>Your account is confirmed.</p>
			</div>
			<div class="modal-footer" style=" border-top: 0; text-align:center;  ">
				<button type="button" class="btn btn-default " data-dismiss="modal" style="border-radius: 0; width: 100px; background: white;" >
					Cancel
				</button>
				<button type="button" id="confirm" class="btn btn-default " data-dismiss="modal" style="border-radius: 0; width: 100px; background: #ececec;">Confirm</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	window.onload = function() {
		$("#park-percent-17").click(function(){
			$("#init-activation-popup").modal('show');
		});
		$("#confirm").click(function(){	
			$("#activation-info-popup").modal('show');
		});
	};
</script> -->

<div class="hidden">
	<div id="init-activation-popup" class="popup small-popup">
		<div class="top-panel">
			<div class="popup-title">Confirmation</div>
			<button type="button" class="close-popup"><i class="material-icons">close</i></button>
		</div>
		<div class="body-panel">
			<p>Your account is unconfirmed.</p>
		</div>
		<div class="botton-panel">
			<button type="button" class="button-bordered close-popup">Cancel</button><a href="#confirmation-popup" id="confirm-activation-button" class="button-bordered call-popup">Confirm</a>
			<!-- css for active confirm, if need -->
			<!--  style="background-color: #24E1BA;color: #25282C;"     -->
		</div>
	</div>
</div>
<div class="hidden">

	<div id="confirmation-popup" class="popup">
		<div class="top-panel">
			<div class="popup-title">Confirmation</div>
			<button type="button" class="close-popup"><i class="material-icons">close</i></button>
		</div>
		<div class="body-panel">
			<p>To confirm your account send 0.000001 MNC to the adress below</p>
			<div class="qr-code-img"><img src="<?php echo $user ? 'https://chart.googleapis.com/chart?cht=qr&chs=256&chl=XRh824hwfNikbu5Lqo2DaeaPtv3shuuzWy' : 'https://chart.googleapis.com/chart?cht=qr&chs=256&chl=None'; ?>" alt="alt"></div>
			<div class="code">XRh824hwfNikbu5Lqo2DaeaPtv3shuuzWy</div>
			<div class="status">Status: <span>Waiting for funds</span></div>
		</div>
		<div class="botton-panel">
			<button type="button" id="close-activation-info-button" class="button-bordered close-popup">Close</button>
		</div>
	</div>
</div>