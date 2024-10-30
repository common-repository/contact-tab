<?php
ob_start();
?>
<script>
jQuery(document).ready(function(){ 


	jQuery("a.ct_tab").toggle( 
				function () {
					jQuery(".ct_form").css('display', 'block'); 
 					jQuery(".ct_container").animate({marginLeft: "0px"}) 
                }, 
                function () { 
					jQuery(".ct_container").animate({marginLeft: "-300px"})  
				} 
		); 
        
}); 
</script> 
<style type="text/css">

a.ct_a:link {text-derocation: none}    /* unvisited link */
a.ct_a:visited {text-derocation: none} /* visited link */
a.ct_a:hover {text-derocation: none}   /* mouse over link */
a.ct_a:active {text-derocation: none}  /* selected link */

#contact_tab .ct_container{
position: fixed;
_position: absolute;
top: 30px;
width: 330px; 
z-index: 10001;
left:0px;
margin-left: -300px;
}




#contact_tab a.ct_tab {
left: 255px;
*left: 300px;
left: 300px\0/;
background-color: #<?php echo $tabcolor; ?>;
text-decoration: none;
outline: 0;
float: right;
height: 30px;
width: 120px;
line-height: 30px;
text-align: center;
top: 120px;
*top: 90px;
top: 70px\0/;
position: absolute;
font-weight: bold;
font-family: arial;
font-size: 18px;
border-left: none;
-webkit-transform:rotate(270deg);
        -moz-transform:rotate(270deg);
        -o-transform: rotate(270deg);
filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
 -webkit-box-shadow: 0 1px 5px rgba(0,0,0,0.75);
  -moz-box-shadow: 0 1px 5px rgba(0,0,0,0.75);
  box-shadow: 0 1px 5px rgba(0,0,0,0.75);
border-radius: 0px 0px 10px 10px;
display: block;
}

#contact_tab .ct_form {
display: none;
float: left;
width: 300px;
background-color: #<?php echo $bgcolor; ?>;
 -webkit-box-shadow: 0 1px 5px rgba(0,0,0,0.75);
  -moz-box-shadow: 0 1px 5px rgba(0,0,0,0.75);
  box-shadow: 0 1px 5px rgba(0,0,0,0.75);
border-radius: 0px 10px 10px 0px;
overflow: hidden;
}

</style>

<div id="contact_tab">
<div class="ct_container">
<div class="ct_form">
<!--form-->

<script>

jQuery(document).ready(function() {

         jQuery('#ct_send').click(function() {

                        // name validation

                        var nameVal = jQuery("#ct_name").val();
                        if(nameVal == '' || nameVal == 'Name') {

                                jQuery("#ct_name_error").html('');
                                jQuery("#ct_name").after('<label class="ct_error" id="ct_name_error">Please enter your name.</label>');
                                return false
                        }
                        else
                        {
                                jQuery("#ct_name_error").html('');
                        }

                        /// email validation

                        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                        var emailaddressVal = jQuery("#ct_email").val();

                        if(emailaddressVal == '') {
                                jQuery("#ct_email_error").html('');
                                jQuery("#ct_email").after('<label class="ct_error" id="ct_email_error">Please enter your email address.</label>');
                                return false
                        }
                        else if(!emailReg.test(emailaddressVal)) {
                                jQuery("#ct_email_error").html('');
                                jQuery("#ct_email").after('<label class="ct_error" id="ct_email_error">Enter a valid email address.</label>');
                                return false

                        }
                        else
                        {
                                jQuery("#ct_email_error").html('');
                        }

    // message validation

                        var messageVal = jQuery("#ct_message").val();
			var msglen = messageVal.length;
                        if(messageVal == '' || messageVal == 'Type a Message\/Comment..' ) {

                                jQuery("#ct_message_error").html('');
                                jQuery("#ct_message").after('<label class="ct_error" id="ct_message_error">Please type a message.</label>');
                                return false
                        }
			else if( msglen < 10 ){
			jQuery("#ct_message_error").html('');
                        jQuery("#ct_message").after('<label class="ct_error" id="ct_message_error">Message too short, please type some more..</label>');
                                return false

			}
                        else
                        {
                                jQuery("#ct_message_error").html('');
                        }


                        jQuery.post("<?php echo plugins_url('/contact-tab/'); ?>post.php?"+jQuery("#shct_form").serialize(), {

                        }, function(response){

                        if(response==1)
                        {
                                jQuery("#ct_after_submit").html('');
                                //jQuery("#after_submit").fadeOut(2000);
                                //change_captcha();
                               <?php if($captcha == 'yes') echo 'change_captcha();'; ?>
				clear_form();
                                //jQuery("#Send").after('<br /><label class="success" id="after_submit">Your message has been submitted.</label>');
				close_div();
				close_tab();

<?php
if(!empty($redurl) && $red == 'yes') $redirect = 'window.location = "http://'.preg_replace('/http:\/\//i','',$redurl).'";';
echo $redirect;
?>

                        }
                        else
                        {
                                jQuery("#ct_after_submit").html('');
                                jQuery("#ct_send").after('<label class="ct_error" style="display: block" id="ct_after_submit">Error ! invalid captcha code .</label>');
                                //jQuery("#after_submit").fadeOut(20000);
                        }


                });

                return false;
         });

         // refresh captcha
         jQuery('img#ct_refresh').click(function() {

                        change_captcha();
                                jQuery("#ct_after_submit").fadeOut(2000);
         });

         function change_captcha()
         {
                document.getElementById('ct_captcha').src="<?php echo plugins_url('/contact-tab/'); ?>get_captcha.php?rnd=" + Math.random();
                jQuery("#ct_code").val('');
         }

         function clear_form()
         {
                jQuery("#ct_name").val('');
                jQuery("#ct_email").val('');
                jQuery("#ct_message").val('');
        	jQuery("#ct_code").val(''); 
	}
	
	  function close_div()
        {
         jQuery("#ct_name,#ct_email,#ct_message,#ct_send,#ct_code,#ct_refresh,#ent_code,#ct_captcha,.ct_social").css('display', 'none');
	 jQuery(".ct_form").prepend('<br /><label class="ct_success" style="margin-top:150px; text-align: center" id="ct_after_submit"><?php echo esc_attr($thx); ?></label>');

        }

        function close_tab() {
                                        
	setTimeout( "jQuery('.ct_container').animate({marginLeft: '-300px'});", 2000);
                                }
                

        });

