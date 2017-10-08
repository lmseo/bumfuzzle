<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-ca">
<head>
   <?php $this->RenderAsset('Head'); ?>
</head>
<body id="<?php echo $BodyIdentifier; ?>" class="<?php echo $this->CssClass; ?> sub about">
<div class="pushwrapper"><?php $include_root = $_SERVER['DOCUMENT_ROOT'];include_once( $include_root . '/includes/templates/2014/main/part.topToolBar.php'); ?><?php include_once( $include_root . '/includes/templates/2014/forum/part.header.php'); ?><div class="divider"></div></div>

   <div id="Frame">
      <div id="Head">
         <div class="Menu">
            <h1><a class="Title" href="<?php echo Url('/'); ?>"><span><?php echo Gdn_Theme::Logo(); ?></span></a></h1>
            <?php
			      $Session = Gdn::Session();
					if ($this->Menu) {
						$this->Menu->AddLink('Dashboard', T('Dashboard'), '/dashboard/settings', array('Garden.Settings.Manage'), array('class' => 'Dashboard'));
						// $this->Menu->AddLink('Dashboard', T('Users'), '/user/browse', array('Garden.Users.Add', 'Garden.Users.Edit', 'Garden.Users.Delete'),  array('class' => 'Users'));
						$this->Menu->AddLink('Activity', T('Activity'), '/activity', FALSE, array('class' => 'Activity'));
						if ($Session->IsValid()) {
							$Name = $Session->User->Name;
							$CountNotifications = $Session->User->CountNotifications;
							if (is_numeric($CountNotifications) && $CountNotifications > 0)
								$Name .= ' <span class="Alert">'.$CountNotifications.'</span>';

                     if (urlencode($Session->User->Name) == $Session->User->Name)
                        $ProfileSlug = $Session->User->Name;
                     else
                        $ProfileSlug = $Session->UserID.'/'.urlencode($Session->User->Name);
							$this->Menu->AddLink('User', $Name, '/profile/'.$ProfileSlug, array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));
							$this->Menu->AddLink('SignOut', T('Sign Out'), SignOutUrl(), FALSE, array('class' => 'NonTab SignOut'));
						} else {
							$Attribs = array();
							if (SignInPopup() && strpos(Gdn::Request()->Url(), 'entry') === FALSE)
								$Attribs['class'] = 'SignInPopup';
								
							$this->Menu->AddLink('Entry', T('Sign In'), SignInUrl($this->SelfUrl), FALSE, array('class' => 'NonTab SignIn'), $Attribs);
						}
						echo $this->Menu->ToString();
					}
				?>
            <div class="Search"><?php
					$Form = Gdn::Factory('Form');
					$Form->InputPrefix = '';
					echo 
						$Form->Open(array('action' => Url('/search'), 'method' => 'get')),
						$Form->TextBox('Search'),
						$Form->Button('Go', array('Name' => '')),
						$Form->Close();
				?></div>
         </div>
      </div>
      <div id="Body">
         <div id="Content"><?php $this->RenderAsset('Content'); ?></div>
         <div id="Panel"><?php $this->RenderAsset('Panel'); ?></div>
      </div>
      <div id="Foot">
			<?php
				$this->RenderAsset('Foot');
			?>
		</div>
   </div>
	<?php $this->FireEvent('AfterBody'); ?>
    <div class="combination-information"><div class="wrapper"><section class="content-links"><div class="rightContinue"><h2 class="list-title ">Top 20 Opioid Drugs (Brand Names) </h2><ul><li class="opioid-top-20-drugs"><a href="/vicodin.html" title="Vicodin">Vicodin</a></li><li class="opioid-top-20-drugs"><a href="/heroin.html" title="Heroin">Heroin</a></li><li class="opioid-top-20-drugs"><a href="/percocet.html" title="Percocet">Percocet</a></li><li class="opioid-top-20-drugs"><a href="/norco.html" title="Norco">Norco</a></li><li class="opioid-top-20-drugs"><a href="/suboxone.html" title="Suboxone">Suboxone</a></li><li class="opioid-top-20-drugs"><a href="/oxycontin.html" title="OxyContin">OxyContin</a></li><li class="opioid-top-20-drugs"><a href="/dilaudid.html" title="Dilaudid">Dilaudid</a></li><li class="opioid-top-20-drugs"><a href="/lortab.html" title="Lortab">Lortab</a></li><li class="opioid-top-20-drugs"><a href="/ultram.html" title="Ultram">Ultram</a></li><li class="opioid-top-20-drugs"><a href="/opana.html" title="Opana">Opana</a></li><li class="opioid-top-20-drugs"><a href="/subutex.html" title="Subutex">Subutex</a></li><li class="opioid-top-20-drugs"><a href="/darvocet.html" title="Darvocet">Darvocet</a></li><li class="opioid-top-20-drugs">Lomotil</li><li class="opioid-top-20-drugs"><a href="/tussionex.html" title="Tussionex">Tussionex</a></li><li class="opioid-top-20-drugs"><a href="/endocet.html" title="Endocet">Endocet</a></li><li class="opioid-top-20-drugs"><a href="/ms-contin.html" title="MS Contin">MS Contin</a></li><li class="opioid-top-20-drugs"><a href="/roxicodone.html" title="Roxicodone">Roxicodone</a></li><li class="opioid-top-20-drugs">Ultracet</li><li class="opioid-top-20-drugs">Butrans</li><li class="opioid-top-20-drugs"><a href="/lorcet.html" title="Lorcet">Lorcet</a></li></ul></div><div class="additional-divider"></div><div class="generic-list rightContinue"><h2 class="list-title ">Generic Opiates </h2><ul><li class="opioid-generic-drug"><a href="/buprenorphine.html" title="Buprenorphine">Buprenorphine</a></li><li class="opioid-generic-drug"><a href="/butorphanol.html" title="Butorphanol">Butorphanol</a></li><li class="opioid-generic-drug"><a href="/codeine.html" title="Codeine">Codeine</a></li><li class="opioid-generic-drug">Diacetylmorphine</li><li class="opioid-generic-drug"><a href="/diphenoxylate/" title="Diphenoxylate">Diphenoxylate</a></li><li class="opioid-generic-drug"><a href="/fentanyl.html" title="Fentanyl">Fentanyl</a></li><li class="opioid-generic-drug"><a href="/hydrocodone.html" title="Hydrocodone">Hydrocodone</a></li><li class="opioid-generic-drug"><a href="/hydromorphone.html" title="Hydromorphone">Hydromorphone</a></li><li class="opioid-generic-drug"><a href="/levacetylmethadol.html" title="Levacetylmethadol">Levacetylmethadol</a></li><li class="opioid-generic-drug"><a href="/levorphanol.html" title="Levorphanol">Levorphanol</a></li><li class="opioid-generic-drug"><a href="/meperidine.html" title="Meperidine">Meperidine</a></li><li class="opioid-generic-drug"><a href="/methadone.html" title="Methadone">Methadone</a></li><li class="opioid-generic-drug"><a href="/morphine.html" title="Morphine">Morphine</a></li><li class="opioid-generic-drug"><a href="/oxycodone/" title="Oxycodone">Oxycodone</a></li><li class="opioid-generic-drug"><a href="/oxymorphone.html" title="Oxymorphone">Oxymorphone</a></li><li class="opioid-generic-drug"><a href="/propoxyphene.html" title="Propoxyphene">Propoxyphene</a></li><li class="opioid-generic-drug"><a href="/tramadol.html" title="Tramadol">Tramadol</a></li></ul></div></section></div></div>
    <div class="dividerBottom"></div><!-- google_ad_section_start(weight=ignore) --><?php include_once($include_root . '/includes/templates/2014/forum/part.footer.php'); ?><!-- google_ad_section_end --><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script><script>window.jQuery || document.write('<script src="http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/jquery/jquery.min.js"><\/script>')</script><script src="http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/script-v2.js"></script><script>// iOS fixes
VS.scaleFix();VS.hideUrlBar();// Respond.js
yepnope({test : Modernizr.mq('(min-width)'),nope : ['http://cfb53adb9351fd691fd4-80f3ec783953bb03d20a214936320935.r9.cf1.rackcdn.com/javascript/jquery/plugins/2011/respond.min.js']});
</script><script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-22023073-2']);  _gaq.push(['_setDomainName', 'eopiates.com']);  _gaq.push(['_trackPageview']);  (function() {  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();</script><?php include_once($include_root . '/includes/templates/2014/main/part.bottomContent.php'); ?>
</body>
</html>
