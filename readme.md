=== WooTcsShipmentMaker ===

Contributors: Muhammad Qasim Gulzar
Donate link:
 
Tags:
 
Requires at least: php5
Tested up to: php7

Stable tag:
 
License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is develop to integrate WooCommerce store with TCS Express and Logistic company's system in order to add new shipments

== Description ==

This plugin is developed to help the ecommerece platform in Pakistan. So they can reduce effort of adding new shipments into tcs and focus into the areas which can really give them benifit in term of revenue.
WooCommerce Tcs Plugin is using thired party soap api which is exposed by tcs to the developers so they can easily integrate their systems with tcs make workflow more handy.

== Installation ==

1. Install plugin by uploading zip or directly upload plugin directory under wp-content/plugins/
2. Activate plugin from plugins page. 
3. Make sure that SoapClient is installed and activated on hosted server.

== Frequently asked questions ==

= How to set TCS account credentials. =

Goto WooCommerce Settings > TCS > Set Fields > Save Settings.


== Screenshots ==

1. ![settings screenshot](settings.png?raw=true "Settings") 
2. ![Orders screenshot](order-screen.png?raw=true "Order Items")

== Note ==

If you are getting error while intializing SoapClient than please check that if soap client is enabled in your php configurations.

To enable soap client on ubuntu.

    sudo apt-get install php7.0-soap
    sudo apt-get install php7.0-xml
    php-config --configure-options --enable-soap