<?php

/**
 * Registering settings and custom post type
 */

namespace ms\CookieNotice;

defined('ABSPATH') || exit;

class Backend
{
	public function __construct()
	{
		add_action('plugins_loaded', array($this, 'register_settings'));
		add_action('plugins_loaded', array($this, 'register_acf_fields'));
	}

	// Register options under Settings->General
	public function register_settings()
	{
		if (function_exists('acf_add_options_page')) {
			acf_add_options_page(array(
				'page_title' 	=> 'GDPR',
				'menu_title'	=> 'GDPR',
				'menu_slug' 	=> 'gdpr-settings',
			));
		}
	}

	public function register_acf_fields()
	{
		if (function_exists('acf_add_local_field_group')) :

			acf_add_local_field_group(array(
				'key' => 'group_628f7228f2af2',
				'title' => 'Cookie notice - local',
				'fields' => array(
					array(
						'key' => 'field_628f722f9b652',
						'label' => 'Tab pregled privatnosti',
						'name' => 'tab_pregled_privatnosti',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
					array(
						'key' => 'field_628cdb10ed207',
						'label' => 'Analitički kolačići',
						'name' => 'analiticki_kolacici',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => '',
						'sub_fields' => array(
							array(
								'key' => 'field_628ce2df5796d',
								'label' => 'Naziv',
								'name' => 'analiticki_kolacici_naziv',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_628f63f8c89a9',
								'label' => 'Analitički kolačići URL',
								'name' => 'analiticki_kolacici_url',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_628ce2f15796e',
								'label' => 'Kod',
								'name' => 'analiticki_kolacici_kod',
								'type' => 'textarea',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'maxlength' => '',
								'rows' => '',
								'new_lines' => '',
							),
						),
					),
					array(
						'key' => 'field_628ce3055796f',
						'label' => 'Marketinški kolačići',
						'name' => 'marketinski_kolacici',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => '',
						'sub_fields' => array(
							array(
								'key' => 'field_628ce30557970',
								'label' => 'Naziv',
								'name' => 'marketinski_kolacici_naziv',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_628f74bd643ff',
								'label' => 'Marketinski_kolacici_url',
								'name' => 'marketinski_kolacici_url',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_628ce30557971',
								'label' => 'Kod',
								'name' => 'marketinski_kolacici_kod',
								'type' => 'textarea',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'maxlength' => '',
								'rows' => '',
								'new_lines' => '',
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'general-info',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

		endif;
	}
}