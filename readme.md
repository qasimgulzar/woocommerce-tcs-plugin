
#Introduction
    This plugin is developed to help the ecommerece platform in Pakistan,
    so they can reduce effort of adding new shipments into tcs and focus into 
    the areas which can really give them benifit in term of ravinue.
    
    https://github.com/qasimgulzar/woocommerce-tcs-plugin.git
    
#Setup Instructions
    1. install plugin into the wordpress.
    2. Goto WooCommerece settings.
    3. Select TCS setting tab.
    4. Fill in the required information.
    
    
##Note
    If you are getting error while intializing SoapClient than please check
    that if soap client is enabled in your php configurations.
    
    ###To enable soap client on ubuntu.
        sudo apt-get install php7.0-soap
        sudo apt-get install php7.0-xml
        php-config --configure-options --enable-soap