Array.prototype.remove = function() {
	var what, a = arguments, L = a.length, ax;
	while (L && this.length) {
		what = a[--L];
		while ((ax = this.indexOf(what)) != -1)
			this.splice(ax, 1);
	}
	return this;
}

var app = {
	refreshInterval: 5 * 1000,

	userDashboardParkingListId: '#user-dashboard-parking-list',
	userDashboardPayoutListId: '#user-dashboard-payout-list',

	selectedParkingType: {},
	// parkingTypeInfoId: '#parking-type-info',
	// parkingTypeInfoConfirmedId: '#parking-type-info-confirmed',
	newParkingAmountFieldId: '#inputAmount',
	newParkingProfitValueId: '#new-parking-profit-value',
	newParkingConfirmPopupId: '#parking-confirmation-popup',
	newParkingTypeTitleConfirmId: '#new-parking-type-title-confirm',
	newParkingTypeRateConfirmId: '#new-parking-type-rate-confirm',
	newParkingAmountConfirmId: '#new-parking-amount-confirm',
	newParkingExpectedConfirmId: '#new-parking-expected-confirm',
	cancelParkingButton: '.cancel-parking-link',
	cancelParkingConfirmButton: '#cancel-parking-confirm-button',
	cancelParkingConfirmCloseButton: '#cancel-parking-confirm-close-button',
	
	_csrf: $('meta[name="csrf-token"]').attr('content'),
};



$(document).ready(function() {
	refreshUserDashboardParkingList();
	refreshUserDashboardPayoutList();
	refreshUserNotification();
	reloadPopups();
	reloadCancelParkingButtonHandler();
	setDefaultParkingType();

	// New parking listeners.
	// $('.park_button').on('click', setParkingType);
	$('#validate-new-parking-data-button').on('click', validateNewParkingData);
	$('#create-new-parking-button').on('click', addNewParking);
	$(app.newParkingAmountFieldId).on('change paste keyup', calculateParkingProfit);
	$(app.cancelParkingConfirmButton).on('click', cancelParking);
});



////////////////////////////
// Notification manager ///
//////////////////////////
var notifier = {
	defaultDelay: 8,
	success: function(text, delay) {
		if (delay == undefined)
			delay = this.defaultDelay;
		alertify.success(text, delay * 1000);
	},
	error: function(text, delay) {
		if (delay == undefined)
			delay = this.defaultDelay;
		alertify.error(text, delay * 1000);
	},
	info: function(text, delay) {
		if (delay == undefined)
			delay = this.defaultDelay;
		alertify.log(text, '', delay * 1000);
	},
	log: function(e) {
		console.log(e);
	}
};




////////////////////////////
// Refreshing parkings ////
// on dashboard //////////
/////////////////////////
/**
 * Refresh parking list on dashboard page.
 */
function refreshUserDashboardParkingList(once) {
	// Init list
	if (!window.userDashboardParkingList)
		window.userDashboardParkingList = [];

	if ($(app.userDashboardParkingListId).length > 0) {
		$.post('?r=user/parking/get-last', {
			"_csrf": app._csrf
		}, function(response) {
			try {
				if (response.status)
					resolveParkingList(response.data);
				else
					notifier.error(response.error || 'Undefined error');
			} catch (e) {
				notifier.error('Catch: Undefined error');
				throw e;
			}

		}).fail(function(e) { console.log("Error: "+e.statusText); });
		if (!once)
			setTimeout(refreshUserDashboardParkingList, app.refreshInterval);
	}

	function resolveParkingList(parkings) {
		var buffer = window.userDashboardParkingList.slice();
		if (parkings.length == 0) return $(app.userDashboardParkingListId).html('<tr id="parking-list-hint"><td colspan="9" style="width: 945px; height: 150px"><img src="/img/park_ic.png" alt="P" ><br><br><span style="color: #8c8c8c;">No parking yet</span></td></tr>');
		else $('#parking-list-hint').remove();

		parkings.reduce(function(prev, e) {
			if (window.userDashboardParkingList.indexOf(e.id) < 0)
				window.userDashboardParkingList.push(e.id);

			if ($('#user-dashboard-parking-'+e.id).length > 0) {
				buffer.remove(e.id);
				refreshTimer(e.id, e.expired);
				return e;
			}

			if (prev == null) 
				$(app.userDashboardParkingListId).prepend(formParkingItem(e));
			else
				$('#user-dashboard-parking-'+prev.id).after(formParkingItem(e));
			refreshTimer(e.id, e.expired);

			buffer.remove(e.id);
			return e;
		}, null);
		reloadPopups();
		reloadCancelParkingButtonHandler();

		if (buffer.length > 0) {
			buffer.map(function(e) {
				$('#user-dashboard-parking-'+e).remove();
				window.userDashboardParkingList.remove(e);
			});
		}
	}

	function formParkingItem(parking) {
		var row = '<tr id="user-dashboard-parking-'+parking.id+'">';
		row +=		'<td>'+parking.id+'</td>';
		row +=		'<td>'+parking.status+'</td>';
		row +=		'<td>'+parking.created+'</td>';
		row +=		'<td>'+parking.type+'</td>';
		row +=		'<td>'+parking.rate+'%</td>';
		row +=		'<td>'+parseFloat(parking.amount).toFixed(8)+' MNX</td>';
		row +=		'<td>'+parseFloat(parking.return_amount).toFixed(8)+' MNX</td>';
		// data-expire="'+parking.expiredValue+'
		row +=		'<td class="parking_expire_row" ">'+parking.expired+'</td>';
		row +=		'<td>'+(parking.cancel ? '<a href="#cancel-parking-popup" data-id="'+parking.id+'" class="cancel-link cancel-parking-link call-popup">Cancel</a>' : '')+'</td>';
		row +=	'</tr>';

		return row;
	}

	function refreshTimer(parkingId, remain) {
		// if (remain <= 0)
		// 	return '00:00:00';

		// var days = Math.floor(remain/(3600*24));
		// remain -= parseInt(days) * 3600 * 24;
		// var hours = ('0' + (Math.floor(remain/3600))).slice(-2);
		// remain -= parseInt(hours) * 3600;
		// var minutes = ('0' + (Math.floor(remain/60))).slice(-2);

		// var fremain = days+':'+hours+':'+minutes;

		$('#user-dashboard-parking-'+parkingId+' .parking_expire_row').html(remain);
	}
}








