<div class="middle" style="width:600px; margin:0 auto;">

<?php
$query = "SELECT * FROM `dhub_poll_questions` WHERE `qid`=".$id." LIMIT 1";
$result = $cndb->dbQuery($query);
$row = $cndb->fetchRow($result);		
?>


<form method="post" action="?f=edit&amp;sf=save">
		<input type="hidden" name="qid" value="<?=$row['qid'];?>" />
		<div id="fields">
			<div class="field"><span class="label">Make Active?</span><span class="box"><input type="checkbox" name="current" <? if($row['show']>0) echo "checked";?> /></span></div>
			<div class="field"><span class="label">Show in Archives?</span><span class="box"><input type="checkbox" name="published" <? if($row['published']>0) echo "checked";?> /></span></div>
			<div class="field"><span class="label">Subject:</span><span class="box"><textarea name="subj" cols="50" rows="2"><?=$row['subject'];?></textarea></span></div>
			<div class="field"><span class="label">Question:<br /><img src="surv_delete.gif" /> <a href="?f=delete&amp;qid=<?=$row['qid'];?>" onClick="return confirm('Answers will also be deleted, are you sure?')">Remove</a></span><span class="box"><textarea name="ques" cols="50" rows="2"><?=$row['question'];?></textarea></span></div>
<?php			
		$query2 = "SELECT `rid`,`response` FROM `dhub_poll_responses` WHERE `qid` = ".$row['qid']." ORDER BY `rid` ASC";
		$result2 = $cndb->dbQuery($query2);
		while($row2 = $cndb->fetchRow($result2)) {
			echo "<div class=\"field\"><span class=\"label\">Answer:<br /><img src=\"surv_delete.gif\" /> <a href=\"?f=delete&amp;rid=".$row2['rid']."\" onClick=\"return confirm('Are you sure?')\">Remove</a></span><span class=\"box\"><textarea name=\"ans".$row2['rid']."\" cols=\"50\" rows=\"2\">".$row2['response']."</textarea></span></div>";
			$max = $row2['rid'];			
		}
		
		$max++;
?>
       
  </div>


<?php /*?> <form action="adm_posts.php" method="post"  id="register" name="create" class="cmxform admform" >
      <b style="margin-bottom: 2px; display: block;">Personal Details</b>

      
      <b style="margin-bottom: 2px; display: block;">Newsletter</b>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;"></div>
            <div class="buttons">
        <table class="full" border="0">
          <tr>
            <td  style="padding-right: 5px; width:170px">&nbsp;</td>
            <td>
			<input type="submit" name="submit" value="Save Details" />	
			<input type="hidden" name="formname"  value="<?php echo $formname; ?>" />
		  <input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="redirect" value="<?php echo "home.php?d=".$dir; ?>" />
		   </td>
          </tr>
        </table>
      </div>
  </form><?php */?>