/**
 * Another one file.
 *
 * @var app App settings.
 */

app.userNotificationItem = '.new-notification';
app.userNotificationItemClass = 'new-notification';
app.userNotificationUnseenAttr = 'unseen-id';
app.userParkingListId = '#user-parking-list';
app.userParkingListItemPrefix = '#user-parking-';

app.settings = {
	TwoFA: {
		refreshButtonId: '#setting-refresh-2fa-button',
		switchButton: '#switch-2fa-button',
		otpCodeFieldId: '#twofa-otp-code',
		wrapperBlockId: '#twofa-inner-block',
		secretId: '#secret-code',
		qrImageId: '#qr-code-image',
		refreshFunction: function() {
			var data = {
				'_csrf':app._csrf
			};
			$.post('/?r=user/setting/get-new-2fa-data', data, function(response) {
				try {
					if (response.status) {
						$(app.settings.TwoFA.secretId).html(response.data.secret);
						$(app.settings.TwoFA.qrImageId).attr('src', response.data.qrCodeUrl);
						notifier.success('2FA data refreshed');
					} else
						notifier.error(response.error || 'Undefined error with loading new 2FA data');
				} catch (e) {
					notifier.error('Exception');
				}
			}).fail(function(e) { notifier.error(e.statusText); });
			
			return false;
		},
		switch2FAFunction: function() {
			var data = {
				'_csrf': app._csrf,
				'code': $(app.settings.TwoFA.otpCodeFieldId).val()
			};
			$.post('/?r=user/setting/switch-2fa', data, function(response) {
				try {
					if (response.status) {
						if (response.data.state) {
							app.settings.TwoFA.clean2FAData();
							notifier.success('2FA enabled');
						} else {
							app.settings.TwoFA.set2FAData(response.data);
							notifier.success('2FA disabled');
						}
					} else
						notifier.error(response.error || 'Undefined error with loading new 2FA data');
				} catch (e) {
					notifier.error('Exception');
				}
			}).fail(function(e) { notifier.error(e.responseJSON.error || e.statusText); });

			return false;
		},
		clean2FAData: function() {
			var newContent = '<p>Enter the code from Google Authenticator to disable 2FA</p>';
			newContent +=	'<form class="main-form">';
			newContent +=	'<input id="twofa-otp-code" type="text" name="twofa-code" placeholder="OTP code" required class="form-control" />';
			newContent +=	'</form>';
			$(app.settings.TwoFA.wrapperBlockId).html(newContent);
		},
		set2FAData: function(data) {
			var newContent = '<p>1. Install Google Authenticator</p>';
			newContent +=	'<ul class="links">';
			newContent +=	'	<li><a href="#">iPhone iOS</a></li>';
			newContent +=	'	<li><a href="#">Android</a></li>';
			newContent +=	'</ul>';
			newContent +=	'<p>2. Scan the QR-code or enter the code using Google Authenticator</p>';
			newContent +=	'<div class="p-code">';
			newContent +=	'	<div class="qr-code-img"><img src="'+data.qrCodeUrl+'" alt="alt" id="qr-code-image" /></div>';
			newContent +=	'	<div class="qr-code" id="secret-code">'+data.secret+'</div>';
			newContent +=	'</div>';
			newContent +=	'<a href="#" class="cancel-button", id="setting-refresh-2fa-button">Refresh</a>';
			newContent +=	'<br>';
			newContent +=	'<p>3. Enter the code from Google Authenticator</p>';
			newContent +=	'<form class="main-form">';
			newContent +=	'	<input id="twofa-otp-code" type="text" name="twofa-code" placeholder="OTP code" required class="form-control" />';
			newContent +=	'</form>';
			$(app.settings.TwoFA.wrapperBlockId).html(newContent);
			app_v_registerClicks();
		}
	}
};


$(document).ready(function() {
	app_v_registerNotificationItemClick();
	app_v_registerClicks();
	
	app_v_refreshUserParkingList();
});


////////////////////////
// Notification ///////
//////////////////////
/**
 * Register click event.
 */
function app_v_registerNotificationItemClick() {
	$(app.userNotificationItem).off('click.notification');
	$(app.userNotificationItem).on('click.notification', app_v_markAsSeen);
}

/**
 * Register some click events.
 */
function app_v_registerClicks() {
	$(app.settings.TwoFA.refreshButtonId).off('click');
	$(app.settings.TwoFA.refreshButtonId).on('click', app.settings.TwoFA.refreshFunction);
	$(app.settings.TwoFA.switchButton).off('click');
	$(app.settings.TwoFA.switchButton).on('click', app.settings.TwoFA.switch2FAFunction);
}

/**
 * Mark notification as seen.
 */
