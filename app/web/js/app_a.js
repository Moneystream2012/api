/**
 * Another one file.
 *
 * @var app App setting.
 */


function changePassword()
{
	var data = {
		"currentPassword":$("#current-password").val(),
		"newPassword":$("#new-password").val(),
		"confirmPassword":$("#confirm-new-password").val(),
		"_csrf": app._csrf
	};

	$.post("?r=user/setting/change-password-process", data, function(response) {
		try {
			if (response.status) notifier.success('Password сhanged');
			else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}

function notificationEmail()
{
	var data = {
		"notificationEmail":$("#notification-email").val(),
		"_csrf": app._csrf
	};
	
	$.post("?r=user/setting/email-notification-process", data, function(response) {
		try {
			if (response.status) notifier.success('Email notification сhanged');
			else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}

function enableNotificationEmail()
{
	var data = {
		"enableNotificationEmail": +$("#enable-notification-email").prop('checked'),
		"_csrf": app._csrf
	};
	
	$.post("?r=user/setting/email-enable-notification-process", data, function(response) {
		try {
			if (response.status){
				if(+$("#enable-notification-email").prop('checked')) {notifier.success('Email notification enabled.');
				}else{ notifier.success('Email notification disabled.'); }
			}
			else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}


var setListenerForConfirmation = true;

function notificationInfoSlide(id)
{
	$('#notification-content-box-'+id).slideToggle("slow");
}
	
$('#buttonNewNotification').click(function() {
	window.title = $('#notification-title').val();
	window.content = $('#notification-content').val();
	if (!title) return;

	if (setListenerForConfirmation)
	{
		$("#confirm").click(function()
		{
			$.post('?r=admin/notification/add-notification',
				window.data,
				handleNotidicationResponse
			);
		});
		setListenerForConfirmation = false;
	}
		
	var id = getParameterByName('id');
	if (!parseInt(id)) id = 0;

	window.data = {
		"title":title,
		"content":content,
		"id":id,
		"_csrf":app._csrf
	};

	function handleNotidicationResponse(response)
	{
		if (response.status = 1)
		{
			$("#notification-title").val(""); 
			$("#notification-content").val("");
		} else {
			response.error}
	}
});


var editParkingTypeId = 0;
var rateParkingType = 0;

$(document).on('click', "[parking-type-id]", function() {
	editParkingTypeId = $(this).attr('parking-type-id');
	rateParkingType = $('#parking-rate-value-'+editParkingTypeId).attr('rate');
	$('.parking-rate-item' + '[parking-rate-item-id="' + editParkingTypeId + '"]').addClass("active");
	$('.parking-rate-input' + '[parking-rate-input-id="' + editParkingTypeId + '"]').val(rateParkingType);
});

$(app.saveParkingTypeButton).click(function() {
	rateParkingType = $('.parking-rate-input' + '[parking-rate-input-id="' + editParkingTypeId + '"]').val();
	$.post('/?r=admin/parking-type/edit', {
		"id": editParkingTypeId,
		"rate": rateParkingType,
		"_csrf": app._csrf
	}, function(response) {
		try {
			if (response.status) {
				notifier.success(response.data);
				$('#parking-rate-value-'+editParkingTypeId).val(rateParkingType+'%'); 
				$('#parking-rate-value-'+editParkingTypeId).html(rateParkingType+'%'); 
			} else
				notifier.error(response.error);
		} catch (e) {
			notifier.error('Catch: Undefined error');
			throw e;
		}
		closeEditPT(editParkingTypeId);
	}).fail(function(e) {
		console.log("Error: " + e.statusText);
	});
	// cleanNewParkingData();
});

var currentRotate = 0;
$( "#refreshBalance" ).click(function() {
	currentRotate += 360;
	$(this).css("transform","rotate("+currentRotate+"deg)");
	$.post('/?r=user/refresh-balance', {
		"_csrf": app._csrf
	}, function(response) {
		try {
			if (response.status) {
				var available = parseFloat(response['data']['available']).toFixed(8);
				var parked = parseFloat(response['data']['parked']).toFixed(8);

				$('#available').html(available.toString()+" MNX");
				$('#parked').html(parked+' MNX'); 
				$('#balance').html(parseFloat(response['data']['balance']).toFixed(8)+' MNX'); 
			} else
				notifier.error(response.error);
		} catch (e) {
			notifier.error('Catch: Undefined error');
			throw e;
		}
	}).fail(function(e) {
		console.log("Error: " + e.statusText);
	});

});

function subscribeEmail()
{
	var data = {
		"emailSubscribe":$("#email-subscribe").val(),
		"_csrf": app._csrf
	};
	
	$.post("?r=site/add-subscribe", data, function(response) {
		try {
			// console.log(response);
			if (response.status) {
				notifier.success('Add your email for subscribe');
				$("#email-subscribe").val('');
			} else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}


function searchUserByAddress()
{
	var data = {
		"userAddress":$("#userAddress").val(),
		"_csrf": app._csrf
	};
	
	$.post("?r=admin/user/search-user-by-address", data, function(response) {
		try {
			// console.log(response);
			if (response.status) {
				// notifier.success('Add your email for subscribe');
				// $("#email-subscribe").val('');
				// console.log(response);
				 window.location.href = "/?r=admin%2Fuser%2Fview&id="+response.data['id'];
			} else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}

function searchRoomByAddress()
{
	var data = {
		"userAddress":$("#userAddress").val(),
		"_csrf": app._csrf
	};
	
	$.post("?r=admin/support/search-user-by-address", data, function(response) {
		try {
			// console.log(response);
			if (response.status) {
				// notifier.success('Add your email for subscribe');
				// $("#email-subscribe").val('');
				// console.log(response['data']);
				 window.location.href = "/?r=admin%2Fsupport%2Froom&id="+response['data'];
			} else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}

function closeRoom(id)
{
	var data = {
		"id":id,
		"_csrf": app._csrf
	};

	$.post("?r=admin/support/close-room", data, function(response) {
		try {
			// console.log(response);
			if (response.status) {
				$("#room-"+id).remove();
				notifier.success('Room closed');

			} else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}

function changePayoutServerAddress()
{
	var data = {
		"newPayoutAddress":$("#new-payout-address").val(),
		"_csrf": app._csrf
	};

	$.post("?r=admin/setting/change-payout-server-address", data, function(response) {
		try {
			if (response.status) {
				notifier.success('Payout server address сhanged');
				console.log(response);
			}
			// else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}


function changePayoutServerAddress()
{
	var data = {
		"newPayoutAddress":$("#new-payout-address").val(),
		"_csrf": app._csrf
	};

	$.post("?r=admin/setting/change-payout-server-address", data, function(response) {
		try {
			if (response.status) {
				notifier.success('Payout server address сhanged');
				$("#new-payout-address").val('');
				// console.log(response);
			}
			 else notifier.error(response.error );
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}

function changeBankChangeAddress()
{
	var data = {
		"newBankChangeAddress":$("#new-change-address").val(),
		"_csrf": app._csrf
	};

	$.post("?r=admin/setting/change-bank-change-address", data, function(response) {
		try {
			if (response.status) {
				notifier.success('Bank сhange address сhanged');
				$("#new-change-address").val('');

				// console.log(response);
			}
			else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}

function changeQuantityStringsCron()
{
	var data = {
		"newQuantityStringsCron":$("#new-quantity-strings-cron").val(),
		"_csrf": app._csrf
	};

	$.post("?r=admin/setting/change-quantity-strings-cron", data, function(response) {
		try {
			if (response.status) {
				notifier.success('Quantity strings cron сhanged');
				$("#new-quantity-strings-cron").val('');
				// console.log(response);
			}
			 else notifier.error(response.error || 'System error');
		} catch (e) {
			console.log(e);
		}
	}).fail(function(e) {
		notifier.error(e.responseJSON.error);
		console.log(e);
	});
}