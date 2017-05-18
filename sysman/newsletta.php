<?php 
include("../classes/cls.defines.php");
include("../classes/cls.paths.php"); 



	function myTruncate($string, $limit = 250, $break=".", $pad=" ", $useBreak="yes", $useHoverText=1)
	{
	  $fieldHoverText = "";
	  
	  $str_len = strlen($string);
	  
	  if( $str_len <= $limit) { return $string; exit; }
	
	  if($useBreak == "yes")
	  {
		  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
			if($breakpoint < strlen($string) - 1) {
			  $string = substr($string, 0, $breakpoint) . $pad;
			}
		  }
	  }
	  else
	  {
			$string = "<span title='".$fieldHoverText."'>". substr($string, 0, $limit) . $pad ."</span>";
	  }
	  
	  return $string;
	}
	
	function restoreTags($input)
	{
		$opened = array();		
		// loop through opened and closed tags in order
		if(preg_match_all("/<(\/?[a-z]+)>?/i", $input, $matches)) {
		  foreach($matches[1] as $tag) {
			if(preg_match("/^[a-z]+$/i", $tag, $regs)) {
			  // a tag has been opened
			  if(strtolower($regs[0]) != 'br') $opened[] = $regs[0];
			} elseif(preg_match("/^\/([a-z]+)$/i", $tag, $regs)) {
			  // a tag has been closed
			  unset($opened[array_pop(array_keys($opened, $regs[1]))]);
			}
		  }
		}
		// close tags that are still open
		if($opened) {
		  $tagstoclose = array_reverse($opened);
		  foreach($tagstoclose as $tag) $input .= "</$tag>";
		}		
		return $input;
	}

/* ********************************************************** */
/* END ----- @FUNCTION: Truncate							  */
/* ********************************************************** */




