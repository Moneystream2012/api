/**
 * Activation part.
 *
 * @var app
 */

if (!app.activation) app.activation = {};

app.activation.confirmActivationButtonId = '#confirm-activation-button';
app.activation.closeButtonId = '#close-activation-info-button';
app.activation.isCheckingStateRuns = false;

app.activation.checkState = function(e, ignoreChecking) {
	if (!ignoreChecking) ignoreChecking = false;

	if (!app.activation.isCheckingStateRuns || ignoreChecking)
		app.activation.isCheckingStateRuns = true;
	else if (!ignoreChecking) return;

	$.post('/?r=user/check-activation', {"_csrf":app._csrf}, function(response) {
		try {
			if (response.status) {
				if (!response.data)
					setTimeout(function() {app.activation.checkState('event', true);}, app.refreshInterval);
				else {
					$(app.activation.closeButtonId).click();
					notifier.success('Account is active now');
					setTimeout(function() {window.location.reload();}, 2000);
				}
			} else {
				$(app.activation.closeButtonId).click();
				notifier.error(response.error || 'System error');
			}
		} catch (e) {
			$(app.activation.closeButtonId).click();
			notifier.error(e.message);
		}
	}).fail(function(e) { $(app.activation.closeButtonId).click(); notifier.error((e.responseJSON && e.responseJSON.error) || 'Undefined error'); });
};

app.activation.registerClicks = function() {
	$(app.activation.confirmActivationButtonId).off('click.activation');
	$(app.activation.confirmActivationButtonId).on('click.activation', app.activation.checkState);
};

$(document).ready(function() {
	app.activation.registerClicks();
});