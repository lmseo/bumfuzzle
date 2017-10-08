<?php 

	include("mapxml.php");
	$cwd = basename(getcwd());
	$filter=new filter();
	//$filter->add_dir_reg("/^\..*$/");
	$filter->add_extension("inc");
	$filter->add_extension("ram");
	$filter->add_extension("LCK");
	$filter->add_extension("txt");
	$filter->add_extension("xml");
	$filter->add_extension("js");
	$filter->add_extension("css");
	$filter->add_extension("jpg");
	$filter->add_extension("png");
	$filter->add_extension("php");
	$filter->add_extension("swf");
	$filter->add_extension("db");
	$filter->add_extension("gif");
	$filter->add_extension("ico");

	
	$filter->add_file_reg("/^\..*$/");
	$filter->add_file_reg("/^.*~$/");
	$filter->add_dir_reg("/pdf/");	

	//$filter->add_dir("private"); 
	$filter->add_dir("campaigns");
	$filter->add_dir("countries");
	$filter->add_dir("misspellings");
	$filter->add_dir("ativan");
	$filter->add_dir("reference");
	$filter->add_dir("countries");
	$filter->add_dir("_mmServerScripts");
	$filter->add_dir("_notes");
	$filter->add_dir("adserver");
	$filter->add_dir("contact");
	$filter->add_dir("California");
	$filter->add_dir("NewsAbstractsTextFiles");
	$filter->add_dir("ShockwaveLogos");
	$filter->add_dir("Templates");
	$filter->add_dir("classes");
	$filter->add_dir("cms");
	$filter->add_dir("css");
	$filter->add_dir("files");
	$filter->add_dir("flash");
	$filter->add_dir("functions");
	$filter->add_dir("images");
	$filter->add_dir("img");
	$filter->add_dir("includes");
	$filter->add_dir("monthly-reports");
	$filter->add_dir("picture_library");
	$filter->add_dir("plesk-stat");
	$filter->add_dir("search");
	$filter->add_dir("sendpage");
	$filter->add_dir("styles");
	$filter->add_dir("swap");
	$filter->add_dir("test");
	$filter->add_dir("testimonials");
	$filter->add_dir("blog");
	$filter->add_dir("captcha");
	$filter->add_dir("errordocuments");
	$filter->add_dir("java");
	$filter->add_dir("test");
	$filter->add_dir("ajax");
	$filter->add_dir("analytics");
	$filter->add_dir("ambien");
	$filter->add_dir("alprazolam");
	$filter->add_dir("xanax");
	$filter->add_dir("valium");
	$filter->add_dir("klonopin");
	$filter->add_dir("benzodiazepine");

	
	//$filter->add_file("favicon.ico");
	
	$filter->add_file("test.html");
	$filter->add_file("contact.html");
	$filter->add_file("index.html");
    $filter->add_file("contactform.php");
    $filter->add_file("email.html");
    $filter->add_file("media-sending.html");
    $filter->add_file("media.html");
    $filter->add_file("phone.html");
    $filter->add_file("postal.html");
    $filter->add_file("sending.html");
    $filter->add_file("sent.html");
    $filter->add_file("support.html");
    $filter->add_file("tech-sending.html");
	$filter->add_file("robots.txt");
	$filter->add_file("Brochure 03.pdf");
	$filter->add_file("Intake_Form.doc");
	$filter->add_file("_vti_inf.html");
	$filter->add_file("at_domains_index.html");
	$filter->add_file("beta.htm");
	$filter->add_file("bup_survey.gif");
	$filter->add_file("clifford-bernstein-old.html");
	$filter->add_file("inc.config.php");
	$filter->add_file("nolongerworkingthere_david-crausman.html");
	$filter->add_file("orig_index.html");
	$filter->add_file("phprint.php");
	$filter->add_file("search-test.php");
	$filter->add_file("sitemap.xml");
	$filter->add_file("smbmeta.xml");
	$filter->add_file("staff-old.html");
	$filter->add_file("survey-popup.html");
	$filter->add_file("tracking.js");
	$filter->add_file("yahoo_authkey_8949f37bead68d83.txt");
	
	$explorer = new maphp();
 	$explorer->set_filter($filter);	
	$explorer->run();
?>