////////////////////////////
// Refreshing parkings ////
// on dashboard //////////
/////////////////////////
/**
 * Refresh payout list on dashboard page.
 */
function refreshUserDashboardPayoutList() {
	// Init list
	if (!window.userDashboardPayoutList)
		window.userDashboardPayoutList = [];

	if ($(app.userDashboardPayoutListId).length > 0) {
		$.post('?r=user/payout/get-last', {
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

		}).fail(function(e) { console.log("Error: "+e.statusText); });
		setTimeout(refreshUserDashboardPayoutList, app.refreshInterval);
	}

	function resolvePayoutList(payouts) {
		if (payouts.length == 0) 
			return $(app.userDashboardPayoutListId).html('<tr id="payout-list-hint"><td colspan="9" style="width: 945px; height: 150px"><img src="/img/trans_ic.png" ><br><br><span style="color: #8c8c8c;">No payout yet</span></td></tr>');
		else $('#payout-list-hint').remove();

		var list = payouts.reduce(function(prev, e) {
			return prev + formPayoutItem(e);
		}, '');


		$(app.userDashboardPayoutListId).html(list);
	}

	function formPayoutItem(payout) {
		var row = '<tr  id="user-dashboard-payout-'+payout.id+'">';
		row +=		'<td style="text-align: left; "><a href="http://minexexplorer.com/?r=explorer/tx&hash='+payout.id+'" target="_blank" class="address-link">'+payout.id+'</a></td>';
		row +=		'<td>'+payout.created+'</td>';
		row +=		'<td style="text-align: right;">'+parseFloat(payout.profit).toFixed(8)+' MNX</td>';
		row +=	'</tr>';

		return row;
	}
}



////////////////////////////
// New parking ////////////
//////////////////////////
/**
 * Validate data for new parking.
 */
function validateNewParkingData() {
	// var data = {
	// 	type: app.selectedParkingType.id,
	// 	amount: $(app.newParkingAmountFieldId).val(),
	// 	_csrf: app._csrf
	// };

	// if (!data.amount)
	// 	return notifier.error('Amount must be greater than zero');

	// $.post('?r=user/parking/validate-data', data, function(response) {
	// 	try {
	// 		if (!response.status)
	// 			notifier.error('response.error');
	// 	} catch (e) { notifier.error("Undefined error"); throw e; }
	// }).fail(function(e) { notifier.error((e.responseJSON && e.responseJSON.error) || 'Undefined error'); });
}

/**
 * Add new parking.
 */
var resolveNewParking = true;

