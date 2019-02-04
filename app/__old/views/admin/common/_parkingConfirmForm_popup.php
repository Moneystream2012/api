<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all">
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/css/bootstrap-glyphicons.css" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<!-- Button -->
		<!-- <button class="btn btn-primary" data-toggle="modal" data-target="#parkingConfirmForm" id="btn-form">parkingConfirmForm</button> -->
		<!-- Modal -->
		<div class="modal fade" id="parkingConfirmForm" tabindex="-1" role="dialog" aria-labelledby="parkingFormLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="parkingFormLabel">Confirmation</h4>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row">
								<div class="form-group">
									<div class="col-lg-12">
										<label class="control-label">Parking type:</label>
										<p>0.000000 MNC</p>
									</div>
									<div class="col-lg-12">
										<label class="control-label">Amount:</label>
										<p>Monthly 20%</p>
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
						<button type="button" class="btn btn-default pull-left" id="form-back"><- Back</button>
						<button type="button" class="btn btn-default" data-dismiss="modal" id="close-form">Cancel</button>
						<button type="button" class="btn btn-primary" id="done">Confirm</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script type="text/javascript">
	$('#form-back').on('click', function () {
		$('#parkingForm').show();
		$('#parkingConfirmForm').hide();
	});

	$('#done').on('click', function (){
		var amount = $("#amount-text").val();
		var optionsRadios = $('input[name=optionsRadios]:checked').val();
		$.ajax({
				url: '?r=user/parking/add',
				data: {"optionsRadios": optionsRadios, "amount": amount, "_csrf" : '<?php echo Yii::$app->request->getCsrfToken(); ?>' },
				type: 'POST',
				success: function(response){
					
				},
				error: function(){
					
				}
			});
		});
	$('#form-back').on('click', function(){
		$('#success-alert').hide();
        $('.alert-danger').hide();
	});
</script>