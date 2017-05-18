<?php if($my_redirect <> 'me-members.php' and $my_redirect <> 'signin.php') 
{ 
	$btns_social = '';
	if(SOCIAL_ID_FACEBOOK <> '#')
	{ $btns_social .= '<a href="https://www.facebook.com/'.SOCIAL_ID_FACEBOOK.'" title="Facebook" class="fb_icon"><i class="fa fa-facebook"></i></a>';
	}
	if(SOCIAL_ID_TWITTER <> '#')
	{ $btns_social .= '<a href="https://twitter.com/'.SOCIAL_ID_TWITTER.'" title="Twitter" class="tw_icon"><i class="fa fa-twitter"></i></a>'; 
	}
	if(SOCIAL_ID_GOOGLE <> '#')
	{ $btns_social .= '<a href="https://plus.google.com/'.SOCIAL_ID_GOOGLE.'" title="Google Plus" class="gplus_icon"><i class="fa fa-google-plus"></i></a>'; 
	}
	if(SOCIAL_ID_YOUTUBE <> '#')
	{ $btns_social .= '<a href="https://www.youtube.com/'.SOCIAL_ID_YOUTUBE.'" title="YouTube" class="yt_icon"><i class="fa fa-youtube-play"></i></a>'; 
	}
	
	if($btns_social <> '')
	{ $btns_social .= '<a href="mailto:'.SITE_MAIL_TO_BASIC.'" title="Mail us" class="mail_icon"><i class="fa fa-envelope"></i></a>';
	echo '<div align="center" class="btns_social">'.$btns_social.'</div>'; }
} ?>



<script type="text/javascript" src="scripts/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="scripts/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui-1.10.2.min.js"></script>

<script type="text/javascript" src="scripts/misc/jquery.once.js"></script>
<script type="text/javascript" src="scripts/misc/jquery.browserdetect.js"></script>
<script type='text/javascript' src='scripts/megamenu/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='scripts/megamenu/jquery.dcmegamenu.1.2.js'></script>

<script type="text/javascript" src="scripts/validate/jquery.validate-1.14.min.js"></script>
<script type="text/javascript" src="scripts/validate/jquery.validate-1.14.additional.min.js"></script>

<script type="text/javascript" src="scripts/modal/jquery.modal.js" charset="utf-8"></script>
<script type="text/javascript" src="scripts/misc/jquery.addcaptions-0.2.js"></script>
<script type="text/javascript" src="apps/captchajx/ajax_captcha.js"></script>
<script type="text/javascript" src="scripts/accordion/jquery.accordion.js"></script>
<?php /*?><script type="text/javascript" src="scripts/accordion/accordion.js"></script><?php */?>


<div class="modal fade" style="display:none;"></div>
<div id="dynaScript"></div>
<script type="text/javascript" src="zscript_site.js"></script>

<link rel="stylesheet" href="scripts/bxslider/jquery.bxslider.carousel.css" type="text/css" /><?php /*?><?php */?>
<script src="scripts/bxslider/jquery.bxslider.min.js"></script>
<script type="text/javascript">
	
jQuery(document).ready(function($) {
	
	var windowWidth = window.innerWidth;
	
	if( $('#banner_flex').length ) {
		$.get('includes/wrap_banner_flex.php').done(function(data) {
          $('#banner_flex').html(data);
		  var getBanFlex = $(".bxslider").bxSlider({ mode: "fade", captions: false, pager: true, controls: false, auto: true, pause: 10000, onSlideAfter: function() { $(".bx-start").trigger("click"); }
			});
        });
	}
	
	if( $('.bxcarousel').length ) {
		$('.bxcarousel').bxSlider({
		  auto: true,pause: 10000,minSlides: 4,maxSlides: 4,slideMargin: 0, pager: false, controls: true
		});
	}
	
	$('.bxinner').bxSlider();
	
	<?php if($this_page == 'index1.php' or $this_page == 'content.php' or $this_page == 'gallery.php'){  ?>
	var getSlider = $(".bxslider").bxSlider({
		mode: "fade", captions: false, pager: true, controls: false, auto: true, pause: 100000, onSlideAfter: function() { $(".bx-start").trigger("click"); }
	});
	<?php } ?>

	$('.bxServices').bxSlider({ auto: false,pause: 10000,pager: false,controls: true,slideWidth: 150,minSlides: 7,maxSlides: 7, slideMargin: 0 });
		
	
});		

</script>



<script type="text/javascript">

