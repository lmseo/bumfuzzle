<div id="fb-root"></div><script>window.fbAsyncInit=function(){FB.init({appId:'273946516037384',channelUrl:'//www.eopiates.com/channel.html', status: true, cookie:true, xfbml:true });};(function(d){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];if (d.getElementById(id)) {return;}js = d.createElement('script'); js.id = id; js.async = true;js.src = "//connect.facebook.net/en_US/all.js";ref.parentNode.insertBefore(js, ref);}(document));</script><div class="pushwrapper"><?php include_once( $include_root . '/includes/templates/2014/july/main/part.topToolBar.php'); ?><?php include_once( $include_root . '/includes/templates/2014/july/main/part.header.php'); ?><div class="divider"></div><div id="main" role="main"><div class="wrapper"><!-- google_ad_section_start --><div class="breadcrumbs" style=""><?php $newPage->printBreadCrumb(); ?></div><section class='left-section'><?php $newPage->printH1();?><?php include($include_root . '/includes/templates/2014/july/main/part.social.php'); ?><?php $newPage->printH2(); ?><?php $newPage->printContent(); ?><p><input type="text" id="query" /></p>
<p id="matchType">
	<input type="radio" name="match_type" value="0" />Begins with |
	<input type="radio" name="match_type" value="1" />Ends with |
	<input type="radio" name="match_type" value="2" checked />Contains
</p><?php include($include_root."/includes/sitemap/2014/HTMLSitemap.php"); ?><?php include($include_root . '/includes/templates/2014/july/main/part.social.php'); ?><?php include_once($include_root . '/includes/templates/2014/july/main/ads/ad-bottom-content-300.php'); ?><!-- google_ad_section_end --></section><section class="last"><!-- google_ad_section_start(weight=ignore) --><?php include_once($include_root . '/includes/templates/2014/july/main/part.contact.php'); ?><?php //$newPage->printWaismannFiles(); ?><!-- google_ad_section_end --><!-- google_ad_section_start(weight=ignore) --><!-- google_ad_section_end --><?php include_once($include_root . '/includes/templates/2014/july/main/ads/ad-sidebar-300.php'); ?></section></div></div><div class="combination-information"><div class="wrapper"><section class="content-links"></section></div></div></div><div class="push"></div></div><div class="dividerBottom"></div><!-- google_ad_section_start(weight=ignore) --><?php include_once($include_root . '/includes/templates/2014/july/main/part.footer.php'); ?><!-- google_ad_section_end -->
<script src="/assets/javascript/2014/plugins/response.min.js" type="text/javascript"></script><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script>window.jQuery || document.write('<script src="http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/jquery/jquery.min.js"><\/script>')</script><script src="http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/script-v2.js"></script><script type="text/javascript">VS.scaleFix();VS.hideUrlBar();yepnope({test : Modernizr.mq('(min-width)'),nope : ['http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/jquery/plugins/2011/respond.min.js']});
</script><script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-22023073-2']);  _gaq.push(['_setDomainName', 'eopiates.com']);  _gaq.push(['_trackPageview']);  (function() {  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();</script><script src="//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.0/mustache.min.js"></script>
<script type="mustache/x-tmpl" id="names_tmpl">
{{#numbers}}
<li>Number of results: {{numbers}}</li>
{{/numbers}}
{{#links}}
<li>{{#url}}<a href="{{url}}" title="{{title}}" class="file">{{anchor}}</a>{{/url}}{{^url}}{{title}}{{/url}}</li>
{{/links}}
{{^links}}
<li><em>No matches found </em></li>
{{/links}}
</script>
<script>
$("#query").keyup(function(){
	var q = $(this).val();
	var match_type = $("input[type=radio]:checked").val();
	console.log(match_type);
	
	data = {query:q, match_type:match_type};
	if(q.length == 0 || q == " " || q == ""){
		q='';
	}
	$.ajax({
		url:"/assets/javascript/utilities/instant-search/2014/august/InstantSearchController.php",
		data:data,
		type:"post",
		dataType:"json",
		success:function(res){
			var tmpl = $("#names_tmpl").html();
			var html = Mustache.to_html(tmpl, res);
			$("#menuList").html(html);
		}
	});
});
$("input:radio[name=match_type]").change(function(){
	$("#query").trigger("keyup");
});
$("#query").focus();
</script><?php include_once($include_root . '/includes/templates/2014/july/main/part.bottomContent.php'); ?>