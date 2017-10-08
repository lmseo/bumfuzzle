<!--Call jQuery-->
<script type="text/javascript"> 
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:50,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement:e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}if(p==this){return false;}var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);
$(document).ready(function(){$(".main_image .desc").show();$(".main_image .block").animate({ opacity: 0.85 }, 1 );$(".image_thumb ul li:first").addClass('active');$(".image_thumb ul li").hoverIntent(function(){var imgAlt = $(this).find('img').attr("alt");		var pageHref = $(this).find(".pageLink").find('a').attr("href");var imgTitle = $(this).find('img').attr("lowsrc");var imgDesc = $(this).find('.block').html();var imgDescHeight = $(".main_image").find('.block').height();if ($(this).is(".active")){return true;		}else{$(".main_image .block").animate({ opacity: 0, marginBottom: -imgDescHeight }, 250 , function(){$(".main_image .block").html(imgDesc).animate({ opacity: 0.85,	marginBottom: "0" }, 250 );$(".main_image img").attr({ src: imgTitle , alt: imgAlt});				$(".main_image a").attr({ href: pageHref });$(".active").find('a').attr({ href: pageHref });});}$(".image_thumb ul li").removeClass('active');$(this).addClass('active');return false;}, function() {});$("a.collapse").click(function(){$(".main_image .block").slideToggle();$("a.collapse").toggleClass("show");});});
</script> 
<div id="main-container" class="container"> 
<div class="image_thumb"> 
<ul id="featured-stories"> 
<li> 
<a href="/media/waismann-method-featured-on-E!-investigates.html"><img src="/images/media/featured/thumbnail/e-investigates-thumb.jpg" alt="Addicted To Painkillers" lowsrc="http://www.opiatedetox.org/opiates-com/images/media/rotator/header/e-investigates.jpg" /></a> 
<div class="block"> 
<h2>E! Investigates profiles Leanna</h2> 
<small>01/15/10</small> 
<p>The renowned Waismann Method is chosen to help a young mom detox from opiate addiction. E! Investigates profiles Leanna during its show, Addicted to Pills. She has Multiple Sclerosis and began taking Vicodin to control pain. </p><p class="pageLink"><a href="/media/waismann-method-featured-on-E!-investigates.html">Watch it Online</a> </p>  
</div> 
</li> 
<li> 
<a href="/media/waismann-treatment-more-widely-available.html"><img src="/images/media/featured/thumbnail/pills.jpg" lowsrc="http://www.opiatedetox.org/opiates-com/images/media/rotator/header/pills.jpg" width="50" height="38" alt="Pills spilled from a bottle" /></a> 
<div class="block"> 
<h2>First-Ever Price Reduction</h2> 
<small>04/11/09</small>
<p>Leader in Opiate Detoxification Announces First-Ever Price Reduction for Pioneering Treatment to Prescription Painkiller Dependency in Conjunction with National Drug Take-Back Programs.</p><p class="pageLink"><a href="/media/waismann-treatment-more-widely-available.html">Read More.</a></p> 
</div> 
</li> 
<li> 
<a href="/media/good-morning-america.html"><img src="/images/media/featured/thumbnail/abc-good-morning-america-health.jpg" alt="Addicted To Painkillers"  lowsrc="http://www.opiatedetox.org/opiates-com/images/media/rotator/header/abc-good-morning-america-health.jpg"/></a> 
<div class="block"> 
<h2>Elaine's Story  on Good Morning America</h2> 
<small>04/12/09</small> 
<p>After becoming addicted to prescription drugs, Elaine Domino got help from the Waismann Method a procedure that requires her to stay at a hospital for a week.</p><p class="pageLink"><a href="/media/good-morning-america.html">Read More</a></p> 
</div> 
</li> 
<li> 
<a href="/media/oxycontin-48hours-1.html"><img src="/images/media/featured/thumbnail/48-Hours-CBS-news.jpg" alt="Addicted To Painkillers" lowsrc="http://www.opiatedetox.org/opiates-com/images/media/rotator/header/48-Hours-CBS-news.jpg" /></a> 
<div class="block"> 
<h2>Troy Visited by the News Show 48 Hours</h2> 
<small>04/13/09</small> 
<p>Two months after undergoing Waismann Method’s renowned opiate detoxification, a young man is visited by the news show 48 Hours and is still free from OxyContin addiction. </p><p class="pageLink"><a href="/media/oxycontin-48hours-1.html">Read the Story about his OxyContin Addiction</a></p> 
</div> 
</li>
</ul> 
</div>
<div class="main_image"> 
<a href="/media/waismann-method-featured-on-E!-investigates.html"><img src="http://www.opiatedetox.org/opiates-com/images/media/rotator/header/e-investigates.jpg" alt="E! Investigates: Addicted to Pills" /> </a>
<div class="desc"> 
<a href="#" class="collapse">Close Me!</a>
<div class="block"> 
<h2><a href="/media/waismann-method-featured-on-E!-investigates.html">Addicted to Painkillers</a></h2> 
<small>01/15/10</small>
<p>The renowned Waismann Method is chosen to help a young mom detox from opiate addiction. E! Investigates profiles Leanna during its show, Addicted to Pills. She has Multiple Sclerosis and began taking Vicodin to control pain. </p><p class="pageLink"><a href="/media/waismann-method-featured-on-E!-investigates.html">Watch it Online</a> </p>  
</div> 
</div>
</div>  
</div>