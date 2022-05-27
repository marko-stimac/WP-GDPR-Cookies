document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	var cookieModal = new bootstrap.Modal(
		document.getElementById('js-modal-cookies'),
		{
			keyboard: false,
		}
	);

	function allowAnalyticsCookie() {
		Cookies.set('gdpr-analytics', 'Accepted', { expires: 365 * 5 });
	}
	function allowMarketingCookie() {
		Cookies.set('gdpr-marketing', 'Accepted', { expires: 365 * 5 });
	}
	function allowComplianceCookie() {
		Cookies.set('gdpr-compliance', 'Accepted', { expires: 365 * 5 }); // da mu se popup više ne prikazuje
	}
	function removeAnalyticsCookie() {
		Cookies.remove('gdpr-analytics');
	}
	function removeMarketingCookie() {
		Cookies.remove('gdpr-marketing');
	}
	function triggerReload() {
		window.location.reload();
	}

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
		btnModalAllowRequiredCookies.removeAttribute('disabled');
	});

	// Modal input - prihvati marketing
	var inputModalAllowMarketingCookies = document.getElementById(
		'js-modal-input-cookie-marketing'
	);
	inputModalAllowMarketingCookies.addEventListener('change', function () {
		var marketingCookie = inputModalAllowMarketingCookies.checked;
		marketingCookie ? allowMarketingCookie() : removeMarketingCookie();
		allowComplianceCookie();
		btnModalAllowRequiredCookies.removeAttribute('disabled');
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
			},
			type: 'POST',
			url: ms_cookies.url,
			success: function (response_code) {
				console.log(response_code);
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
