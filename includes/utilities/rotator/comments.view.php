<!--Call jQuery--> 
<script src="/ajax/javascript/jquery/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript"> 
/**
* hoverIntent is similar to jQuery's built-in "hover" function except that
* instead of firing the onMouseOver event immediately, hoverIntent checks
* to see if the user's mouse has slowed down (beneath the sensitivity
* threshold) before firing the onMouseOver event.
* 
* hoverIntent r5 // 2007.03.27 // jQuery 1.1.2+
* <http://cherne.net/brian/resources/jquery.hoverIntent.html>
* 
* hoverIntent is currently available for use in all personal or commercial 
* projects under both MIT and GPL licenses. This means that you can choose 
* the license that best suits your project, and use it accordingly.
* 
* // basic usage (just like .hover) receives onMouseOver and onMouseOut functions
* $("ul li").hoverIntent( showNav , hideNav );
* 
* // advanced usage receives configuration object only
* $("ul li").hoverIntent({
*	sensitivity: 7, // number = sensitivity threshold (must be 1 or higher)
*	interval: 100,   // number = milliseconds of polling interval
*	over: showNav,  // function = onMouseOver callback (required)
*	timeout: 0,   // number = milliseconds delay before onMouseOut function call
*	out: hideNav    // function = onMouseOut callback (required)
* });
* 
* @param  f  onMouseOver function || An object with configuration options
* @param  g  onMouseOut function  || Nothing (use configuration options object)
* @author    Brian Cherne <brian@cherne.net>
*/
(function($) {
	$.fn.hoverIntent = function(f,g) {
		// default configuration options
		var cfg = {
			sensitivity: 7,
			interval: 50,
			timeout: 0
		};
		// override configuration options with user supplied object
		cfg = $.extend(cfg, g ? { over: f, out: g } : f );

		// instantiate variables
		// cX, cY = current X and Y position of mouse, updated by mousemove event
		// pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
		var cX, cY, pX, pY;

		// A private function for getting mouse position
		var track = function(ev) {
			cX = ev.pageX;
			cY = ev.pageY;
		};

		// A private function for comparing current and previous mouse position
		var compare = function(ev,ob) {
			ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			// compare mouse positions to see if they've crossed the threshold
			if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
				$(ob).unbind("mousemove",track);
				// set hoverIntent state to true (so mouseOut can be called)
				ob.hoverIntent_s = 1;
				return cfg.over.apply(ob,[ev]);
			} else {
				// set previous coordinates for next time
				pX = cX; pY = cY;
				// use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
				ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
			}
		};

		// A private function for delaying the mouseOut function
		var delay = function(ev,ob) {
			ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			ob.hoverIntent_s = 0;
			return cfg.out.apply(ob,[ev]);
		};

		// A private function for handling mouse 'hovering'
		var handleHover = function(e) {
			// next three lines copied from jQuery.hover, ignore children onMouseOver/onMouseOut
			var p = (e.type == "mouseover" ? e.fromElement : e.toElement) || e.relatedTarget;
			while ( p && p != this ) { try { p = p.parentNode; } catch(e) { p = this; } }
			if ( p == this ) { return false; }

			// copy objects to be passed into t (required for event object to be passed in IE)
			var ev = jQuery.extend({},e);
			var ob = this;

			// cancel hoverIntent timer if it exists
			if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }

			// else e.type == "onmouseover"
			if (e.type == "mouseover") {
				// set "previous" X and Y position based on initial entry point
				pX = ev.pageX; pY = ev.pageY;
				// update "current" X and Y position based on mousemove
				$(ob).bind("mousemove",track);
				// start polling interval (self-calling timeout) to compare mouse coordinates over time
				if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}

			// else e.type == "onmouseout"
			} else {
				// unbind expensive mousemove event
				$(ob).unbind("mousemove",track);
				// if hoverIntent state is true, then call the mouseOut function after the specified delay
				if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
			}
		};

		// bind the function to the two event listeners
		return this.mouseover(handleHover).mouseout(handleHover);
	};
})(jQuery);
$(document).ready(function(){//Show Banner
	$(".main_image .desc").show(); //Show Banner
	$(".main_image .block").animate({ opacity: 0.85 }, 1 ); //Set Opacity
	//Click and Hover events for thumbnail list
	$(".image_thumb ul li:first").addClass('active'); 
	$(".image_thumb ul li").hoverIntent(function(){ 
		//Set Variables
		var imgAlt = $(this).find('img').attr("alt"); //Get Alt Tag of Image
		var pageHref = $(this).find(".pageLink").find('a').attr("href");
		var imgTitle = $(this).find('img').attr("lowsrc"); //Get Main Image URL
		var imgDesc = $(this).find('.block').html(); 	//Get HTML of block
		var imgDescHeight = $(".main_image").find('.block').height();	//Calculate height of block
		if ($(this).is(".active")) {  //If it's already active, then...
			return true; // Don't click through
		} else {
			//Animate the Teaser
			
			$(".main_image .block").animate({ opacity: 0, marginBottom: -imgDescHeight }, 250 , function() {
				$(".main_image .block").html(imgDesc).animate({ opacity: 0.85,	marginBottom: "0" }, 250 );
				$(".main_image img").attr({ src: imgTitle , alt: imgAlt});
				$(".main_image a").attr({ href: pageHref });
				$(".active").find('a').attr({ href: pageHref });
			});
		}
		$(".image_thumb ul li").removeClass('active'); //Remove class of 'active' on all lists
		$(this).addClass('active');  //add class of 'active' on this list only
		return false;
		
	}, function() {
		
	}); /*.hover(function(){
		$(this).addClass('hover');
		}, function() {
		$(this).removeClass('hover');
	});*/
	//Toggle Teaser
	$("a.collapse").click(function(){
		$(".main_image .block").slideToggle();
		$("a.collapse").toggleClass("show");
	});
});//Close Function
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
