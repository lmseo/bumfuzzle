<?php
require_once('class.html.php');

echo '<pre>';
$my_image = new html('img');
$my_image->set('src','https://www.google.com/adsense/static/en_US/images/adsense_logo.gif');
$my_image->set('border','0');

$image = new html('img');
$image->set('src','http://www.prweb.com/images/logo_prweb.gif');
$image->set('border','0');

$image2 = new html('img');
$image2->set('src','http://opiates/images/main/call-now.gif');
$image2->set('border','0');
//$image->add($image2, 'b');
$image->inject($image2);

$anchor = new html('a');
//$anchor->set('href','http://www.lolo.com');
$anchor->set(array('href'=>'http://www.lolo.com','class'=>'lolo','title'=>'lolo','text'=>'lolo'));
//$anchor->add($my_image, 'a');
$anchor->add($my_image);
$anchor->inject($image);
 $anchor->output();
//<a href="http://cnn.com" title="CNN"><img src="cnn-logo.jpg" border="0" /></a> echo '</pre>';
?>