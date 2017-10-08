<?php
$navBar = '<nav role="navigation" class="main-nav-bar-l"><ul>';
$currentSection = $newPage->getdbTable();
if( $currentSection == 'opiates')
	$navBar .= '<li id="nav-opiates" class="active"><a href="/opiates.html">Opiates</a></li>';
else
	$navBar .= '<li id="nav-opiates"><a href="/opiates.html">Opiates</a></li>';
if( $currentSection == 'rapid_detox')
	$navBar .= '<li id="nav-Detox"  class="active"> <a href="/rapid-detox/">Treatment</a></li>';
else
	$navBar .= '<li id="nav-Detox" > <a href="/rapid-detox/">Treatment</a></li>';
if( $currentSection == 'rapid_detox2')
	$navBar .= '<li class="active"> <a href="/rapid-detox/why-our-rapid-detox.html" >Why Us</a></li>';
else
	$navBar .= '<li> <a href="/rapid-detox/why-our-rapid-detox.html">Why Us</a></li>';
$navBar .= '<li><a href="/blog/" title="Blog">Blog</a></li>';
$navBar .= '<li><a href="/forum/" title="Forum">Forum</a></li>';
/*if( $currentSection == 'forum')
	$navBar .= '<li class="active"> <a href="http://forum.eopiates.com/" >Forum</a></li>';
else
	$navBar .= '<li> <a href="http://forum.eopiates.com/" >Forum </a> </li>';
if( $currentSection == 'blog')
	$navBar .= '<li class="active"> <a href="/blog/" >Blog</a></li>';
else
	$navBar .= '<li > <a href="/blog/" >Blog</a> </li>';*/
$navBar .= '</ul></nav>';
echo $navBar;
?>
