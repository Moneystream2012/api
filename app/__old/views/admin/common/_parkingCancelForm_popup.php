<style type="text/css">

	#head-form {
		background-color: #C6C6C6;
	}

	#text {
		margin: 2% 0 4% 7%;
		font-size: 1.5em;
	}

	#button-no, #button-yes {
		float: left;
		font-size: 1.3em;
		padding: 1% 7% 1% 7%;
		border: 1px solid #C6C6C6;

		margin-bottom: 3%;
		margin-left: 5%;
	}
</style>
<!-- <button class="btn btn-primary" data-toggle="modal" data-target="#parkingConfirmForms" id="btn-form">CANCEL!!!</button> -->
<div class="modal fade" id="parkingConfirmForms" tabindex="-1" role="dialog" aria-labelledby="parkingFormLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="head-form">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="parkingFormLabel">Cancel</h4>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="form-group">
							<p id="text">Are you really want to cancel this parking?</p>
						</div>
					</div>
					<div id="buttons">
						<button class="btn btn-default" data-dismiss="modal" id="button-no">No</button>
						<button id="button-yes" class="btn btn-default" onclick="cancelParking()">yes</button>
					</div>						
				</div>
			</div>
		</div>
	</div>
</div>