function compile_emails($addresses, $subject) //, $msgcontent
{
	//print_r($addresses);
	/* ====================
	  @@ DB
	 ==================== */

	$h 	= 'localhost';
	/*$d 	= 'db_lygacy';
	$u 	= 'root';
	$p 	= 'mysqladmin';*/
	
	$d 	= DB_NAME;
	$u 	= DB_USER;
	$p 	= DB_PASSWORD;
	
	$link_rs = mysql_connect ($h, $u, $p) or die ("Could not connect to database, try again later");
	mysql_select_db($d, $link_rs);
	$link_cn = $link_rs;
	
	
	/* ====================
	 @@ DOMAIN
	 ==================== */
	
	//$site_name = '/'.SITE_DOMAIN_URI.'/';
	$site_name = '/';
	$dom_url = 'http://'.$_SERVER['HTTP_HOST'].$site_name;
	//echo $dom_url;


	/* ====================
	/* @@ VARIABLES
	/* ==================== */
	
	$copies			= count($addresses); //echo $copies;
	$content_guts	= "";
	
	
		$sq_nws_scroll = QRY_MENUCONTENTSB . " WHERE (`dhub_dt_content`.`published` = 1) and	 (`dhub_dt_content_parent`.`id_parent` = 54)   order by `dhub_dt_content`.`seq`  ";
		
		//echo $sq_nws_scroll;
		
		$rs_nws_scroll		= $cndb->dbQuery($sq_nws_scroll, $link_cn);
		$rs_nws_scroll_count=  $cndb->recordCount($rs_nws_scroll);
		
		if($rs_nws_scroll_count>=1)
		{
			$lnk_prod_pager = '';
			$lnk_prod_cont	= '';
			$lnk_page		= 1;
			
			while($cn_nws_scroll=$cndb->fetchRow($rs_nws_scroll))
			{
				$item_id		= stripslashes($cn_nws_scroll[0]); 
				$item_title		= html_entity_decode(stripslashes($cn_nws_scroll[1]));
				$item_desc_plain= strip_tags(trim(html_entity_decode(stripslashes($cn_nws_scroll[5]))),"<p>");
				$item_desc		= myTruncate($item_desc_plain, 550, ".", " ...", "yes", 0);
				$item_desc		= restoreTags($item_desc);
				
				$item_url		= html_entity_decode(stripslashes($cn_nws_scroll[9]));
				$item_com 		= $dom_url.$item_url.RDR_REF_BASE.'&item='.$item_id;
				$spanarea 		= "";
				
				
$lnk_prod_cont 	.= '<tr><td align="justify"><div><font face="lucida grande,tahoma,verdana,arial" size="4" color="#d1102a"> <strong>'. $item_title.'</strong></font></div><div><font face="lucida grande,tahoma,verdana,arial,sans-serif" size="2" color="#444444" style="font-family:lucida grande,tahoma,verdana,arial,sans-serif; line-height:20px; font-size:12px; color:#444444;">'.$item_desc. '</font></div><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td></td><td align="right"><a href="'.$item_com.'" target="_blank"><font color="#72B63B" size="1">[ read more ]</font></a></td></tr></table><p>&nbsp;</p></td></tr>';
				$lnk_page	+= 1;
			}
		
		$content_guts = '<table width="100%" cellpadding="4" cellspacing="4" border="0"><tbody>'.$lnk_prod_cont.'</tbody></table>';
		}


$content = '<html><head><title>Untitled Document</title></head><body><table width="700" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td height="10" width="10" bgcolor="#618442" valign="top"><img src="'.$dom_url.'nletter/c_top_l.png" height="10" width="10" /></td><td colspan="3" rowspan="2" bgcolor="#618442"><table width="100%" border="0" cellspacing="0" cellpadding="5"><tr><td><font face="lucida grande,tahoma,verdana,arial,sans-serif" size="2" color="#8bf5f5"><a href="'.$dom_url.'newsletter.php?com=6&com2=49&com3="  target="_blank"><font face="lucida grande,tahoma,verdana,arial,sans-serif" size="2" color="#ede899" style="font-family:lucida grande,tahoma,verdana,arial,sans-serif; line-height:20px;font-size:11px; color:#ede899;"><strong>Web version</strong></font></a>&nbsp;&nbsp;|&nbsp; <a href="'. $dom_url .'" target="_blank"><font face="lucida grande,tahoma,verdana,arial,sans-serif" size="2" color="#ede899"  style="font-family:lucida grande,tahoma,verdana,arial,sans-serif; line-height:20px;font-size:11px; color:#ede899;"><strong>Update preferences</strong></font></a>&nbsp;&nbsp;|&nbsp; <a href="'.$dom_url.'" target="_blank"><font face="lucida grande,tahoma,verdana,arial,sans-serif" size="2" color="#ede899"  style="font-family:lucida grande,tahoma,verdana,arial,sans-serif; line-height:20px;font-size:11px; color:#ede899;"><strong>Unsubscribe</strong></font></a>	</font>		</td><td>&nbsp;</td></tr></table>	</td><td height="10" width="10" align="right" bgcolor="#618442" valign="top"><img src="'.$dom_url.'nletter/c_top_r.png" height="10" width="10" align="right" /></td></tr><tr bgcolor="#618442"><td width="10"></td><td width="10"></td></tr><tr bgcolor="#72B63B"><td colspan="5"><img src="'.$dom_url.'nletter/sascologo.200605.jpg" width="494" height="201" alt="Nazareth Hospital Kenya" title="Nazareth Hospital Kenya"></td></tr><tr><td width="10" rowspan="2" bgcolor="#e2e2e2"></td><td width="140" rowspan="2" bgcolor="#e2e2e2">&nbsp;</td><td width="10" rowspan="2" bgcolor="#e2e2e2"></td><td width="470">&nbsp;</td><td width="10" style="border-right:1px solid #e2e2e2;"></td></tr><tr><td>'. $content_guts	.'</td><td style="border-right:1px solid #e2e2e2;"></td></tr><tr><td width="10" bgcolor="#e2e2e2"></td><td bgcolor="#e2e2e2">&nbsp;</td><td width="10" bgcolor="#e2e2e2"></td><td>&nbsp;</td><td style="border-right:1px solid #e2e2e2;"></td></tr><tr bgcolor="#618442"><td></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr><tr bgcolor="#618442"><td></td><td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="5"><tr><td valign="bottom"><font face="lucida grande,tahoma,verdana,arial,sans-serif" size="2" color="#e2e2e2"  style="font-family:lucida grande,tahoma,verdana,arial,sans-serif; line-height:20px;font-size:11px;  color:#e2e2e2;"><p>You are receiving this because you are in the SASCO or ACAL mailing list</p><a href="'.$dom_url.'" target="_blank"><font face="lucida grande,tahoma,verdana,arial,sans-serif" color="#ede899"><strong>Edit your subscription</strong></font></a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="'.$dom_url.'" target="_blank"><font face="lucida grande,tahoma,verdana,arial,sans-serif"  color="#ede899"><strong>Unsubscribe</strong></font></a>		</font>		</td><td width="15%" align="right" valign="bottom">&nbsp;</td><td width="40%" align="right" valign="bottom"><font face="lucida grande,tahoma,verdana,arial,sans-serif" size="1" color="#ede899" style="font-family:lucida grande,tahoma,verdana,arial,sans-serif; line-height:20px;font-size:11px;  color:#ede899;">Nazareth Hospital Kenya, SASCO &bull;Hosted by Alpex Consulting Africa Limited &bull;#4 Victoria Office Suites, Riverside Drive &bull;<br>Phone: (254) 703 799 561<br>Email: <a href="mailto:info@nazarethhospital.or.ke"><font face="lucida grande,tahoma,verdana,arial,sans-serif" color="#ede899">info@nazarethhospital.or.ke</font></a><br>Web: <a href="http://www.nazarethhospital.or.ke" target="_blank"><font face="lucida grande,tahoma,verdana,arial,sans-serif" color="#ede899">www.nazarethhospital.or.ke</font></a>		</font>		</td></tr></table>	</td><td></td></tr><tr><td height="10" width="10" bgcolor="#618442" valign="bottom"><img src="'.$dom_url.'nletter/c_btm_l.png" height="10" width="10" /></td><td bgcolor="#618442"></td><td bgcolor="#618442"></td><td bgcolor="#618442"></td><td height="10" width="10" bgcolor="#618442" align="right" valign="bottom"><img src="'.$dom_url.'nletter/c_btm_r.png" height="10" width="10" align="right" /></td></tr></table><br></body></html>';



	$sender_name = "SASCO Newsletter";
	$title		= trim($subject);
	

	foreach($addresses as $ad_email)
	{
		$email		= trim($ad_email); 
		
		$headers  = 'MIME-Version: 1.0' . "\r\n"; 				// To send HTML mail, the Content-type header must be set
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: '.$sendto. "\r\n";	// Additional headers
		$headers .= 'From: no-reply@nazarethhospital.or.ke' . "\r\n";
		
		//echo "<hr>".$email."<br>".$subject."<br>".$content; //exit;
			
		if( mail($email, $title, $content, $headers))
		{ $nmail .= $email ." - Sent <br>"; } else { $nmail .= $email ." - Failed <br>"; }
		sleep(2);
	}
	
	return $nmail;
}