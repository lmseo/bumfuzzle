<?php
$navBar = '<div id="navBar-wrapper">';
$navBar .= '<ul id="navBar">';
$currentSection = $newPage->getdbTable();
if( $currentSection == 'opiates')
	$navBar .= '<li id="nav-opiates" ><a href="/opiates/" class="current-section"><small>Opioids &amp; </small>Opiates</a></li>';
else
	$navBar .= '<li id="nav-opiates"><a href="/opiates/"><small>Opioids &amp; </small>Opiates</a></li>';
if( $currentSection == 'rapid_detox')
	$navBar .= '<li id="nav-Detox" > <a href="/rapid-detox/" class="current-section"> Rapid Detox</a></li>';
else
	$navBar .= '<li id="nav-Detox" > <a href="/rapid-detox/"> Rapid Detox</a></li>';
if( $currentSection == 'testimonials')
	$navBar .= '<li id="nav-Testimonials"> <a href="/success/" class="current-section">Testimonials</a></li>';
else
	$navBar .= '<li id="nav-Testimonials"> <a href="/success/">Testimonials</a></li>';
$navBar .= '</ul></div>';
echo $navBar;
?>