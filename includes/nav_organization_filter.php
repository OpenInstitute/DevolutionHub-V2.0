<?php
//$filter = $_REQUEST['filter'];

$partnerAlphabet = '';
$current_all = ($filter == '') ? 'class="txtred bold" ' : '';

$partnerAlphabet = '<div class="subcolumns infoX important marg20_t marg20_b txtcenter">';			
$partnerAlphabet .= '<a href="organizations.php?" '.$current_all.'>ALL</a> &nbsp;&bull;&nbsp; ';
	foreach (range('a', 'z') as $char) 
	{
		if($filter == $char) { $current = 'class="txtred bold" '; } else { $current = '';}
	 $partnerAlphabet .= '<a href="organizations.php?filter=' . $char . '" '.$current.'>' . strtoupper($char) . '</a> &nbsp;&bull;&nbsp; ';
	}	
$partnerAlphabet .= '</div>';


echo $partnerAlphabet;
?>