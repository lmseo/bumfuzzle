<?php
/** Start the engine */

require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Balance Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/balance' );

//add_theme_support( 'html5' );

/** Create additional color style options */
add_theme_support( 'genesis-style-selector', array( 'balance-blue' => 'Blue', 'balance-green' => 'Green', 'balance-turquoise' => 'Turquoise', 'balance-pink' => 'Pink' ) );

/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/** Add new image sizes */
add_image_size( 'grid', 384, 100, TRUE );
add_image_size( 'portfolio', 300, 200, TRUE );
/** Add custom body class to the head */
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
   $classes[] = 'sub';
   return $classes;
}
add_action( 'genesis_after_post_content', 'social_bottom' );
function social_bottom() {
	if (!is_page() && !is_home()) {
		$include_root = $_SERVER['DOCUMENT_ROOT'];
		include($include_root . '/includes/templates/2011/main/part.social.php'); 
	}
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
add_action( 'pre_get_posts', 'child_change_home_query' );
/** Changes the query on the home page*/
function child_change_home_query( $query ) {

if( $query->is_main_query() && $query->is_home() ) {
$query->set( 'posts_per_page', '10' );//change the '5' to the posts setting for your widget
}

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
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
add_action('genesis_after_post_content', 'genesis_post_meta');
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
	if (!is_page()) {
		$post_meta = '[post_categories] [post_edit] [post_tags] [post_comments]';
		return $post_meta;
	}
}
/*Customize contact fields*/
add_filter('user_contactmethods','change_contact_info',10,1);
function change_contact_info($contactmethods) {
 
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
 
    $contactmethods['website_title'] = 'Website Title';
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['linkedin'] = 'Linked In';
    $contactmethods['gplus'] = 'Google +';
 
    return $contactmethods;
}
/** Customize 'Read More' text */
add_filter( 'get_the_content_more_link', 'balance_read_more_link' );
add_filter( 'the_content_more_link', 'balance_read_more_link' );
function balance_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '" rel="nofollow">' . __( 'Continue Reading' ) . '</a>';
}

