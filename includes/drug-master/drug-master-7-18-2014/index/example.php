<link rel="stylesheet" type="text/css" href="http://www.opiatedetox.org/opiates-com/css/newsletters/newsletters.css"> 
<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="http://css.nyt.com/css/0.1/screen/build/homepage/ie.css?v=012611">
<![endif]--> 
<!--[if IE 6]>
    <link rel="stylesheet" type="text/css" href="http://css.nyt.com/css/0.1/screen/build/homepage/ie6.css">
<![endif]--> 
<?php
require_once('class.indexNewsletterPage.php');
$newPage = new indexNewsletterPage('newsletters');
$newPage->printIndexContent();
?>