<?php include_once( $include_root . '/includes/templates/2011/main/part.header.php'); include_once($include_root . '/includes/templates/2011/main/part.titleBox.php'); ?><div id="contentBox"><div id="content"><div class="aboutBox"><div class="left"><div class="breadCrumbs" ><?php $newPage->printBreadCrumb(); ?></div><!--End of Breadcrumb--> <div class="insideLeft"><!-- google_ad_section_start --><?php $newPage->printH1(); $newPage->printH2(); $newPage->printContent(); ?><!-- google_ad_section_end --> <?php include_once($include_root . '/includes/templates/2011/main/simpleSubContent.php'); ?> </div> </div> <div class="right"><!-- google_ad_section_start(weight=ignore) --> <div class="rightContainer"> <div class="rightInside"><?php include_once($include_root.'/includes/templates/2011/main/part.contact.php'); ?><?php $newPage->printWaismannFiles(); ?> </div><?php  $newPage->printRandomRelatedTestimonial(); ?><div class="rightInside"><?php $newPage->printAdditionalFilesinFolderLinks(); ?></div><!-- google_ad_section_end --><div class="rightInside"> <?php $newPage->printRightNavBarLinks(); ?> </div> </div><!-- google_ad_section_end --> </div></div></div></div></div></div></div><?php include_once($include_root . '/includes/templates/2011/main/part.disclaimer.php'); ?></div><?php include_once($include_root . '/includes/templates/2011/main/part.bottomContent.php'); ?>