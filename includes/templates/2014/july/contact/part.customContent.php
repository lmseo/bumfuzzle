<?php include_once( $include_root . '/includes/templates/2014/july/main/part.header.php'); include_once($include_root . '/includes/templates/2014/july/contact/part.titleBox.php'); ?><div id="contentBox"><div id="content"><div class="aboutBox"><div class="left"><div class="breadCrumbs" ><?php $newPage->printBreadCrumb(); ?></div><!--End of Breadcrumb--><div class="insideLeft"><!-- google_ad_section_start --><?php $newPage->printH1();$newPage->printH2(); ?><p>We are here to help. To receive assistance or information about the Waismann Method advance rapid detox treatment for  opiate dependence, please complete the form below. We will respond to you via email or telephone.</p><div class="contactFormBox" style="display:block; padding:8px 0 0 0px">Required *<div class="contactFormIn"> <form action="sent.html" method="post" name="info" id="info" onsubmit="return checkbae()"><input type="hidden" name="sitename" value="Opiates.com" /><div class="contact1"><div class="firstname"><span>First Name *</span> <input type="text" class="inv" id="name1" name="name1"/> <input type="text" id="name" name="name"/></div><div class="lastname"> <span>Last Name *</span> <input type="text" name="lastName" id="lastName"/></div><div class="clr"></div></div><div class="contact2"><div class="emailAddress"> <span>Email *</span> <input  type="text" class="form" name="email" id="email" /></div><div class="emailConfirm"> <span>Re-type Email *</span> <input type="text" class="form" name="email2" id="email2"/></div></div><div class="contact3"><div class="phoneNo"> <span>Phone Number</span> <input type="text" name="phone1" id="phone1" maxlength="3" /> <input type="text" name="phone2" id="phone2" maxlength="3"/> <input type="text" name="phone3" id="phone3" maxlength="4" class="end" /></div><div class="leaveMessage"> <span>Leave Message</span><input name="leavemessage" type="radio" value="Yes, you may leave a message" class="leaveMessageYes">Yes<input type="radio" name="leavemessage"  checked="checked" value="Do NOT leave a message">No</div><div class="clr"></div></div><div class="contact4"><div class="drugColumns"> <span>Drugs</span> <?php $newPage->printDrugs('drugs1'); ?></div></div><div class="contact4"><div class="drugColumns end"> <span>Other Drugs:</span> <input type="text" name="otherDrugs" id="otherDrugs"/></div></div><div class="contact5"> <span>Message</span> <input name="redirect" type="hidden" id="redirect" value="sending.php" /> <input name="subject" type="hidden" id="subject" value="Information Request from Opiates.com" /> <input type="hidden" name="contactmethod2" value="1" /> <textarea name="message" cols="62" rows="8" id="message" ></textarea></div> <input type='submit' class="send" value='' ></button><div class="contact6"> Would you Like to receive mailings and/or email updates regarding the Waismann Method <input type="radio" name="emailupdates" value="Yes, you may send updates" class="emailUpdates" /> <strong>Yes</strong> <input type="radio" name="emailupdates" value="Do NOT send a updates" class="emailUpdates" /> <strong>No</strong></div> </form></div></div><!-- google_ad_section_end --></div></div><div class="right"><div class="rightContainer"><div class="sidebarContactBox sidebarContactBoxSent"><div class="phoneSent"><span class="rsRed"><?php $newPage->printCurrentPhone(); ?></span></div></div> <div class="rightInside rightInsideSent"><?php //$newPage->printContent();  ?><p><strong>Clare Kavin <br />1-310-927-7155<br />&#105;&#110;&#102;&#111;&#064;&#111;&#112;&#105;&#097;&#116;&#101;&#115;&#046;&#099;&#111;&#109;<br />Waismann Method</strong></p> </div></div></div></div></div></div></div></div></div>
<?php include_once($include_root . '/includes/templates/2014/july/main/part.disclaimer.php'); ?></div><?php include_once($include_root . '/includes/templates/2014/july/main/part.bottomContent.php'); ?>
<script language="JavaScript">
var testresults
String.prototype.trim = function()
{
return this.replace(/^\s+/,'').replace(/\s+$/,'');
}
function checkemail(){
var str=document.info.email.value.trim();
var str1=document.info.email2.value.trim();
var filter=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if(document.info.name.value==''){
alert("Please enter the name or alias!")
return false
}	
if (filter.test(str)){
if(str==str1){
return true;
}
else{
alert("Email Addresses are not matched!")
return false 
}	
}else{
alert("Please input a valid email address!")
return false
}
//return (testresults)
}
</script>
<script>
function checkbae(){
if (document.layers||document.getElementById||document.all)
return checkemail()
else
return true
}
</script>
<script>
olark('api.visitor.getDetails', function(details){
for(var prop in details) {
    if(details.hasOwnProperty(prop)){		
		var newInput = document.createElement('input');
		newInput.setAttribute('id',prop);
		newInput.setAttribute('name',prop);
		newInput.setAttribute('type','hidden');
		newInput.value = details[prop];
		if(prop=='currentPage'){
			newInput.value = dump(details[prop]) ;
		} 
		if(prop=='recentPageHistory'){
			newInput.value = dump(details[prop]);
		}
		if(prop=='customFields'){
			newInput.value = dump(details[prop]);
		}
		document.info.appendChild(newInput);
	}
}
});
function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "";
	
	if(typeof(arr) == 'object') {
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') {
				dumped_text += level_padding + "'" + item + "'\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else {
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}
</script>