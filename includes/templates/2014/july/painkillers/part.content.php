<?php include_once( $include_root . '/includes/templates/2011/main/part.header.php'); include_once($include_root . '/includes/templates/2011/painkillers/part.titleBox.php'); ?> <div id="contentBox"> <div id="content"> <div class="aboutBox"> <div class="left"><div class="breadCrumbs" ><?php $newPage->printBreadCrumb(); ?></div><!--End of Breadcrumb--> <div class="insideLeft"> <?php $newPage->printH1(); $newPage->printH2(); $newPage->printContent(); ?> <?php include_once($include_root . '/includes/templates/2011/main/simpleSubContent.php'); ?> </div> </div> <div class="right"> <div class="rightContainer"> <div class="rightInside"><?php include_once($include_root.'/includes/templates/2011/main/part.contact.php'); ?><?php $newPage->printWaismannFiles(); ?> </div> <!-- google_ad_section_start(weight=ignore) --><?php $newPage->printRandomRelatedTestimonial();$newPage->printAdditionalFilesinFolderLinks();  ?><!-- google_ad_section_end --><!-- google_ad_section_start --> <div class="rightInside"> <?php $newPage->printRightNavBarLinks(); ?> </div> </div> </div> </div> </div> </div> <!-- google_ad_section_start(weight=ignore) --></div></div></div><!-- google_ad_section_end --><?php include_once($include_root . '/includes/templates/2011/main/part.disclaimer.php'); ?></div><?php include_once($include_root . '/includes/templates/2011/main/part.bottomContent.php'); ?>