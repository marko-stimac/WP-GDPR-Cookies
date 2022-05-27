<?php

/**
 * Register scripts, styles, fetch data and show component
 */

namespace ms\CookieNotice;

defined('ABSPATH') || exit;

class Frontend
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
		add_action('wp_ajax_get_scripts', array($this, 'get_scripts'));
		add_action('wp_ajax_nopriv_get_scripts', array($this, 'get_scripts'));
	}

	// Register general scripts and styles
	public function register_scripts()
	{
		wp_enqueue_style('cookie-styles', plugins_url('/assets/style.css', __DIR__));

		wp_register_script('js-cookie', plugins_url('/assets/js/vendor/js.cookie.js', __DIR__), array('jquery'), THEME_VERSION, true);
		wp_register_script('js-cookie-main', plugins_url('/assets/js/main.js', __DIR__), array('jquery', 'js-cookie'), THEME_VERSION, true);
		wp_enqueue_script('js-cookie-main');
		wp_localize_script(
			'js-cookie-main',
			'ms_cookies',
			array(
				'url'   => admin_url('admin-ajax.php'),
			)
		);
	}

	public function get_scripts()
	{

		$data = [];

		//$data = array(get_field('featured_description', 32));
		if (have_rows('analiticki_kolacici', 'option')) :
			while (have_rows('analiticki_kolacici', 'option')) : the_row();
				$data[] = array(
					'url' => get_sub_field('analiticki_kolacici_url'),
					'kod' => get_sub_field('analiticki_kolacici_kod')
				);
			endwhile;
		endif;

		if (have_rows('marketinski_kolacici', 'option')) :
			while (have_rows('marketinski_kolacici', 'option')) : the_row();
				$data[] = array(
					'url' => get_sub_field('marketinski_kolacici_url'),
					'kod' => get_sub_field('marketinski_kolacici_kod')
				);
			endwhile;
		endif;

		echo json_encode($data);

		wp_die();
	}

	// Retrieve data for maps and pass it to JS
	public function showComponent($atts, $content)
	{
?>


<div id="js-cookie-notice-popup" class="gdpr ms-remove">
	<div id="js-modal-cookies" class="modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="relative">
					<button type="button" class="btn btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
						<svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
							<path d="M458 33.1c-1.4.5-47.4 45.8-102.2 100.7L256 233.5l-99.7-99.7C47.8 25.4 54.7 31.7 45.3 33.5c-4.9.9-10.9 6.9-11.8 11.8-1.8 9.4-8.1 2.5 100.3 110.9l99.7 99.8-100.2 100.2C24.6 465.1 30.7 458.3 32.4 467.6c.9 4.7 7.3 11.1 12 12 9.3 1.7 2.5 7.8 111.3-100.9L256 278.5l100.2 100.2c109 108.9 102.1 102.6 111.5 100.8 4.9-.9 10.9-6.9 11.8-11.8 1.8-9.4 8.1-2.5-100.8-111.4L278.5 256l100.2-100.2C487.3 47.1 481.3 53.7 479.6 44.5c-1.7-9.1-12.7-14.9-21.6-11.4z" fill="#fff" />
						</svg>
					</button>
				</div>
				<div class="modal-body">

					<div class="modal-body-in">
						<div class="modal-left relative">
							<div class="modal-logo mb-4">
								{logo}
							</div>
							<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								<button class="btn nav-link active" id="v-pills-general-tab" data-bs-toggle="pill" data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general" aria-selected="true">
									<svg width="25" height="25" class="icon icon-privacy-overview" viewBox="0 0 26 32">
										<path d="M11.082 27.443l1.536 0.666 1.715-0.717c5.018-2.099 8.294-7.014 8.294-12.442v-5.734l-9.958-5.325-9.702 5.325v5.862c0 5.376 3.2 10.24 8.115 12.365zM4.502 10.138l8.166-4.506 8.397 4.506v4.813c0 4.838-2.893 9.19-7.347 11.034l-1.101 0.461-0.922-0.41c-4.352-1.894-7.194-6.195-7.194-10.957v-4.941zM12.029 14.259h1.536v7.347h-1.536v-7.347zM12.029 10.394h1.536v2.483h-1.536v-2.483z" fill="currentColor"></path>
									</svg>
									<span class="nav-link-text"><?php _e('Pregled privatnosti', 'ms'); ?></span>
								</button>
								<button class="btn nav-link" id="v-pills-required-cookies-tab" data-bs-toggle="pill" data-bs-target="#v-pills-required-cookies" type="button" role="tab" aria-controls="v-pills-required-cookies" aria-selected="false">
									<svg width="25" height="25" class="icon icon-strict-necessary" viewBox="0 0 26 32">
										<path d="M22.685 5.478l-9.984 10.752-2.97-4.070c-0.333-0.461-0.973-0.538-1.434-0.205-0.435 0.333-0.538 0.947-0.23 1.408l3.686 5.094c0.179 0.256 0.461 0.41 0.768 0.435h0.051c0.282 0 0.538-0.102 0.742-0.307l10.854-11.699c0.358-0.435 0.333-1.075-0.102-1.434-0.384-0.384-0.998-0.358-1.382 0.026v0zM22.301 12.954c-0.563 0.102-0.922 0.64-0.794 1.203 0.128 0.614 0.179 1.229 0.179 1.843 0 5.094-4.122 9.216-9.216 9.216s-9.216-4.122-9.216-9.216 4.122-9.216 9.216-9.216c1.536 0 3.021 0.384 4.378 1.101 0.512 0.23 1.126 0 1.357-0.538 0.205-0.461 0.051-0.998-0.384-1.254-5.478-2.944-12.314-0.922-15.283 4.557s-0.922 12.314 4.557 15.258 12.314 0.922 15.258-4.557c0.896-1.638 1.357-3.482 1.357-5.35 0-0.768-0.077-1.51-0.23-2.253-0.102-0.538-0.64-0.896-1.178-0.794z" fill="currentColor"></path>
									</svg>
									<span class="nav-link-text"><?php _e('Neophodni kolačići', 'ms'); ?></span></button>
								<button class="btn nav-link" id="v-pills-analytics-tab" data-bs-toggle="pill" data-bs-target="#v-pills-analytics" type="button" role="tab" aria-controls="v-pills-analytics" aria-selected="false"><svg width="25" height="25" class="icon icon-3rd-party" viewBox="0 0 26 32">
										<path d="M25.367 3.231c-0.020 0-0.040 0-0.060 0.020l-4.98 1.080c-0.16 0.040-0.2 0.16-0.080 0.28l1.42 1.42-10.060 10.040 1.14 1.14 10.060-10.060 1.42 1.42c0.12 0.12 0.24 0.080 0.28-0.080l1.060-5.020c0-0.14-0.080-0.26-0.2-0.24zM1.427 6.371c-0.74 0-1.4 0.66-1.4 1.4v19.6c0 0.74 0.66 1.4 1.4 1.4h19.6c0.74 0 1.4-0.66 1.4-1.4v-14.6h-1.6v14.4h-19.2v-19.2h14.38v-1.6h-14.58z" fill="currentColor"></path>
									</svg>
									<span class="nav-link-text"><?php _e('Funkcionalni i analitički kolačići', 'ms'); ?></span>
								</button>
								<button class="btn nav-link" id="v-pills-marketing-tab" data-bs-toggle="pill" data-bs-target="#v-pills-marketing" type="button" role="tab" aria-controls="v-pills-marketing" aria-selected="false"><svg width="25" height="25" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
										<g data-name="1">
											<path d="M293.9,450H233.53a15,15,0,0,1-14.92-13.42l-4.47-42.09a152.77,152.77,0,0,1-18.25-7.56L163,413.53a15,15,0,0,1-20-1.06l-42.69-42.69a15,15,0,0,1-1.06-20l26.61-32.93a152.15,152.15,0,0,1-7.57-18.25L76.13,294.1a15,15,0,0,1-13.42-14.91V218.81A15,15,0,0,1,76.13,203.9l42.09-4.47a152.15,152.15,0,0,1,7.57-18.25L99.18,148.25a15,15,0,0,1,1.06-20l42.69-42.69a15,15,0,0,1,20-1.06l32.93,26.6a152.77,152.77,0,0,1,18.25-7.56l4.47-42.09A15,15,0,0,1,233.53,48H293.9a15,15,0,0,1,14.92,13.42l4.46,42.09a152.91,152.91,0,0,1,18.26,7.56l32.92-26.6a15,15,0,0,1,20,1.06l42.69,42.69a15,15,0,0,1,1.06,20l-26.61,32.93a153.8,153.8,0,0,1,7.57,18.25l42.09,4.47a15,15,0,0,1,13.41,14.91v60.38A15,15,0,0,1,451.3,294.1l-42.09,4.47a153.8,153.8,0,0,1-7.57,18.25l26.61,32.93a15,15,0,0,1-1.06,20L384.5,412.47a15,15,0,0,1-20,1.06l-32.92-26.6a152.91,152.91,0,0,1-18.26,7.56l-4.46,42.09A15,15,0,0,1,293.9,450ZM247,420h33.39l4.09-38.56a15,15,0,0,1,11.06-12.91A123,123,0,0,0,325.7,356a15,15,0,0,1,17,1.31l30.16,24.37,23.61-23.61L372.06,328a15,15,0,0,1-1.31-17,122.63,122.63,0,0,0,12.49-30.14,15,15,0,0,1,12.92-11.06l38.55-4.1V232.31l-38.55-4.1a15,15,0,0,1-12.92-11.06A122.63,122.63,0,0,0,370.75,187a15,15,0,0,1,1.31-17l24.37-30.16-23.61-23.61-30.16,24.37a15,15,0,0,1-17,1.31,123,123,0,0,0-30.14-12.49,15,15,0,0,1-11.06-12.91L280.41,78H247l-4.09,38.56a15,15,0,0,1-11.07,12.91A122.79,122.79,0,0,0,201.73,142a15,15,0,0,1-17-1.31L154.6,116.28,131,139.89l24.38,30.16a15,15,0,0,1,1.3,17,123.41,123.41,0,0,0-12.49,30.14,15,15,0,0,1-12.91,11.06l-38.56,4.1v33.38l38.56,4.1a15,15,0,0,1,12.91,11.06A123.41,123.41,0,0,0,156.67,311a15,15,0,0,1-1.3,17L131,358.11l23.61,23.61,30.17-24.37a15,15,0,0,1,17-1.31,122.79,122.79,0,0,0,30.13,12.49,15,15,0,0,1,11.07,12.91ZM449.71,279.19h0Z" fill="currentColor" />
											<path d="M263.71,340.36A91.36,91.36,0,1,1,355.08,249,91.46,91.46,0,0,1,263.71,340.36Zm0-152.72A61.36,61.36,0,1,0,325.08,249,61.43,61.43,0,0,0,263.71,187.64Z" fill="currentColor" />
										</g>
									</svg>
									<span class="nav-link-text"><?php _e('Kolačići društvenih mreža i marketing', 'ms'); ?></span>
								</button>
							</div>
						</div>
						<div class="tab-content modal-right" id="v-pills-tabContent">
							<div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
								<div class="h2 mb-3"><?php _e('Pregled privatnosti', 'ms'); ?></div>
								<?php the_field('tab_pregled_privatnosti', 'option'); ?>
							</div>
							<div class="tab-pane fade" id="v-pills-required-cookies" role="tabpanel" aria-labelledby="v-pills-required-cookies-tab">
								<div class="h2 mb-3"><?php _e('Neophodni kolačići', 'ms'); ?></div>
								<?php the_field('tab_nuzni_kolacici', 'option'); ?>
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" id="input-gdpr-1" disabled checked>
									<label class="form-check-label" for="input-gdpr-1"><?php _e('Omogućeno', 'ms'); ?></label>
								</div>
							</div>
							<div class="tab-pane fade" id="v-pills-analytics" role="tabpanel" aria-labelledby="v-pills-analytics-tab">
								<div class="h2 mb-3"><?php _e('Funkcionalni i analitički kolačići', 'ms'); ?></div>
								<?php the_field('tab_funkcionalni_kolacici', 'option'); ?>
								<div class="form-check form-switch">
									<input id="js-modal-input-cookie-analytics" class="form-check-input" type="checkbox" value="false">
									<label class="form-check-label" for="js-modal-input-cookie-analytics"><?php _e('Omogućeno', 'ms'); ?></label>
								</div>
							</div>
							<div class="tab-pane fade" id="v-pills-marketing" role="tabpanel" aria-labelledby="v-pills-marketing-tab">
								<div class="h2 mb-3"><?php _e('Kolačići društvenih mreža i marketing', 'ms'); ?></div>
								<?php the_field('tab_marketinski_kolacici', 'option'); ?>
								<div class="form-check form-switch">
									<input id="js-modal-input-cookie-marketing" class="form-check-input" type="checkbox" value="false">
									<label class="form-check-label" for="js-modal-input-cookie-marketing"><?php _e('Omogućeno', 'ms'); ?></label>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button id="js-modal-btn-accept-required" type="button" class="btn btn-primary" disabled><?php _e('Spremi promjene', 'ms'); ?></button>
					<button id="js-modal-btn-allow-all" type="button" class="btn btn-primary"><?php _e('Omogući sve', 'ms'); ?></button>
					<button id="js-modal-btn-accept-required" type="button" class="btn btn-primary"><?php _e('Omogući samo neophodno', 'ms'); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="js-cookie-notice-footer" class="ms-remove cookie-notice bg-white text-center w-100">
	<div class="container-fluid d-flex flex-column flex-lg-row align-items-center justify-content-center py-2">
		<div class="cookie-notice__text">
			<?php echo get_bloginfo('name'); ?> <?php _e('koristi internetske "kolačiće" s ciljem omogućavanja boljeg korisničkog iskustva.', 'ms'); ?>
		</div>
		<div class="cookie-notice__btns">
			<button class="btn btn-primary cookie-notice__btn ms-2 p-2" data-bs-toggle="modal" data-bs-target="#js-modal-cookies">
				<?php _e('Postavke', 'ms'); ?>
			</button>
			<button id="js-footer-btn-allow-all" class="btn btn-primary cookie-notice__btn ms-2 p-2">
				<?php _e('Prihvaćam sve', 'ms'); ?>
			</button>
			<button id="js-footer-btn-accept-required" class="btn btn-primary cookie-notice__btn ms-2 p-2">
				<?php _e('Prihvaćam samo neophodno', 'ms'); ?>
			</button>

		</div>
	</div>
</div>

<?php
	}
}