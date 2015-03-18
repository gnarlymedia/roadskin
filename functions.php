<?php
// Register style sheet.
add_action( 'wp_enqueue_scripts', 'add_style_sheet' );
add_action( 'wp_footer', 'google_adwords_conv_purchase' );
add_action( 'wp_footer', 'google_tag_manager_gnarl' );
add_action( 'wp_footer', 'google_tag_manager_grin' );
add_filter( 'wp_nav_menu_items', 'woo_custom_add_sociallink_navitems', 10, 2 );
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
/*add_action( 'wp_enqueue_scripts', 'purchase_conf_analytics_code_test' );*/
/*add_action( 'woocommerce_thankyou', 'my_custom_tracking' );*/
add_action( 'woocommerce_thankyou', 'google_adwords_hook_code' );

function google_adwords_conv_purchase() {
	if (strpos(current_page_url(), '/checkout/order-received/') !== false) {
		/*?><script>alert("Yes");</script><?php*/
        	wp_enqueue_script( 'adwords_conv_purchase', get_stylesheet_directory_uri() . '/analytics_conv_code_purchase.js', array(), '1.0.0', true );
	}
}
 
function current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function google_adwords_hook_code() {
	/* Just test it works before adding in conversion value */
	/*?><script>alert("Yes");</script><?php*/
	?>
	<!-- Google Code for Purchase-hook code Conversion Page -->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 987327359;
	var google_conversion_language = "en";
	var google_conversion_format = "2";
	var google_conversion_color = "ffffff";
	var google_conversion_label = "eHQxCKKxnFkQ_9bl1gM";
	var google_conversion_value = 1.00;
	var google_conversion_currency = "AUD";
	var google_remarketing_only = false;
	/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/987327359/?value=1.00&amp;currency_code=AUD&amp;label=eHQxCKKxnFkQ_9bl1gM&amp;guid=ON&amp;script=0"/>
	</div>
	</noscript>
	<?php
}

function my_custom_tracking( $order_id ) {
 
// Lets grab the order
$order = new WC_Order( $order_id );
$order_total = $order->get_total();
/*var_dump($order_total);*/
?>
<!-- Google Code for Successful purchase-Simon Conversion Page -->
<script type="text/javascript">
/*alert(<?php echo $order_total; ?>);*/
/* <![CDATA[ */
var google_conversion_id = 987327359;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "eHQxCKKxnFkQ_9bl1gM";
if (<?php echo $order_total ?>) {
	var google_conversion_value = <?php echo $order_total ?>
} else {
	var google_conversion_value = 1.00;
}
var google_conversion_currency = "AUD";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/987327359/?value=1.00&amp;currency_code=AUD&amp;label=eHQxCKKxnFkQ_9bl1gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php
}

// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );

/* function to return an undo unsbscribe string for MailPoet newsletters */
add_shortcode('mailpoet_undo_unsubscribe', 'mpoet_get_undo_unsubscribe');

/**
 * Register style sheet.
 */
function add_style_sheet() {
    wp_register_style( 'style-sheet-2', get_stylesheet_directory_uri() . '/style1.css' );
    wp_enqueue_style( 'style-sheet-2' );

    wp_register_style( 'style-sheet-3', get_stylesheet_directory_uri() . '/style-product-variations.css' );
    wp_enqueue_style( 'style-sheet-3' );
}

