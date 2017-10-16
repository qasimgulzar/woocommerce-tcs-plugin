<?php
/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 10/14/17
 * Time: 6:26 PM
 */

class WC_TCS_Setting_Tag
{
    public static function init()
    {
        add_filter('woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', PHP_INT_MAX);
        add_action('woocommerce_settings_tabs_tcs_settings_tab', __CLASS__ . '::settings_tab');
        add_action('woocommerce_update_options_tcs_settings_tab', __CLASS__ . '::update_settings');
    }

    public static function add_settings_tab($setting_tabs)
    {
        $setting_tabs['tcs_settings_tab'] = __('TCS', 'woocommerce-tcs-settings-tab');

        return $setting_tabs;
    }

    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab()
    {
        woocommerce_admin_fields(self::get_settings());
    }

    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings()
    {
        woocommerce_update_options(self::get_settings());
    }

    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings()
    {
        $settings = array(
            'section_title' => array(
                'name' => __('TCS Settings', 'woocommerce-tcs-settings-tab'),
                'type' => 'title',
                'desc' => '',
                'id' => 'wc_settings_tab_tcs_section_title'
            ),
            'username' => array(
                'name' => __('Username', 'woocommerce-tcs-settings-tab'),
                'type' => 'text',
                'desc' => __('Please enter tcs cost center username here.', 'woocommerce-settings-tab'),
                'id' => 'wc_settings_tab_tcs_username',
                'required' => true
            ),
            'costcenter' => array(
                'name' => __('Cost Center', 'woocommerce-tcs-settings-tab'),
                'type' => 'text',
                'desc' => __('Please enter tcs cost center code here.', 'woocommerce-settings-tab'),
                'id' => 'wc_settings_tab_tcs_cost_center_code',
                'required' => true
            ),
            'origin_city' => array(
                'name' => __('Origin City', 'woocommerce-tcs-settings-tab'),
                'type' => 'text',
                'desc' => __('Please enter city of origin here.', 'woocommerce-settings-tab'),
                'id' => 'wc_settings_tab_tcs_origin_city',
                'required' => true
            ),
            'password' => array(
                'name' => __('Password', 'woocommerce-tcs-settings-tab'),
                'type' => 'password',
                'desc' => __('Please enter tcs cost center password here.', 'woocommerce-settings-tab'),
                'id' => 'wc_settings_tab_tcs_password',
                'required' => true
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_settings_tab_demo_section_end'
            )
        );
        return apply_filters('wc_settings_tab_demo_settings', $settings);
    }
}