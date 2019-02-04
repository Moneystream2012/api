/**
 * Another one file.
 *
 * @var app App settings.
 */
app.userPayoutsPayoutListId = '#user-payouts-payout-list';

app.creationAddPTModal = '#pt-creation-popup';
app.confirmationAddPTModal = '#parking-confirmation-popup';
app.confirmationPTModal = '#confirmation-green-popup';

app.changeParkingTypeButton = '.admin-change-parking-type';
app.nextBtnAddNewPT = '#parking-next-button';
app.confirmBtnAddNewPT = '#parking-confirm-button';
app.backBtnAddNewPT = '#parking-back-button';

app.saveParkingTypeButton = '#save-parking-type-button';

app.parkingNameInput = '.parkingNameInput';
app.parkingRateInput = '.parkingRateInput';
app.parkingPeriodInput = '.parkingPeriodInput';

app.parkingNameText = '#parkingNameText';
app.parkingRateText = '#parkingRateText';
app.parkingDurationText = '#parkingDurationText';


$(document).ready(function() {
	refreshUserPayoutsPayoutList();
});

//////////////////////////////////
//adding and editing ParkingTypes 
//////////////////////////////////


/*
 * step confirmation on add new type modal  
 */

/*
 *Post to admin/Parking
 */
$(app.confirmBtnAddNewPT).click(function() {
	var inputsValidate = checkInputsBeforeSubmit(app.creationAddPTModal);
	if (inputsValidate !== 1) {
		notifier.error(inputsValidate);
		return false;
	}					
	$.post("/?r=admin/parking-type/add", {
		"title": $(app.parkingNameInput).val(),
		"rate": $(app.parkingRateInput).val(),
		"period": $(app.parkingPeriodInput).val(),
		"_csrf": app._csrf
	}, function(response) {
		try {
			if (response.status) {
				notifier.success(response.data);
			} else {
				notifier.error(response.data);
			}
		} catch (e) {
			notifier.error('Catch: Undefined error');
			throw e;
		}
		/*cleaning inputs after post query*/
		$(app.parkingPeriodInput).val('');
		$(app.parkingRateInput).val('');
		$(app.parkingPeriodInput).val('');
	});
	return false;
});

/*
 * Chek inputs 
 * @modal string
 * return 1 or error msg 
 */
function checkInputsBeforeSubmit(modal) {
	if ($(app.parkingNameInput).val() == '' || $(app.parkingRateInput).val() == '' || $(app.parkingPeriodInput).val() == '') {
		return "Fill in all the fields please";
	} else {
		if (!new RegExp(/^[a-zA-Z]+$/).test($(modal + ' ' + app.parkingNameInput).val())) {
			return "Incorrect Parking Name, try again";
		}
		if ($(modal + ' ' + app.parkingRateInput).val() < 0) {
			return "Parking Rate must be more than 0";
		}
		if ($(modal + ' ' + app.parkingPeriodInput).val() < 1) {
			return "Duration must be more than 1";
		}
	}
	return 1;
}

$(document).on('click', "[parking-cancel-id]", function() {
	closeEditPT($(this).attr('parking-cancel-id'));
});


function closeEditPT(editId){
	$('.parking-rate-item' + '[parking-rate-item-id="' + editId + '"]').removeClass("active");
}

//////////////////////////////////
//////////////////////////////////


/**
 * Refresh payout list on payout page.
 */
function refreshUserPayoutsPayoutList() {

	if ($(app.userPayoutsPayoutListId).length > 0) {
		$.post('?r=user/payout/get-certain', {
			"page": getParameterByName('page'),
			"_csrf": app._csrf
		}, function(response) {
			try {
				if (response.status)
					resolvePayoutList(response.data);
				else
					notifier.error(response.error || 'Undefined error');
			} catch (e) {
				notifier.error('Catch: Undefined error');
				throw e;
			}
		}).fail(function(e) {
			console.log("Error: " + e.statusText);
		});
		console.log(getParameterByName('page'));
		setTimeout(refreshUserPayoutsPayoutList, app.refreshInterval);
	}

	function resolvePayoutList(payouts) {
		if (payouts.length == 0) 
			return $(app.userDashboardPayoutListId).html('<tr id="payout-list-hint"><td colspan="9" style="width: 945px; height: 150px"><img src="/img/trans_ic.png" ><br><br><span style="color: #8c8c8c;">No payout yet</span></td></tr>');
		else $('#payout-list-hint').remove();

		var list = payouts.reduce(function(prev, e) {
			return prev + formPayoutItem(e);
		}, '');

		$(app.userPayoutsPayoutListId).html(list);
	}

	function formPayoutItem(payout) {
		var row = '<tr id="user-dashboard-payout-' + payout.id + '">';
		row += '<td style="text-align: left; "><a href="http://minexexplorer.com/?r=explorer/tx&hash=' + payout.id + '" target="_blank" class="address-link">' + payout.id + '</a></td>';
		row += '<td>' + payout.created + '</td>';
		row += '<td style="text-align: right; ">' + parseFloat(payout.profit).toFixed(8) + ' MNX</td>';
		row += '</tr>';

		return row;
	}
}

/*
* setnding message on "enter"-key down
*/
$('#chat-message').on('keydown', function(event){
	if (event.keyCode === 13) {
		if(!event.shiftKey){
            sendMessage();
        }
	}
}); 

/*
* Copy in buffer btn
*/
$(document).on('click', "#copy-address-btn", function() {
	var result = copyToClipboard($('#user-address-span').text());
	if(result == true)
		notifier.success('Successfully copied');
});

/*copyToClipboardfunction for native js*/
function copyToClipboard(text) {
    if (window.clipboardData && window.clipboardData.setData) {
        // IE specific code path to prevent textarea being shown while dialog is visible.
        return clipboardData.setData("Text", text); 

    } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
        var textarea = document.createElement("textarea");
        textarea.textContent = text;
        textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in MS Edge.
        document.body.appendChild(textarea);
        textarea.select();
        try {
            return document.execCommand("copy");  // Security exception may be thrown by some browsers.
        } catch (ex) {
            console.warn("Copy to clipboard failed.", ex);
            return false;
        } finally {
            document.body.removeChild(textarea);
        }
    }
}