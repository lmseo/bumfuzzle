<?php include_once( $include_root . '/includes/templates/2011/main/part.header.php'); include_once($include_root . '/includes/templates/2011/media/part.titleBox.php'); ?> <div id="contentBox"> <div id="content"> <div class="newsBox"> <div class="left"><div class="breadCrumbs" ><?php $newPage->printBreadCrumb(); ?></div><!--End of Breadcrumb--><div class="insideLeft"> <?php $newPage->printH1(); $newPage->printH2(); $newPage->printContent();?>