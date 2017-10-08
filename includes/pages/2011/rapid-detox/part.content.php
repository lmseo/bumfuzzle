<div id="main">
<div id="breadCrumbs" >
<?php $newPage->printBreadCrumb(); ?>
</div>
<!--End of Breadcrumb-->
<div id="content">
<!--left-->
<div class="wrapper-bottom">
<div class="middle-column">				
<div id="main-content" class="box">
<div class="box_top">
<div>
</div>
</div>
<div class="box_body">
<div class="middle-content">
<div id="additional">
<?php $newPage->printContactInformation(); 
$newPage->printSubscribeForm();
$newPage->printAdditionalFilesinFolderLinks(); 
$newPage->printRandomRelatedTestimonial(); ?>
</div>
<?php $newPage->printH1();  $newPage->printH2(); $newPage->printContent(); ?>
</div>
</div>
<div class="box_bottom">
<div>&nbsp;</div>
</div>
</div>
<!--End of SubContent -->
</div>
<!--end of middle-column-->
<div id="column-right"><?php $newPage->printRightNavBarLinks(); ?></div>
<!--End of Column-right-->
</div>
<!--End Wrapper Bottom-->    		
</div>
<!-- End of Content-->
<div class="whiteSmoke-bg">
</div>
<?php
include_once($include_root  . '/includes/pages/2011/simpleSubContent.php');
?> 
<div id="brands">
<!--[if !IE]> -->
<object type="application/x-shockwave-flash"
data="http://www.opiatedetox.org/opiates-com/flash/brands.swf" width="1010" height="36">
<!-- <![endif]-->
<!--[if IE]>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0"
width="1010" height="36">
<param name="movie" value="http://www.opiatedetox.org/opiates-com/flash/brands.swf" />
<!--><!--dgx-->
<param name="wmode" value="transparent" />
<param name="loop" value="true" />
<param name="menu" value="false" />
</object>
<!-- <![endif]-->	
</div>
<!--End of Footer-->
<div class="container-round-edge">
<div></div>
</div>  
</div>