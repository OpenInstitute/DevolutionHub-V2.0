
<?php

$contArr = array();
$gutsArr = array();

$contCom = (count(@master::$menuToContents[$com_active])>0) ? master::$menuToContents[$com_active] : array();

if($comMenuSection == 6){	
	$contSec = master::$contMain['section'][$comMenuSection];
	
	foreach($contSec as $kk => $vv){
		if(!array_key_exists($kk, @$contCom)){
			$contCom[$kk] = $vv;
		}
	}
}
$contNumber = count($contCom); 

if($contNumber == 0)
{
	echo display_PageTitle($my_page_head, '');
}
else
{
	if($item) 	{	$contArr[$item] 	= $contCom[$item]; }
	else 		{	 $contArr 	=  $contCom; }



if(count($contArr) == 1) {
	$contKey 		= current($contArr); 	
	
	$gutsArr 		= master::$contMainNew[$contKey];
	//displayArray( $gutsArr);
	$item 		   = $gutsArr['id'];	
	$artSection 	 = $gutsArr['id_section'];
	$artTitle 	   = $gutsArr['title'];
	$artTitleSub 	= $gutsArr['title_sub'];
	$artArticle	 = $gutsArr['article'];
	$artStamp	   = $gutsArr['modified'];
	$artLocation	= $gutsArr['location'];
	$artBooking	 = $gutsArr['booking'];
	$artBooking_amount = $gutsArr['booking_amount'];
	
	$nicedate       = array();
	$artEventData   = '';
	
	if($artSection == 6) 
	{
		$artDates	   = $gutsArr['event_dates'];
		if(is_array($artDates) and count($artDates)) {
			foreach($artDates as $dateArr) {
				$nicedate[] = '&nbsp; &bull; &nbsp; '. date('l M d, Y',$dateArr['ev_date']).' '.$dateArr['ev_time_start'].' - '.$dateArr['ev_time_end'] . '';
			}
		}
		
		$artEventData   .= '<h4><u>When:</u></h4><div class="bold">'. implode('<br>', $nicedate) .'</div><br>';
		$artEventData   .= '<h4><u>Where:</u></h4><div><strong>&nbsp; &bull; &nbsp; '.$artLocation.'</strong></div><br>';
		$artEventData   .= '<h4><u>Details:</u></h4>';
		
		if($artBooking == 1 and $artBooking_amount > 0) {
			$artEventData   .= '<h6>Charges:</h6><div><strong>'.$artBooking_amount.'</strong><p>&nbsp;</p></div>';	
		}
			
	}
	
	
	if(preg_match('/<img[^>]+\>/i',$artArticle,$regs)) { 
		if(count($regs) > 0)
		{
			$artArticle 	  = str_replace('"image/', '"'.SITE_DOMAIN_LIVE.'image/', $artArticle);
		}
	} 
	
	$breakStart 	     = 200;
	$string	     = $artArticle;
	$pageLoops	  = ceil((strlen($string) / $breakStart)); 
	$start = 0;
	
	$title_sub	  = '';
	$title_date	 = '';
	
	echo '<div class="article-area"><div id="articleContent">';
	echo display_PageTitle($artTitle);
	
	include("includes/inc.gallery.cont.php");
	
	
	if($artSection == 2 or $artSection == 12)  
	{	//NEWS
		$title_date = '<div class="info noborder padd2 padd15_l"><span class="postDate nocaps txt11">Updated: '.$artStamp.'</span></div>';}
	
	
	echo '<div class="main-guts">'. $title_date . $artEventData . $artArticle.'</div>';	//$title_sub .
	
	
	
	echo '</div></div>';	
	
	//include("includes/nav_downloads_cont.php");
	
	//include("includes/form_comment.php");
	
}
else
{
	include("includes/inc.cont.main.list.php");
}



if(count($contArr) == 1 and $this_page <> "contacc.php" and $this_page <> "contact.php")
{ include("includes/nav_social_share.php"); }

}
?>