jQuery(document).ready(function($) 
{
	var hash = window.location.hash.substr(1);
	if(hash == '') { hash = $('#dept_nav li a:first').attr('data-id'); }
	
	
	var href = $('#dept_nav li a').each(function(){		
		var tabId = $(this).attr('data-id');			
		if(hash==tabId){
			$(this).addClass('current');
			var tabUr = $(this).attr('data-url')+' #content_'+tabId;
			$('#tabcontent').load(tabUr,'', doImageDisplays);
			
			if(tabId != '105')
			{ $("#site-slider").hide(); } else 
			{ $("#site-slider").show(); }
			
			//doImageDisplays();
		}											
	});

	$('#dept_nav li a').click(function()
	{
		var tabId = $(this).attr('data-id');						  
		var toLoad = $(this).attr('data-url')+' #content_'+tabId;
		
		$('#dept_nav li a').removeClass('current');
		$('#tabcontent').hide('fast',loadContent);
		$('#load').remove();
		$('#wrapper').append('<div id="load">Processing...</div>');
		$('#load').fadeIn('normal');
		
		window.location.hash = tabId;
		
		function loadContent() {
			$('#tabcontent').html('');
			$('#tabcontent').load(toLoad,'',showNewContent)
		}
		function showNewContent() {
			$('#tabcontent').show('fast',hideLoader);
		}
		function hideLoader() {
			$('#load').fadeOut('normal'); 
			doImageDisplays();
		}
		
		$(this).addClass('current');
		
		if(tabId != '105')
		{ $("#site-slider").hide(); } else 
		{ $("#site-slider").show(); }
		
		
		
		return false;
		
	});
	
	
	$("#tabcontent").ajaxComplete(function() {
		var mhash = window.location.hash.substr(1); 
		if(mhash === '107'){ projPlaceholders(); $("#site-slider").hide(); }
	});

});



</script>


<link rel="stylesheet" href="scripts/countdown/jquery.jcountdown.css" type="text/css" />
<script type="text/javascript" src="scripts/countdown/jquery.jcountdown.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#jCountdown").countdown({
		/*htmlTemplate: "%y <span class='cd-time'>years</span> %m <span class='cd-time'>months</span>",*/
		htmlTemplate: "<span class='countdown_row countdown_show4'><span class='countdown_section'><span class='countdown_amount'> %d </span>Days</span><span class='countdown_section'><span class='countdown_amount'> %h </span>Hrs.</span><span class='countdown_section'><span class='countdown_amount'> %i </span>Min.</span><span class='countdown_section'><span class='countdown_amount'> %s </span>Sec.</span></span>",
		date: "october 6, 2016",		
		hoursOnly: false,
		onComplete: function( event ) { $(this).html("Completed"); },
		onPause: function( event, timer ) { $(this).html("Pause"); },
		onResume: function( event ) { $(this).html("Resumed"); },
		leadingZero: true
	});
});
</script>

<?php //include("cart-script.php"); ?>

<?php if($GLOBALS['CONTENT_SHOW_CALENDAR'] == true) {  ?> 
<link rel="stylesheet" href="includes/calendar/eventCalendar.css">
<link rel="stylesheet" href="includes/calendar/eventCalendar_theme_responsive.css">
<script src="includes/calendar/moment.js" type="text/javascript"></script>
<script src="includes/calendar/jquery.eventCalendar.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function($) {
	$("#eventCalendarMember").eventCalendar({
		eventsjson: 'includes/calendar/events.member.php'
		,jsonDateFormat: 'human'
		,dateFormat: 'dddd, MMM DD, YYYY'
		,showDescription: true				
		,openEventInNewWindow: true
		,eventsScrollable: true
	});
});
</script>
<?php } ?>


<?php if($GLOBALS['FORM_KEYTAGS'] == true) {  ?> 
<link rel="stylesheet" type="text/css" href="scripts/tagsinput/jquery.tagsinput.css" />
<script type="text/javascript" src="scripts/tagsinput/jquery.tagsinput.js"></script>
<script type="text/javascript">
jQuery(document).ready(function ($) { if( $('.tags-field').length ) { $('.tags-field').tagsInput({width:'100%'}); }	}); 
</script>
<?php } ?>



<?php if($GLOBALS['SOCIAL_CONNECT'] == true) { ?> 
<!-- #GOOGLE TRANSLATE -->
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script><?php /*?><?php */?>

<?php if($my_redirect <> "contacc.php" and $my_redirect <> "contact.php" and $my_redirect <> "index.php"){ /*$item <> '' and */ ?>
<!-- #ADDTHIS -->
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50f0c76b1a12dd47"></script>
<?php } ?>
<!-- #FACEBOOK CONNECT + COMMENTS -->
<div id="fb-root"></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=104572719635085"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));</script>



<!-- ANALYTICS CODES -->
<!--<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-55373015-2', 'auto'); ga('send', 'pageview');
</script>-->

<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<script type="text/javascript">window.cookieconsent_options = {"message":"<?php echo SITE_TITLE_LONG; ?> uses cookies to ensure you get the best experience on our website.","dismiss":"Got it!","learnMore":"More info","link":"terms-service/","theme":"dark-top"};</script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>
<!-- End Cookie Consent plugin -->

<?php } ?>



<?php //include('classes/inc_pageload_ft.php'); ?>
<?php //include('includes/wrap_poweredby.php'); ?>