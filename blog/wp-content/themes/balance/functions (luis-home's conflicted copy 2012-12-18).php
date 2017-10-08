<?php
/** Start the engine */

require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Balance Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/balance' );

/** Create additional color style options */
add_theme_support( 'genesis-style-selector', array( 'balance-blue' => 'Blue', 'balance-green' => 'Green', 'balance-turquoise' => 'Turquoise', 'balance-pink' => 'Pink' ) );

/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/** Add new image sizes */
add_image_size( 'grid', 295, 100, TRUE );
add_image_size( 'portfolio', 300, 200, TRUE );
/** Add custom body class to the head */
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
   $classes[] = 'sub';
   return $classes;
}

/** Before Header */
add_action( 'genesis_before_header', 'before_header_box' );
function before_header_box() {
	$include_root = $_SERVER['DOCUMENT_ROOT'];
	?>
    <div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
FB.init({
appId      : '273946516037384', // App ID
channelUrl : '//www.eopiates.com/channel.html', // Channel File
status     : true, // check login status
cookie     : true, // enable cookies to allow the server to access the session
xfbml      : true  // parse XFBML
});
// Additional initialization code here
};
// Load the SDK Asynchronously
(function(d){
var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = "//connect.facebook.net/en_US/all.js";
ref.parentNode.insertBefore(js, ref);
}(document));
</script><div class="pushwrapper"><?php include_once( $include_root . '/includes/templates/2011/blog/part.topToolBar.php'); ?><?php include_once( $include_root . '/includes/templates/2011/blog/part.header.php'); ?><div class="divider"></div>
	<?php
}


/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'balance_viewport_meta_tag' );
function balance_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Unregister layout settings */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

/** Add support for custom background */
add_custom_background();

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 135 ) );

// [date]
function displaydate(){
return date('l, F jS, Y');
}
add_shortcode('date', 'displaydate');
// end date

/** Customize the post meta function */
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
	if (!is_page()) {
		$post_meta = '[post_categories] [post_edit] [post_tags] [post_comments]';
		return $post_meta;
	}
}

/** Customize 'Read More' text */
add_filter( 'get_the_content_more_link', 'balance_read_more_link' );
add_filter( 'the_content_more_link', 'balance_read_more_link' );
function balance_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '" rel="nofollow">' . __( 'Continue Reading' ) . '</a>';
}

/** Customize search button text */
add_filter( 'genesis_search_button_text', 'custom_search_button_text' );
function custom_search_button_text($text) {
	return esc_attr('');
}

/** Reposition the breadcrumbs */



add_filter ( 'genesis_home_crumb', 'child_amend_home_breadcrumb_link' ); // Genesis >= 1.5

function child_amend_home_breadcrumb_link( $crumb ) {
    //return preg_replace('/href="[^"]*"/', 'href="/"', $crumb);
	if($_SERVER['REQUEST_URI']=='/blog/'){
		return '<a href="/" title="Opiates Home">Home</a><span>Blog</span>';
	}
	return '<a href="/" title="Opiates Home">Home</a><a href="/blog/" title="Opiates Blog">Blog</a>';
}

/** Customize breadcrumbs display */
add_filter( 'genesis_breadcrumb_args', 'balance_breadcrumb_args' );
function balance_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = ' ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb"><div class="wrap">';
	$args['suffix'] = '</div></div>';
	$args['labels']['prefix'] = '';
	return $args;
}

/** Reposition post info */
remove_action( 'genesis_before_post_content', 'genesis_post_info' );
add_action( 'genesis_before_post_title', 'genesis_post_info' );

/** Customize the post info function */
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
	if (!is_page()) {
		$post_info = '[post_author_posts_link] [post_date]';
		return $post_info;
	}
}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Register widget areas */
genesis_register_sidebar( array(
	'id'				=> 'home-featured-left',
	'name'			=> __( 'Home Featured Left', 'balance' ),
	'description'	=> __( 'This is the featured left area on the homepage.', 'balance' ),
) );

genesis_register_sidebar( array(
	'id'				=> 'home-featured-right',
	'name'			=> __( 'Home Featured Right', 'balance' ),
	'description'	=> __( 'This is the featured right area on the homepage.', 'balance' ),
) );

genesis_register_sidebar( array(
	'id'				=> 'portfolio',
	'name'			=> __( 'Portfolio', 'balance' ),
	'description'	=> __( 'This is the portfolio page.', 'balance' ),
) );

remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_after_footer', 'child_do_footer' );
function child_do_footer() {
	$include_root = $_SERVER['DOCUMENT_ROOT'];
	 include_once( $include_root . '/includes/templates/2011/blog/part.footer.php');
}

add_action( 'genesis_after_footer', 'olark_after_all_content' );
function olark_after_all_content() {
	?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script>window.jQuery || document.write('<script src="http://opiatesdrugs.com/eopiates_com/javascript/jquery/jquery.min.js"><\/script>')</script><script src="http://opiatesdrugs.com/eopiates_com/javascript/script-v2.js">// iOS fixes
VS.scaleFix();VS.hideUrlBar();// Respond.js
</script><script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-22023073-2']);  _gaq.push(['_setDomainName', 'eopiates.com']);  _gaq.push(['_trackPageview']);  (function() {  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();</script><?php
	$include_root = $_SERVER['DOCUMENT_ROOT'];
	 include_once( $include_root . '/includes/templates/2011/main/part.bottomContent.php');
}