function addNewParking() {
	var data = {
		type: app.selectedParkingType.id,
		amount: $(app.newParkingAmountFieldId).val(),
		_csrf: app._csrf
	};
	console.log(app.selectedParkingType.id);
	if (!data.amount) {
		$(app.newParkingConfirmPopupId+' .back-button').click();
		return notifier.error('Amount must be greater than zero');
	}
	if (resolveNewParking == false)
		return;
	resolveNewParking = false;

	$.post('?r=user/parking/add', data, function(response) {
		try {
			if (response.status) {
				refreshUserDashboardParkingList(true);
				$(app.newParkingConfirmPopupId+' .back-button').click();
				setTimeout(function() {resolveNewParking = true;}, 400);
				return notifier.success('Parking successfully added');
			} else {
				$(app.newParkingConfirmPopupId+' .back-button').click();
				setTimeout(function() {resolveNewParking = true;}, 400);
				return notifier.error(response.error || "Undefined error");
			}
		} catch (e) {
			$(app.newParkingConfirmPopupId+' .back-button').click();
			notifier.error("Undefined error");
			setTimeout(function() {resolveNewParking = true;}, 400);
			throw e;
		}
	}).fail(function(e) {
		$(app.newParkingConfirmPopupId+' .back-button').click();
		setTimeout(function() {resolveNewParking = true;}, 400);
		return notifier.error((e.responseJSON && e.responseJSON.error) || 'Undefined error');
	});
}

/**
 * Set selected parking type and put data info forms.
 */
function setParkingType(parkingTypeId) {
	if (!parkingTypeId) return;

	if (window.parkingTypes) {
		if (!window.parkingTypes[parkingTypeId])
			return notifier.error('Parking type not found');

		app.selectedParkingType = window.parkingTypes[parkingTypeId];
		window.selectedParkingTypeId = parkingTypeId;
		if (!$(app.newParkingConfirmPopupId).length)
			return notifier.error('Some elements not found');

		$(app.newParkingTypeTitleConfirmId).html(app.selectedParkingType.title);
		$(app.newParkingTypeRateConfirmId).html('('+app.selectedParkingType.period+'d) '+app.selectedParkingType.rate);
		calculateParkingProfit();
	} else
		return notifier.error('Parking type list not found');
}

/**
 * Make instant determination of profit.
 */
function calculateParkingProfit() {
	var amount = $(app.newParkingAmountFieldId).val();
	var check = new RegExp('([0-9]*[.,][0-9]+|[0-9]+)');
	if (check.test(amount)) {
		var profit = parseFloat((app.selectedParkingType.rate/100)*amount).toFixed(8);
		if (isNaN(profit)) profit = '0.00000000';
		$(app.newParkingProfitValueId).html(profit);
		$(app.newParkingExpectedConfirmId).html(profit);
		$(app.newParkingAmountConfirmId).html(parseFloat(amount).toFixed(8));
	} else {
		$(app.newParkingProfitValueId).html('0.00000000');
		$(app.newParkingExpectedConfirmId).html('0.00000000');
	}
}


/**
 * Set default parking type.
 */
function setDefaultParkingType() {
	if (!window.selectedParkingTypeId) return;

	if (window.parkingTypes) {
		if (!window.parkingTypes[window.selectedParkingTypeId])
			return notifier.error('Parking type not found');

		app.selectedParkingType = window.parkingTypes[window.selectedParkingTypeId];

		$(app.newParkingTypeTitleConfirmId).html(app.selectedParkingType.title);
		$(app.newParkingTypeRateConfirmId).html('('+app.selectedParkingType.period+'d) '+app.selectedParkingType.rate);
		calculateParkingProfit();
	} else
		return notifier.error('Parking type list not found');
}







/////////////////////////
// Cancel parking //////
///////////////////////
/**
 * Cancel certain parking preparation.
 */
function cancelParkingPrepare() {
	var parkingId = $(this).attr('data-id') || 0;
	if (!parkingId) return notifier.error('Parking id not provided');

	window.cancelParkingId = parkingId;
	return true;
}

/**
 * Cancel certain parking.
 */
function cancelParking() {
	if (!window.cancelParkingId)
		return notifier.error('Parking id not provided');

	var data = {
		"id": window.cancelParkingId,
		"_csrf": app._csrf
	};

	$.post('?r=user/parking/cancel', data, function(response) {
		if (response.status) {
			$(app.cancelParkingConfirmCloseButton).click();
			refreshUserDashboardParkingList(true);
			return notifier.success('Parking was canceled');
		} else
			return notifier.error(response.error || 'Undefined error');
	}).fail(function(e) {
		return notifier.error(e.responseJSON.error || 'Undefined error');
	});
}










////////////////////////
// Notifications //////
//////////////////////
/**
 * Refresh notification on Notification page.
 */