function app_v_markAsSeen() {
	var item = this;
	var unseenId = $(item).attr(app.userNotificationUnseenAttr);
	if (!unseenId) return;

	var data = {
		'id': unseenId,
		'_csrf': app._csrf
	};


	$.post('/?r=user/notification/set-seen', data, function(response) {
		try {
			if (response.status) {
				notifier.log(item);
				$(item).removeClass(app.userNotificationItemClass);
				$(item).removeAttr(app.userNotificationUnseenAttr);
			} else
				return notifier.error(response.error);
		} catch (e) {
			return notifier.error('Error: ' + e.statusText);
		}
	}).fail(function(e) {
		return notifier.error((e.responseJSON && e.responseJSON.error) || 'Undefined error');
	});
}



////////////////////////////
// Refreshing parkings ////
// on dashboard //////////
/////////////////////////
/**
 * Refresh parking list on dashboard page.
 */
function app_v_refreshUserParkingList(once) {
	// Init list
	if (!window.userParkingList)
		window.userParkingList = [];

	if ($(app.userParkingListId).length > 0) {
		var page = getParameterByName('page');
		if (!parseInt(page)) page = 1;
		var status = getParameterByName('status');

		if (status == null ) status = -1;
		$.post('?r=user/parking/get-list-ajax', {
			"_csrf": app._csrf,
			"page": page,
			"status": status
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
			setTimeout(app_v_refreshUserParkingList, app.refreshInterval);
	}

	function resolveParkingList(parkings) {
		var buffer = window.userParkingList.slice();
		if (parkings.length == 0) return $(app.userParkingListId).html('<tr id="parking-list-hint"><td colspan="9" style="width: 945px; height: 150px"><img src="/img/park_ic.png" alt="P" ><br><br><span style="color: #8c8c8c;">No parking yet</span></td></tr>');
		else $('#parking-list-hint').remove();

		parkings.reduce(function(prev, e) {
			if (window.userParkingList.indexOf(e.id) < 0)
				window.userParkingList.push(e.id);

			if ($(app.userParkingListItemPrefix+e.id).length > 0) {
				buffer.remove(e.id);
				refreshTimerParking(e.id, e.expired);
				checkCancel(e.id, e.cancel);
				return e;
			}

			if (prev == null)
				$(app.userParkingListId).prepend(formParkingItem(e));
			else
				$(app.userParkingListItemPrefix+prev.id).after(formParkingItem(e));
			refreshTimerParking(e.id, e.expired);
			checkCancel(e.id, e.cancel);

			buffer.remove(e.id);
			return e;
		}, null);
		reloadPopups();
		reloadCancelParkingButtonHandler();

		if (buffer.length > 0) {
			buffer.map(function(e) {
				$(app.userParkingListItemPrefix+e).remove();
				window.userParkingList.remove(e);
			});
		}
	}

	function formParkingItem(parking) {
		var row = '<tr id="user-parking-'+parking.id+'">';
		row +=		'<td>'+parking.id+'</td>';
		row +=		'<td class="status-prop">'+parking.status+'</td>';
		row +=		'<td>'+parking.created+'</td>';
		row +=		'<td>'+parking.type+'</td>';
		row +=		'<td>'+parking.rate+'%</td>';
		row +=		'<td>'+parseFloat(parking.amount).toFixed(8)+' MNX</td>';
		row +=		'<td>'+parseFloat(parking.amount * (parking.rate/100/365 + 1)).toFixed(8)+' MNX</td>';
		// data-expire="'+parking.expiredValue+'"
		// 00:00:00
		row +=		'<td class="expired-prop parking_expire_row">'+(parking.expired < 0 ? 'Pending' : parking.expired )+'</td>';
		row +=		'<td class="control-prop">'+(parking.cancel ? '<a href="#cancel-parking-popup" data-id="'+parking.id+'" class="cancel-link cancel-parking-link call-popup">Cancel</a>' : '')+'</td>';
		row +=	'</tr>';
		// console.log(parking.expired);

		return row;
	}

	function refreshTimerParking(parkingId, remain) {
		// if (remain <= 0)
		// 	return '00:00:00';

		// var days = (Math.floor(remain/(3600*24)));
		// var hours = ('0' + (Math.floor(remain/3600))).slice(-2);
		// var minutes = ('0' + (Math.ceil(remain/60))).slice(-2);

		// console.log(status);

		// var fremain = days+':'+hours+':'+minutes;

		// if(days <= 0 || hours <= 0 || minutes <= 0 )
		$('#user-parking-'+parkingId+' .parking_expire_row').html(remain);
	}

	function checkCancel(parkingId, cancel) {
		if (!cancel)
			$('#user-parking-'+parkingId+' .control-prop').html('');
	}
}