<!-- Modal -->
<div class="modal fade" id="new-parking-popup" tabindex="-1" role="dialog" aria-labelledby="parkingFormLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="parkingFormLabel">Park coins</h4>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="form-group">
							<div class="col-lg-12">
								<label class="control-label">Parking type:</label>
								<div class="parkingInfo" id="parking-type-info"></div>
							</div>
							<div id="amount" class="col-lg-4">
								<label class="control-label">Amount:</label>
								<input type="text" class="form-control" id="new-parking-amount-field">
							</div>
							<div class="col-lg-12">
								<label class="control-label">Expected return:</label>
								<div class="expected-return"></div>
								<p><span id="new-parking-profit-value">0.00000000</span> MNC</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="new-parking-form-close-button">Cancel</button>
				<button type="button" class="btn btn-primary" id="validate-new-parking-data-button">Add</button>
			</div>
		</div>
	</div>
</div>

<!-- Cancel creation -->
<!-- <div class="hidden">
	<div id="confirmation-green-popup" class="popup small-popup">
		<div class="top-panel">
			<div class="popup-title">Confirmation</div>
			<button type="button" class="close-popup"><i class="material-icons">close</i></button>
		</div>
		<div class="body-panel">
			<p>Are you really want to cancel this parking?</p>
		</div>
		<div class="botton-panel">
			<button type="button" class="button-bordered close-popup">No</button>
			<button type="button" class="button-bordered close-popup close-park-button">Yes</button>
		</div>
	</div>
</div> -->