</script>

<style>

#contact_tab #ct_code{
        width:100px;
	text-align: left;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
	display:inline-block;

}

#contact_tab .ct_error{ 
color:#<?php echo $etxt; ?>; 
font-size:14px; 
font-style:italic; 
text-align: center; 
display: inline-block ; 
font-weight: bold;
font-family: arial;
}

#contact_tab .ct_success{ 
color:#<?php echo $stxt ?>; 
font-size:14px; 
font-style:italic;  
text-align: center ; 
display: block; 
font-weight: bold;
font-family: arial
}

#contact_tab #ct_refresh{
        text-align: center;
        cursor:pointer;

}

#contact_tab #ct_name,#ct_email{ display:inline-block; text-align: left;margin-bottom:3px; height:20px; border:#CCCCCC 1px solid; width: 203px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px }

#contact_tab #ct_message{ display:inline-block; width:248px; height:100px;text-align: left;margin-bottom:3px; border:#CCCCCC 1px solid; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; overflow: auto;
 }

#contact_tab label.shct { color: #<?php echo $txt ?> }
#contact_tab #ct_send{ border:#2A30C6 solid 1px; text-align: center ; background:#<?php echo $bcolor; ?>; color:#FFFFFF; padding: 5px;}

#contact_tab .ct_social { display: inline-block }

</style>
<div style="text-align: center">
<form action="#" name="shct_form" id="shct_form">
<br />
        <input name="ct_name" onfocus="if(this.value == 'Name'){this.value = '';}" type="text" onblur="if(this.value == ''){this.value='Name';}" id="ct_name" value="Name" size="30">
        <br clear="all"/>
         <input name="ct_email" onfocus="if(this.value == 'Email'){this.value = '';}" type="text" onblur="if(this.value == ''){this.value='Email';}" id="ct_email" value="Email" size="30">
        <br clear="all"/>
        <textarea  name="ct_message" id="ct_message" rows="6"  onFocus="this.value=''; return false;">Type a Message/Comment..</textarea>
        <br clear="all"/>

<?php if($options['captcha'] == 'yes') { ?>
      <img src="<?php echo plugins_url('/contact-tab/'); ?>get_captcha.php" alt="" id="ct_captcha" style="text-align: center" />
<img src="<?php echo plugins_url('/contact-tab/'); ?>refresh.png" alt="" id="ct_refresh" width="25" height="25" style="background-color: <?php echo $bgcolor ?>"/>
                <br clear="all"/>
                <label id="ent_code" class="shct">Enter the code above:</label><br clear="all"/>
                <input name="ct_code" type="text" id="ct_code">
        <br clear="all" /><br />
<?php } ?>
        <input value="Send" type="submit" id="ct_send" style="border-radius: 5px;" />
<br clear="all" />
<br clear="all" />
<input type="hidden" id="ct_pageurl" value="" name="ct_pageurl" />
        <script>document.getElementById('ct_pageurl').value = window.location.href;</script>
</form>
<?php if($social == 'yes') {
global $shct_path;
if(!empty($facebook)) echo '<a class="ct_social" target="_blank" href="http://'.$facebook.'"><img src='.$shct_path.'facebook.png /></a> ';
if(!empty($twitter))  echo '<a class="ct_social" target="_blank" href="http://twitter.com/'.$twitter.'"><img src='.$shct_path.'twitter.png /></a> ';
if(!empty($linkedin)) echo '<a class="ct_social" target="_blank" href="http://'.$linkedin.'"><img src='.$shct_path.'linkedin.png /></a> ';
if(!empty($google)) echo '<a class="ct_social" target="_blank" href="http://'.$google.'"><img src='.$shct_path.'google.png /></a> ';
}
?>
</div>
</div>
<a href="#" class="ct_tab" style="text-derocation: none; color: #<?php echo $tabtxt; ?>">Contact Us</a>
</div>
</div>
