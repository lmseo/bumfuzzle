<div class="pushwrapper"><?php include_once( $include_root . '/includes/templates/2014/july/main/part.topToolBar.php'); ?><?php include_once($include_root . '/includes/templates/2014/july/main/part.header.php'); ?><div class="divider"></div><div id="main" role="main"><div class="wrapper"><!-- google_ad_section_start --><div class="breadcrumbs" style=""><?php $newPage->printBreadCrumb(); ?></div><section class='left-section'><?php $newPage->printH1();?><?php //endif; 
$newPage->printH2(); ?><?php $newPage->printContent(); ?></section><section class="last"><!-- google_ad_section_start(weight=ignore) --><?php include_once($include_root . '/includes/templates/2014/july/main/part.contact.php'); ?><?php $newPage->printWaismannFiles(); ?><!-- google_ad_section_end --><!-- google_ad_section_start(weight=ignore) --><?php  //$newPage->printRecentBlogPosts(); ?><?php //$newPage->printFacts(); ?><?php $newPage->printAdditionalFilesinFolderLinks(); $newPage->printRightNavBarLinks();?><!-- google_ad_section_end --><?php include_once($include_root . '/includes/templates/2014/july/main/ads/ad-sidebar-300.php'); ?></section></div></div><div class="combination-information"><div class="wrapper"><section class="content-links"><?php $newPage->printDrugBrandNames($newPage->getGenericDrug().' Brand Names:');?><?php $newPage->printCombinations($newPage->getGenericDrug().' Combinations:'); ?><?php $newPage->printTopOpioids();?><?php $newPage->printGenericsList(); ?></section></div></div></div><div class="push"></div></div><div class="dividerBottom"></div><!-- google_ad_section_start(weight=ignore) --><?php include_once($include_root . '/includes/templates/2014/july/main/part.footer.php'); ?><!-- google_ad_section_end --><script src="/assets/javascript/2014/plugins/response.min.js" type="text/javascript"></script><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script>window.jQuery || document.write('<script src="http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/jquery/jquery.min.js"><\/script>')</script><script src="http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/script-v2.js"></script><script>// iOS fixes
VS.scaleFix();VS.hideUrlBar();yepnope({test : Modernizr.mq('(min-width)'),nope : ['http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/jquery/plugins/2011/respond.min.js']});
</script><script type="text/javascript">window.google_analytics_uacct = "UA-22023073-1"; var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-22023073-2']);  _gaq.push(['_setDomainName', 'eopiates.com']);  _gaq.push(['_trackPageview']);  (function() {  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();</script><?php include_once($include_root . '/includes/templates/2014/july/main/part.bottomContent.php'); ?>