<style>
	.input-group-addon{

    background-color: rgba(0, 0, 0, 0.17);
    border: none;
    color: #9B9B9B;
    font-family: "RobotoMedium", sans-serif;
 	/*border-radius: 0px 4px 4px 0px ;*/
        /*border-top-left-radius: 0;*/
    /*border-bottom-left-radius: 0;*/

        /*padding: 6px 12px;*/
    font-size: 14px;
 	height: 2px;
    line-height: 1;
    /*color: #555;*/
    text-align: center;
    /*background-color: #eee;*/
    /*border: 1px solid #ccc;*/
    border-radius: 4px;

/*        width: 1%;
    white-space: nowrap;
    vertical-align: middle;

        display: table-cell;

            box-sizing: border-box;

                border-collapse: separate;*/
	}
</style>
<div class="hidden">
	<div id="pt-creation-popup" class="popup">
		<form id="pt-creation-form" data-toggle="validator" class="main-form">
			<div class="top-panel">
				<div class="popup-title">Parking type creation</div>
				<button type="button" class="close-popup"><i class="material-icons">close</i></button>
			</div>
			<div class="body-panel">
				<div class="row">
					<div class="col-sm-4 form-group has-feedback">
						<label style="display: table-row;">Parking name:</label>
						<input name="name" type="text" placeholder="Monthly" required class="form-control parkingNameInput">
						<div class="help-block with-errors"></div>
					</div>
					<div class="col-sm-4 form-group has-feedback" style="    display: table;width: 120px">
						<label style="display: table-row;white-space:nowrap;">Parking rate:</label>
						<input name="rate" type="number" min="0" placeholder="25%" required class="form-control parkingRateInput" style=" border-radius: 4px 0 0 4px;">
							<div class="input-group-addon">%</div>
						<div class="help-block with-errors"></div>
					</div>
					<div class="col-sm-4 form-group has-feedback" style="    display: table;width: 120px">
						<label style="display: table-row; white-space:nowrap; ">Parking duration:</label>
						<input name="period" type="number" min="1" max="365" placeholder="30d" required class="form-control parkingPeriodInput" style=" border-radius: 4px 0 0 4px; ">
							<div class="input-group-addon">d</div>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="botton-panel">
				<button type="button" class="back-button close-popup">Close</button>
				<button type="submit" class="button-bordered parking-confirm-button" id="parking-confirm-button">Confirm</button>
			</div>
		</form>
	</div>
</div>