function woo_custom_add_sociallink_navitems ( $items, $args ) {
    global $woo_options;

    if ( $args->theme_location == 'primary-menu' ) {

//        $template_directory = get_template_directory_uri();

        $profiles = array(
            'twitter' => __( 'Follow us on Twitter' , 'woothemes' ),
            'facebook' => __( 'Connect on Facebook' , 'woothemes' ),
            'youtube' => __( 'Watch on YouTube' , 'woothemes' ),
            'flickr' => __( 'See photos on Flickr' , 'woothemes' ),
            'linkedin' => __( 'Connect on LinkedIn' , 'woothemes' ),
            'delicious' => __( 'Discover on Delicious' , 'woothemes' ),
            'googleplus' => __( 'View Google+ profile' , 'woothemes' ),
            'instagram' => __( 'View Instagram profile' , 'woothemes' )
        );

        foreach ( $profiles as $key => $text ) {
            if ( isset( $woo_options['woo_connect_' . $key] ) && $woo_options['woo_connect_' . $key] != '' ) {
                $items .= make_list_item( 'social_' . $key, $text, $woo_options['woo_connect_' . $key], '_blank' );
            }
        }
        $items .= make_list_item('social_instagram', 'View Instagram profile', 'http://instagram.com/grinfactoraustralia', '_blank' );

        /* Make link for account icon */
        $account_icon_link = get_permalink( get_option('woocommerce_myaccount_page_id') );

        $items .= make_list_item('account', 'View Your Account', $account_icon_link);
//        $items .= make_list_item('search', 'Search This Site', get_edit_user_link());
    }

    return $items;
}
function make_list_item( $this_key, $this_text, $this_url, $target = null ) {
    $results .= '<li id="menu-item-' . $this_key . '" class ="menu-item-type-social">';
    $results .= '<a class="' . $this_key .'" href="' . $this_url . '" title="' . esc_attr( $this_text ) . '"';
    if ($target) {
        $results .= ' target="' . $target . '"';
    }
    $results .= ' />';
    $results .= '<img src="' . site_url() . '/wp-content/uploads/2014/11/' . $this_key . '.png" alt="' . $this_key . '" />';
    $results .= '</a></li>';
    return $results;
}
// End woo_custom_add_sociallink_navitems()

function google_tag_manager_gnarl() {
    ?>
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-N2GSJQ"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-N2GSJQ');</script>
    <!-- End Google Tag Manager -->
    <?php
}

function google_tag_manager_grin() {
	?>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P7JPN5"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-P7JPN5');</script>
	<!-- End Google Tag Manager -->
	<?php
}

function woo_new_product_tab( $tabs ) {
    $tabs['test_tab'] = array(
        'title' 	=> __( 'Product Guarantees', 'woocommerce' ),
        'priority' 	=> 50,
        'callback' 	=> 'woo_new_product_tab_content'
    );
    return $tabs;
}
function woo_new_product_tab_content() {
    echo '<h2>Product Guarantees</h2>';
    echo '<p>At Grinfactor Australia, we are completely dedicated to your total satisfaction. If you have any suggestions or comments please <a href="' . site_url() . '/contact/" alt="Contact" target="_blank">contact us</a>.</p>';
    echo '<p class="guarantee_promise">Our Promise - 30 day money back guarantee plus free delivery on exchanges.</p>';
    echo '<h3>Guarantee and Returns Policy</h3>';
    echo '<p>Our products are covered by a 12 month warranty on the workmanship, stitching, zippers and fabrics used.</p>';
    echo '<p>Grinfactor/Roadskin Australia is committed to providing quality products to our customers. If for any reason you are not completely satisfied with any product supplied by Grinfactor/Roadskin Australia, please return it to us in original condition within 30 days of receipt and Grinfactor/Roadskin Australia will replace it or refund your purchase price using the original payment method.</p>';
    echo '<h3>Privacy Notice</h3>';
    echo '<p>Grinfactor does not disclose buyers information to third parties. Cookies are used on this shopping site to keep track of the contents of your shopping cart once you have selected an item, to store delivery addresses if the address book is used, and to store your details.</p>';
    echo '<h3>Credit Card Security</h3>';
    echo '<p>All credit card numbers used on the Grinfactor website are securely encrypted by PayPal.</p>';
}

/**
 * function to return an undo unsbscribe string for MailPoet newsletters
 * you could place it in the functions.php of your theme
 * @return string
 */
function mpoet_get_undo_unsubscribe(){
 if(class_exists('WYSIJA') && !empty($_REQUEST['wysija-key'])){
 
 $undo_paramsurl = array(
 'wysija-page'=>1,
 'controller'=>'confirm',
 'action'=>'undounsubscribe',
 'wysija-key'=>$_REQUEST['wysija-key']
 );
 
 $model_config = WYSIJA::get('config','model');
 $link_undo_unsubscribe = WYSIJA::get_permalink($model_config->getValue('confirmation_page'),$undo_paramsurl);
 
 $undo_unsubscribe = str_replace(
 array('[link]','[/link]'),
 array('<a href="'.$link_undo_unsubscribe.'">','</a>'),
 '<p><b>'.__('You made a mistake? [link]Undo unsubscribe[/link].',WYSIJA)).'</b><p>';
 
 return $undo_unsubscribe;
 }
 return '';
}

add_filter('widget_text', 'do_shortcode');
