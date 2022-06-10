document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	var cookieModal = new bootstrap.Modal(
		document.getElementById('js-modal-cookies'),
		{
			keyboard: false,
		}
	);

	var btnTriggerCookiePolicy = document.getElementById(
		'js-show-cookie-policy'
	);
	if (btnTriggerCookiePolicy) {
		btnTriggerCookiePolicy.addEventListener('click', function () {
			cookieModal.show();
			document
				.getElementById('js-cookie-notice-popup')
				.classList.remove('ms-remove');
		});
	}

	function allowAnalyticsCookie() {
		Cookies.set('gdpr-analytics', 'Accepted', { expires: 365 * 1 });
	}
	function allowMarketingCookie() {
		Cookies.set('gdpr-marketing', 'Accepted', { expires: 365 * 1 });
	}
	function allowComplianceCookie() {
		Cookies.set('gdpr-compliance', 'Accepted', { expires: 365 * 1 }); // da mu se popup više ne prikazuje
	}
	function removeAnalyticsCookie() {
		Cookies.remove('gdpr-analytics');

		var cookies = document.cookie.split(';');
		for (var i = 0; i < cookies.length; i++) {
			var cookie = cookies[i];
			var eqPos = cookie.indexOf('=');
			var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
			//console.log('Briše se ', name, name.trim().startsWith('_ga', 0));
			// Obriši kolačiće koji počinju s "_ga"
			if (name.trim().startsWith('_ga', 0)) {
				deleteCookieByName(name);
				deleteCookieByName(name.trim());
			}
		}
	}
	function removeMarketingCookie() {
		Cookies.remove('gdpr-marketing');
	}
	function triggerReload() {
		window.location.reload();
	}
	// briše kolačić tako da ga postavi na prošlo vrijeme
	function deleteCookieByName(cookieName) {
		document.cookie =
			cookieName +
			'=;' +
			'expires=Thu, 01-Jan-1970 00:00:01 GMT;' +
			'path=' +
			'/;' +
			'domain=' +
			window.location.host +
			';' +
			'secure=;';
		//console.log('Deleting... ', cookieName);
	}

	// Modal - prihvati sve
	var btnModalSaveChanges = document.getElementById(
		'js-modal-btn-save-changes'
	);
	btnModalSaveChanges.addEventListener('click', function () {
		triggerReload();
	});

	// Modal - prihvati sve
	var btnModalAllowAllCookies = document.getElementById(
		'js-modal-btn-allow-all'
	);
	btnModalAllowAllCookies.addEventListener('click', function () {
		allowAnalyticsCookie();
		allowMarketingCookie();
		allowComplianceCookie();
		triggerReload();
	});

	// Modal - prihvati neophodno
	var btnModalAllowRequiredCookies = document.getElementById(
		'js-modal-btn-accept-required'
	);
	btnModalAllowRequiredCookies.addEventListener('click', function () {
		removeAnalyticsCookie();
		removeMarketingCookie();
		allowComplianceCookie();
		triggerReload();
	});

	// Modal input - prihvati analytics
	var inputModalAllowAnalyticsCookies = document.getElementById(
		'js-modal-input-cookie-analytics'
	);
	inputModalAllowAnalyticsCookies.addEventListener('change', function () {
		var analyticsCookie = inputModalAllowAnalyticsCookies.checked;
		analyticsCookie ? allowAnalyticsCookie() : removeAnalyticsCookie();
		allowComplianceCookie();
		btnModalSaveChanges.removeAttribute('disabled');
	});

	// Modal input - prihvati marketing
	var inputModalAllowMarketingCookies = document.getElementById(
		'js-modal-input-cookie-marketing'
	);
	inputModalAllowMarketingCookies.addEventListener('change', function () {
		var marketingCookie = inputModalAllowMarketingCookies.checked;
		marketingCookie ? allowMarketingCookie() : removeMarketingCookie();
		allowComplianceCookie();
		btnModalSaveChanges.removeAttribute('disabled');
	});

	// Footer - prihvati sve
	var btnFooterAllowAllCookies = document.getElementById(
		'js-footer-btn-allow-all'
	);
	btnFooterAllowAllCookies.addEventListener('click', function () {
		allowAnalyticsCookie();
		allowMarketingCookie();
		allowComplianceCookie();
		triggerReload();
	});

	// Footer - prihvati neophodno
	var btnFooterAllowRequiredCookies = document.getElementById(
		'js-footer-btn-accept-required'
	);
	btnFooterAllowRequiredCookies.addEventListener('click', function () {
		removeAnalyticsCookie();
		removeMarketingCookie();
		allowComplianceCookie();
		triggerReload();
	});

	// Prikazuje cookie notice (footer i modal) ako nisu prihvaćeni kolačići
	if (Cookies.get('gdpr-compliance') !== 'Accepted') {
		var cookieFooterWrapper = document
			.getElementById('js-cookie-notice-footer')
			.classList.remove('ms-remove');
		var cookiePopupWrapper = document
			.getElementById('js-cookie-notice-popup')
			.classList.remove('ms-remove');
		//cookieModal.show();
	} else {
		cookieModal.hide();
		inject_js_scripts();
	}
	// Označi inpute na modalu kao označene ako su ti kolačići prihvaćeni
	if (Cookies.get('gdpr-analytics') === 'Accepted') {
		inputModalAllowAnalyticsCookies.checked = true;
	}
	if (Cookies.get('gdpr-marketing') === 'Accepted') {
		inputModalAllowMarketingCookies.checked = true;
	}

	function inject_js_scripts() {
		jQuery.ajax({
			data: {
				action: 'get_scripts',
				cookies_types: {
					'gdpr-analytics': Cookies.get('gdpr-analytics'),
					'gdpr-marketing': Cookies.get('gdpr-marketing'),
				},
			},
			type: 'POST',
			url: ms_cookies.url,
			success: function (response_code) {
				//console.log(response_code);
				var data = JSON.parse(response_code);
				data.forEach((element) => {
					if (element.url) {
						var script = document.createElement('script');
						script.src = element.url;
						document.head.appendChild(script);
					}

					if (element.kod) {
						var script = document.createElement('script');
						script.text = element.kod;
						document.head.appendChild(script);
					}
				});
			},
			error: function (error) {
				console.log(error);
			},
		});
	}

	/* 	
	document.body.appendChild(js);
	window.onload = function () {
		var el = document.getElementsByTagName('div')[0];
		var s = document.createElement('script');
		s.text = 'alert("abc");';
		el.parentNode.insertBefore(s, el.nextSibling);
	}; */
});
