<?php
/**
 * Plugin Name: WooCommerce TCS Extension
 * Plugin URI: http://woocommerce.com/products/woocommerce-extension/
 * Description: this plugin is develop to integrate WooCommerce store with TCS Express and Logistic company's system in order to add new shipments.
 * Version: 0.0.0
 * Author: WooCommerce
 * Author URI: http://woocommerce.com/
 * Developer: Muhammad Qasim Gulzar
 * Developer URI: http://www/hoko.pk/
 * Text Domain: woocommerce-tcs
 * Domain Path: /languages
 *
 * WC requires at least: 2.2
 * WC tested up to: 2.3
 *
 * Copyright: © 2009-2015 WooCommerce.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
if (!defined('ABSPATH')) exit;

require_once 'includes/tcs-soap-driver.php';
require_once 'includes/WC_TCS_Setting_Tag.php';

add_action('admin_init', 'wtcs_ajax_add_actions');
function wtcs_ajax_add_actions()
{
    add_filter('woocommerce_admin_order_actions', 'woocommerce_admin_order_actions_button', PHP_INT_MAX, 2);
    add_filter('woocommerce_admin_order_actions', 'add_order_track_action_button', PHP_INT_MAX, 2);
    add_action('wp_ajax_create_tcs_shipment', 'wtcs_create_tcs_shipment');
    add_action("admin_head", 'wtcs_admin_order_actions_button_css');
    add_action('admin_head', 'wtcs_add_order_track_action_button_css');
    WC_TCS_Setting_Tag::init();
}

function woocommerce_admin_order_actions_button($actions, $this_order)
{
    $order_picked_up = get_post_meta($this_order->get_id(), 'ywot_picked_up');
    $order_id = method_exists($this_order, 'get_id') ? $this_order->get_id() : $this_order->id;
    $actions['create_shipment'] = array(
        'url' => wp_nonce_url(admin_url('admin-ajax.php?action=create_tcs_shipment&order_id=' . $order_id), 'woocommerce-create-order-tcs-shipment'),
        'name' => __('Add Consignment', 'woocommerce'),
        'action' => "view create_consignment", // keep "view" class for a clean button CSS
    );
    if (count($order_picked_up) > 0 && ($order_picked_up[0] === "1" || $order_picked_up[0] === "on")) {
        unset($actions['create_shipment']);
    }

    return $actions;
}

function wtcs_admin_order_actions_button_css()
{
    echo '<style>.view.create_consignment::after{content: "\f133"}</style>';
}

function wtcs_add_order_track_action_button_css()
{
    echo '<style>.view.tracking::after { content: "\f173" !important; }</style>';
}

function wtcs_create_tcs_shipment()
{
    $orderid = $_GET['order_id'];
    $order = new WC_Order($orderid);
    $api = new TcsAPI();
    $user = $order->get_user();
    $productDetails = '';
    foreach ($order->get_items() as $item) {
        $product_name = $item['name'];
        $productDetails .= " " . $product_name;
    }
    $orderData = array('userName' => get_option('wc_settings_tab_tcs_username'),
        'password' => get_option('wc_settings_tab_tcs_password'),
        'costCenterCode' => get_option('wc_settings_tab_tcs_cost_center_code'),
        'consigneeName' => $order->get_shipping_first_name() . " " . $order->get_shipping_last_name(),
        'codAmount' => $order->get_total(),
        'services' => 'O',
        'weight' => 0.5,
        'custRefNo' => $orderid,
        "productDetails" => $productDetails,
        "fragile" => 'NO',
        "remarks" => "Order #" . $orderid . " , " . $order->get_customer_note(),
        "insuranceValue" => 0,
        "pieces" => 1,
        "destinationCityName" => $order->get_shipping_city(),
        "originCityName" => get_option('wc_settings_tab_tcs_origin_city'),
        "consigneeEmail" => $order->get_billing_email(),
        "consigneeMobNo" => $order->get_billing_phone(),
        "consigneeAddress" => $order->get_shipping_address_1() . " , " . $order->get_shipping_address_2()
    );
    $trackingCode = $api->createBooking($orderData);
    update_post_meta($orderid, 'ywot_tracking_code', $trackingCode);
    update_post_meta($orderid, 'ywot_carrier_name', "TCS");
    update_post_meta($orderid, 'ywot_pick_up_date', date("Y-m-d"));
    update_post_meta($orderid, 'ywot_picked_up', true);

    header("location: " . get_admin_url() . "edit.php?post_type=shop_order");
    die;
}

function add_order_track_action_button($actions, $the_order)
{
    $ywot_tracking_code = get_post_meta($the_order->get_id(), 'ywot_tracking_code');
    if ($ywot_tracking_code) {
        $actions['track'] = array(
            'url' => "http://www.tcscouriers.com/pk/Tracking/Default.aspx?TrackBy=ReferenceNumberHome&trackNo=" . $ywot_tracking_code[0],
            'name' => __($ywot_tracking_code[0], 'woocommerce'),//$ywot_tracking_code[0]
            'action' => "view tracking", // setting "view" for proper button CSS
        );
    }
    return $actions;
}

?>