function refreshUserNotification() {
	// Init list
	
	if (!window.userNotification)
		window.userNotification = [];
	// if(window.userNotification1)
		// window.userNotification = window.userNotification1;

	if ($('#notifications-list').length > 0) {
		var page = getParameterByName('page');
		if (!parseInt(page)) page = 1;
		
		$.post('?r=user/notification/get-last', {
			"_csrf": app._csrf,
			"page": page
		}, function(response) {
			try {
				if (response.status) {
					resolveNotification(response.data);
				} else
					console.log(response.error || 'Undefined error');
			} catch (e) {
				console.log('Catch: Undefined error: ');
				throw e;
			}

		}).fail(function(e) { console.log("Error: "+e.statusText); });
		setTimeout(refreshUserNotification, app.refreshInterval);
	}

	function resolveNotification(notifications) {
		var buffer = window.userNotification.slice();
		if (notifications.length == 0) return $('#notifications-list').html('');

		notifications.reduce(function(prev, e) {
			if (window.userNotification.indexOf(e.id) < 0)
				window.userNotification.push(e.id);
			// console.log(window.userNotification.indexOf(e.id));

			if ($('#notification-wrapper-'+e.id).length > 0) {
				buffer.remove(e.id);
				return e;
			}

			if (prev == null) {
				$('#notifications-list').prepend(formNotificationItem(e));
				
			} else {
				$('#notification-wrapper-'+prev.id).after(formNotificationItem(e));
			}
			// notifier.success('<a href="http://l.minexbank.com/index.php?r=user%2Fnotification%2Findex" style="text-decoration: none; color:#25282C; ">You have new notification!</a>');

			buffer.remove(e.id);
			return e;
		}, null);

		app_v_registerNotificationItemClick();
		if (buffer.length > 0) {
			buffer.map(function(e) {
				$('#notification-wrapper-'+e).remove();
				window.userNotification.remove(e);
			});
		}
	}



	function formNotificationItem(notification) {
		// console.log(notification);
		// var row = '<tr id="user-notification-'+notification.id+'">';
		// row +=		'<td>'+notification.title+'</td>';
		// row +=		'<td>'+notification.created+'</td>';
		// row +=		'<td><button type="button" class="view pull-right" data-dismiss="modal" onclick="notificationInfoPopup('+notification.content+');" ">view</button></td>';
		// row +=		'<td><button type="button" class="close" data-dismiss="alert" onclick="cancelNotification('+notification.id+');" id="button-for-cancel">&times;</button></td>';
		// row +=	'</tr>';
	var row ='<div  id="notification-wrapper-'+notification.id+'" class="panel panel-default '+(notification.seen == false ? 'new-notification' : '')+'" '+(notification.seen == false ? 'unseen-id="'+notification.id+'"' : ''  )+'>';
	row +=	'	<div class="panel-heading ">';
	row +=	'		<a href="#notification-'+notification.id+'" data-toggle="collapse" aria-expanded="true" class="spoiler-trigger collapsed">';
	row +=	'			<div class="clearfix">';
	row +=	'				<div class="title">'+notification.title+'</div>';
	row +=	'				<div class="date-time">'+notification.created+ '</div>';
	row +=	'			</div>';
	row +=	'			<i class="material-icons">keyboard_arrow_down</i>';
	row +=	'		</a>';
	row +=	'	</div>';
	row +=	'	<div id="notification-'+notification.id+'" class="panel-collapse collapse">';
	row +=	'		<div class="panel-body">';
	row +=	'			<table class="table notifications-table">';
	row +=	'				<tbody>';
	row +=	'					<tr>';
	row +=	'						<td>'+notification.content+'</td>';
	row +=	'					</tr>';
	row +=	'				</tbody>';
	row +=	'			</table>';
	row +=	'		</div>';
	row +=	'	</div>';
	row +=	'	</div>';


		return row;
	}
}


/**
 * Reload popups.
 */
function reloadPopups() {
	// Popup
	$('.call-popup').magnificPopup({
		type:"inline",
		mainClass: 'mfp-fade',
		showCloseBtn: false,
		closeBtnInside: true,
		removalDelay: 300
	});

	$('.close-popup').click(function() {
		$.magnificPopup.close();
	});
}

/**
 * Reload cancel parking button.
 */
function reloadCancelParkingButtonHandler() {
	$(app.cancelParkingButton).off('click.cancelHandler');
	$(app.cancelParkingButton).on('click.cancelHandler', cancelParkingPrepare);
}




/**
 * Function for parsing get-query.
 * usage: 
 * - query string: ?foo=lorem&bar=&
 * - getParameterByName('foo'); // "lorem"
 * - getParameterByName('bar'); // "" (present with empty value)
 */
function getParameterByName(name, url) {
	if (!url) url = window.location.href;
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}