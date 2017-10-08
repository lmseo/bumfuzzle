<?php
$navBar = '<nav role="navigation" class="main-nav-bar-l"><ul>';
$currentSection = 'blog';
if( $currentSection == 'opiates')
	$navBar .= '<li id="nav-opiates" class="active"><a href="/opiates.html">Opiates</a></li>';
else
	$navBar .= '<li id="nav-opiates"><a href="/opiates.html">Opiates</a></li>';
if( $currentSection == 'rapid_detox')
	$navBar .= '<li id="nav-Detox"  class="active"> <a href="/rapid-detox/"> Rapid Detox</a></li>';
else
	$navBar .= '<li id="nav-Detox" > <a href="/rapid-detox/"> Rapid Detox</a></li>';
if( $currentSection == 'detox')
	$navBar .= '<li  class="active"> <a href="/rapid-detox/rapid-detox-aftercare.html" >Our Aftercare</a></li>';
else
	$navBar .= '<li > <a href="/rapid-detox/rapid-detox-aftercare.html">Our Aftercare</a></li>';
if( $currentSection == 'testimonials')
	$navBar .= '<li class="active"> <a href="/rapid-detox/why-our-rapid-detox.html" >Why Us</a></li>';
else
	$navBar .= '<li> <a href="/rapid-detox/why-our-rapid-detox.html">Why Us</a></li>';
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