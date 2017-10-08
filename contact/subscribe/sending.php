<?php
session_start();$include_root = $_SERVER['DOCUMENT_ROOT'];include_once $include_root . "/includes/drug-master/session.php"; require_once($include_root . '/includes/templates/2011/main/part.docType.php'); ?><head><meta http-equiv="Refresh" content="4;URL=sent.php" /><?php include_once($include_root . '/includes/templates/2011/main/part.metaHead.php'); ?></head><body class="sub about"><div id="fb-root"></div>
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
</script><div class="pushwrapper"><?php include_once( $include_root . '/includes/templates/2011/main/part.topToolBar.php'); ?><?php include_once( $include_root . '/includes/templates/2011/main/part.header.php'); ?><div class="divider"></div><div id="main" role="main"><div class="wrapper"><div class="breadcrumbs" style=""><?php $newPage->printBreadCrumb(); ?></div><section class='left-section'><?php $newPage->printH1();?><?php 
$newPage->printH2(); ?><?php $newPage->printContent(); ?><?php $newPage->printRightNavBarLinks(); ?></section><section class="last"><?php include_once($include_root . '/includes/templates/2011/main/part.contact.php'); ?><?php $newPage->printWaismannFiles(); ?><?php  //$newPage->printRecentBlogPosts(); ?><?php //$newPage->printFacts(); ?><?php $newPage->printAdditionalFilesinFolderLinks(); ?></section></div></div></div><div class="push"></div></div><div class="dividerBottom"></div><?php include_once($include_root . '/includes/templates/2011/main/part.footer.php'); ?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script>window.jQuery || document.write('<script src="http://opiatesdrugs.com/eopiates_com/javascript/jquery/jquery.min.js"><\/script>')</script><script src="http://opiatesdrugs.com/eopiates_com/javascript/script-v2.js"></script><script type="text/javascript" src="http://opiatesdrugs.com/eopiates_com/javascript/jquery/plugins/2012/accordion/jquery-scrollTo.js"></script>
<script type="text/javascript" src="http://opiatesdrugs.com/eopiates_com/javascript/jquery/plugins/2012/accordion/accordion.js"></script><script>// iOS fixes
VS.scaleFix();VS.hideUrlBar();// Respond.js
yepnope({test : Modernizr.mq('(min-width)'),nope : ['http://opiatesdrugs.com/eopiates_com/javascript/jquery/plugins/2011/respond.min.js']});
</script><script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-22023073-2']);  _gaq.push(['_setDomainName', 'eopiates.com']);  _gaq.push(['_trackPageview']);  (function() {  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();</script><?php include_once($include_root . '/includes/templates/2011/main/part.bottomContent.php'); ?></body></html>