
<!-- <script type="text/javascript">
	$(document).ready(function(){
		$("#init-activation-popup").modal('show');
	});
</script> -->


<div id="init-activation-popup" class="modal fade">
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
</script>