global $wp_query;
if( ($wp_query->current_post == 0) && is_archive() ) {

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


  	$args['home']                    = 'Home';
    $args['sep']                     = ' / ';
    $args['list_sep']                = ', '; // Genesis 1.5 and later
    $args['prefix']                  = '<div class="breadcrumb">';
    $args['suffix']                  = '</div>';
    $args['heirarchial_attachments'] = true; // Genesis 1.5 and later
    $args['heirarchial_categories']  = true; // Genesis 1.5 and later
    $args['display']                 = true;
    $args['labels']['prefix']        = 'You are here: ';
    $args['labels']['author']        = 'Archives for ';
    $args['labels']['category']      = 'Archives for '; // Genesis 1.6 and later
    $args['labels']['tag']           = 'Archives for ';
    $args['labels']['date']          = 'Archives for ';
    $args['labels']['search']        = 'Search for ';
    $args['labels']['tax']           = 'Archives for ';
    $args['labels']['post_type']     = 'Archives for ';
    $args['labels']['404']           = 'Not found: '; // Genesis 1.5 and later
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
/** Adds the  Social Bar       */
add_action( 'genesis_after_post_title', 'social_top' );
function social_top() {
	if (!is_page() && !is_home()) {
		$include_root = $_SERVER['DOCUMENT_ROOT'];
		include($include_root . '/includes/templates/2011/main/part.social.php'); 
	}
}
add_action( 'genesis_after_post_title', 'genesis_post_updated' );
function genesis_post_updated() {
	if (!is_page() && !is_home()) {
		$postUpdated=  '<div class="updated-post"><span class="before-updated">Last modified:</span><span class="updated" rel="updated" title="'.get_the_modified_date('c').'"> '.get_the_modified_date('F j, Y h:i:s A').'</span></div>';
		echo  $postUpdated;
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
add_action( 'genesis_footer', 'genesis_custom_do_footer' );
function genesis_custom_do_footer() { ?>
<div class="gototop"><p><a href="#wrap" rel="nofollow">Return to top of page</a></p></div>
<?php }
add_action( 'genesis_after_footer', 'child_do_footer' );
function child_do_footer() {
	$include_root = $_SERVER['DOCUMENT_ROOT'];
	 include_once( $include_root . '/includes/templates/2011/blog/part.footer.php');
}
/*Customize Author Box*/
remove_action('genesis_after_post', 'genesis_do_author_box_single');
add_action('genesis_after_post_content', 'theme_author_box');
 
/*remove_action( 'genesis_before_loop', 'genesis_do_author_box_archive' );
add_action( 'genesis_before_loop', 'theme_author_box_archive' );
 
function theme_author_box_archive() {
    $authinfo = "<div class=\"author-box\">";
    $authinfo .= get_avatar(get_the_author_id() , 80);
    $authinfo .= "<h1>About the Author" . get_the_author_meta('display_name') . "</h1>";
    $authinfo .= "<p>" . get_the_author_meta('description') . "</p>";
    $facebook = get_the_author_meta('facebook');
    $linkedin = get_the_author_meta('linkedin');
    $twitter = get_the_author_meta('twitter');
    $gplus = get_the_author_meta('gplus');
    $flength = strlen($facebook);
    $llength = strlen($linkedin);
    $tlength = strlen($twitter);
    $glength = strlen($gplus);
    if ($flength > 1 || $glength > 1 || $llength > 1 || $tlength > 1) {
        if (($flength <= 1 && $glength <= 1 && $llength <= 1) && $tlength > 1) {
            $authinfo .= "<p id=\"authcontact\"><a href=\"" . $twitter . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . $twitter . " on Twitter\">Follow " . get_the_author_meta('first_name') . " on Twitter</a></p>\r\n";
        } else {
            $authinfo .= "<p id=\"authcontact\">Find " . get_the_author_meta('first_name') . " on ";
            if ($flength > 1) {
                $authinfo .= " <a href=\"" . $facebook . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on Facebook\">Facebook</a>";
            }
            if ($glength > 1) {
                if ($flength > 1) {
                    $comma = ',';
                } else {
                    $comma = '';
                }
                if ($llength > 1 || $tlength > 1) {
                    $and = '';
                } else {
                    $and = ' and';
                }
                $authinfo .= $comma . $and . " <a href=\"" . $gplus . "\" rel=\"me\" target=\"_blank\" title=\"" . get_the_author_meta('display_name') . " on Google+\">Google+</a>";
            }
            if ($llength > 1) {
                if ($flength > 1 || $glength > 1) {
                    $comma = ',';
                } else {
                    $comma = '';
                }
                if ($tlength > 1) {
                    $and = '';
                } else {
                    $and = ' and';
                }
                $authinfo .= $comma . $and . " <a href=\"http://www.linkedin.com/in/" . $linkedin . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on LinkedIn\">LinkedIn</a>";
            }
            if ($tlength > 1) {
                $authinfo .= ", and <a href=\"http://twitter.com/" . $twitter . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on Twitter\">Twitter</a>";
            }
            $authinfo .= ".</p>\r\n";
        }
    }
    $authinfo .= "</div>\r\n";
    if ( is_author() ) {
        echo $authinfo;
    }
}*/
 
function theme_author_box() {
    $authinfo = "<div class=\"author-box\">\r\n";
    $authinfo .= get_avatar(get_the_author_id() , 80);
    $authinfo .= "<strong>About <a href=\"" . get_the_author_meta('url') . "\" target=\"_blank\" title=\"" . get_the_author_meta('website_title') . "\" rel=\"nofollow\">" . get_the_author_meta('display_name') . "</a></strong>\r\n";
    $authinfo .= "<p>" . get_the_author_meta('description') . "</p>\r\n";
    $facebook = get_the_author_meta('facebook');
    $linkedin = get_the_author_meta('linkedin');
    $twitter = get_the_author_meta('twitter');
    $gplus = get_the_author_meta('gplus');
    $flength = strlen($facebook);
    $llength = strlen($linkedin);
    $tlength = strlen($twitter);
    $glength = strlen($gplus);
    if ($flength > 1 || $glength > 1 || $llength > 1 || $tlength > 1) {
        if (($flength <= 1 && $glength <= 1 && $llength <= 1) && $tlength > 1) {
            $authinfo .= "<p id=\"authcontact\"><a href=\"http://twitter.com/" . $twitter . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . $twitter . " on Twitter\">Follow " . get_the_author_meta('first_name') . " on Twitter</a></p>\r\n";
        } else {
            $authinfo .= "<p id=\"authcontact\">Find " . get_the_author_meta('first_name') . " on ";
            if ($flength > 1) {
                $authinfo .= " <a href=\"http://facebook.com/" . $facebook . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on Facebook\">Facebook</a>";
            }
            if ($glength > 1) {
                if ($flength > 1) {
                    $comma = ',';
                } else {
                    $comma = '';
                }
                if ($llength > 1 || $tlength > 1) {
                    $and = '';
                } else {
                    $and = ' and';
                }
                $authinfo .= $comma . $and . " <a href=\"" . $gplus . "\" rel=\"me\" target=\"_blank\" title=\"" . get_the_author_meta('display_name') . " on Google+\">Google+</a>";
            }
            if ($llength > 1) {
                if ($flength > 1 || $glength > 1) {
                    $comma = ',';
                } else {
                    $comma = '';
                }
                if ($tlength > 1) {
                    $and = '';
                } else {
                    $and = ' and';
                }
                $authinfo .= $comma . $and . " <a href=\"" . $linkedin . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on LinkedIn\">LinkedIn</a>";
            }
            if ($tlength > 1) {
                $authinfo .= ", and <a href=\"" . $twitter . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on Twitter\">Twitter</a>";
            }
                $authinfo .= ".</p>\r\n";
        }
    }
    $authinfo .= "</div>\r\n";
    if ( is_single() ) {
        echo $authinfo;
    }
}
add_action( 'genesis_after_footer', 'olark_after_all_content' );
function olark_after_all_content() {
	?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script>window.jQuery || document.write('<script src="http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/jquery/jquery.min.js"><\/script>')</script><script src="http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/script-v2.js">// iOS fixes
VS.scaleFix();VS.hideUrlBar();// Respond.js
</script><script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-22023073-2']);  _gaq.push(['_setDomainName', 'eopiates.com']);  _gaq.push(['_trackPageview']);  (function() {  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();</script><?php
	$include_root = $_SERVER['DOCUMENT_ROOT'];
	 include_once( $include_root . '/includes/templates/2011/main/part.bottomContent.php');
}