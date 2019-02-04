<!-- Button -->
		<button class="btn btn-primary" data-toggle="modal" data-target="#parkingForm">Parking Modal</button>
		<!-- Modal -->
		<div class="modal fade" id="parkingForm" tabindex="-1" role="dialog" aria-labelledby="parkingFormLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="parkingFormLabel">Park coins</h4>
					</div>
					<div class="alert alert-dismissible alert-danger" id="danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						You have not enough minexcoins on you wallet
					</div>
					<div class="alert alert-dismissible alert-success" id="success-alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Success
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row">
								<div class="form-group">
									<div class="col-lg-12">
										<label class="control-label">Parking type:</label>
										<div class="radio">
											<label>
											<input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
											Daily 17%
											</label>
											<label>
											<input type="radio" name="optionsRadios" id="optionsRadios2" value="2">
											Mounthly 20%
											</label>
											<label>
											<input type="radio" name="optionsRadios" id="optionsRadios3" value="3">
											Yearly 25%
											</label>
										</div>
									</div>
									<div id="amount" class="col-lg-4">
										<label class="control-label">Amount:</label>
										<input type="text" class="form-control" id="amount-text">
									</div>
									<div class="col-lg-12">
										<label class="control-label">Expected return:</label>
										<p>0.000000 MNC</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" id="next">Next</button>
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript">
	
	$('#next').on('click', function(){
		var amount = $("#amount-text").val();
		var optionsRadios = $('input[name=optionsRadios]:checked').val();
		console.log(amount,optionsRadios);
		
		$.ajax({
			url: '?r=user/parking/form',
			data: {"optionsRadios": optionsRadios, "amount": amount, "_csrf" : '<?php echo Yii::$app->request->getCsrfToken(); ?>' },
			type: 'POST',
			success: function(response){
           			if (response.status !== 0) {
           				$('#success-alert').show();
           				$('#parkingForm').hide();
						$('#parkingConfirmForm').modal('show');
						if ($('#parkingConfirmForm').hide() == true) {
							$('#parkingConfirmForm').show();
						}
           			}
	        		else {
       					$('#success-alert').hide();
       					$('.alert-danger').show();
       				}

			},
			error: function(){
				$('.alert-danger').css("display", "inline");
			}
		});
	});
</script>