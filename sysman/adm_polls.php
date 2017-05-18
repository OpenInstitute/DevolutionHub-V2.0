<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>


<?php

$ths_page="?d=$dir&op=$op";

$f = (@$_GET['f'] != '')? $_GET['f'] : @$_POST['f'];

if($f == 'delete') { //exit;
	if(isset($_GET['qid']) && $_GET['qid']!='') {
		$cndb->dbQuery("DELETE FROM `dhub_poll_questions` WHERE `qid`=".$_GET['qid']);
		if(mysql_errno>0) $err .= mysql_errno().": ".mysql_error()."<br />";
		$cndb->dbQuery("DELETE FROM `dhub_poll_responses` WHERE `qid`=".$_GET['qid']);
		if(mysql_errno>0) $err .= mysql_errno().": ".mysql_error()."<br />";
		$cndb->dbQuery("DELETE FROM `dhub_poll_voters` WHERE `qid`=".$_GET['qid']);
		if(mysql_errno>0) $err .= mysql_errno().": ".mysql_error()."<br />";
		
		if($err!='') {
			echo "<img src=\"surv_error.gif\" /> Sorry, a database error occured.<br />".$err;
		} else {
			echo "<img src=\"surv_success.gif\" /> The survey was deleted successfully.";		
		}
		
	} else if(isset($_GET['rid']) && $_GET['rid']!='') {
		$qid =  $cndb->fetchRow($cndb->dbQuery("SELECT `qid` FROM `dhub_poll_responses` WHERE `rid`=".$_GET['rid']));
		if(mysql_errno>0) $err .= mysql_errno().": ".mysql_error()."<br />";
		
		$cndb->dbQuery("DELETE FROM `dhub_poll_responses` WHERE `rid`=".$_GET['rid']);
		if(mysql_errno>0) $err .= mysql_errno().": ".mysql_error()."<br />";
		if($err!='') {
			echo "<img src=\"surv_error.gif\" /> Sorry, a database error occured.<br />".$err;
			$what = 'list';
		} else {
			echo "<img src=\"surv_success.gif\" /> The answer was deleted successfully.";
			$what = 'show';
		}
		
		echo "<p>Returning to edit form...</p><form name=\"eform\" action=\"?d=online polls&amp;op=edit&amp;id=".$qid[0]."&amp;sf=".$what."\" method=\"post\"><input type=\"hidden\" name=\"qid\" value=\"".$qid[0]."\" /></form><script type=\"text/javascript\">setTimeout(\"postEdit()\",1000);</script>";
		
	}
}	


if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }
		
if($op=="edit"){

	if($id)
	{
	
	$sqdata = "SELECT `qid` AS `id`, `subject`, `question`, `date`, `show` AS `active`, `published`
   FROM 
      `dhub_poll_questions` WHERE  (`qid` = $id)";
	
	
	//echo $sqdata;
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		if($rsdata_count==1)
		{
		$cndata= $cndb->fetchRow($rsdata);
		
		$pgtitle				="<h1>Edit Poll / Survey</h1>";
		
		$qid					= $cndata[0];
		$subject			= html_entity_decode(stripslashes($cndata[1]));
		$question			= html_entity_decode(stripslashes($cndata[2]));
		$date				= $cndata[3];
		
		$show				= $cndata[4]; 
		$published			= $cndata[5]; 
		
		if($published==1) {$published="checked ";} else {$published="";}
		if($show==1) {$show="checked ";} else {$show="";}
		
		$formname			= "poll_edit";
		}
	}


} 
elseif($op=="new")
	{
	
		$pgtitle				="<h2>New Poll / Survey</h2>";
		
		$qid					= "";
		$question		    = "";
		$show				= "checked ";
		$published			= "checked ";
		$formname			= "poll_new";
	}
	
	
 ?>
	<div style="margin:auto; width: 600px;">
	<form action="adm_posts.php" method="post"  id="register" name="create" class="cmxform admform" >
      <?php echo $pgtitle; ?>
	
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
        <table class="full" id="poll_table">
          <tr>
            <td width="150"><label for="firstname"> Make Active?</label></td>
            <td><input type="checkbox" name="current" id="current" <?php echo $show; ?> class="radio" />
              </td>
          </tr>
			<tr>
            <td width="150"><label for="published"> Show in Archives?</label></td>
            <td><input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio" />
              </td>
          </tr>
         <?php /*?> <tr>
            <td><label for="subject"> Subject:</label></td>
            <td><input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" maxlength="50" />
              </td>
          </tr><?php */?>
          <tr>
            <td><label class="required" for="question"> Question:</label></td>

            <td><textarea name="question" id="question" cols="50" rows="2"><?php echo $question; ?></textarea></td>
          </tr>
		  <tbody id="poll_body">
<?php
if($op=="edit"){
	$sq_ans = "SELECT `rid`,`response` FROM `dhub_poll_responses` WHERE `qid` = ".$id." ORDER BY `rid` ASC";
	//echo $sq_ans;
	$rs_ans = $cndb->dbQuery($sq_ans);;
	if(  $cndb->recordCount($rs_ans))
	{
		while($cn_ans =  $cndb->fetchRow($rs_ans)) 
		{		//<div class=\"field\"></div>
			echo "<tr><td><span class=\"label\">Answer: <img src=\"../apps/survey/surv_delete.gif\" /> <a href=\"?f=delete&amp;rid=".$cn_ans[0]."\" onClick=\"return confirm('Are you sure?')\">Remove</a></span></td><td><span class=\"box\"><input type=\"text\" name=\"ans".$cn_ans[0]."\" cols=\"50\" value=\"".$cn_ans[1]."\" maxlength=\"50\"></span></td></tr>";
			$max = $cn_ans[0];			
		}
	}
	$max++;
}
else
{	$max = 0; }
?>		  
			</tbody>
		  <tfoot>
          <tr>
		  <td><img src="../apps/survey/surv_add.gif" /> <a href="javascript:void(0)" onClick="addField()">Add Answer</a></td>
		  <td></td>
		  </tr>
          <tr>
			  <td>&nbsp;</td>
			  <td>
					<input type="submit" name="submit" value="Save Details" />	
					<input type="hidden" name="formname"  value="<?php echo $formname; ?>" />
					<input type="hidden" name="qid" value="<?php echo $id; ?>" />
					<input type="hidden" name="redirect" value="<?php echo "home.php?d=".$dir; ?>" />
					<input type="hidden" name="next" id="next" value="<?php echo $max;?>" />
			  </td>
		  </tr>
		  </tfoot>
        </table>
      </div>
	  </form>
	</div>
	
</div>
<!-- @end :: content area -->

</div>
</div>

<script type="text/javascript">

function addField() {
	var next = parseInt(getObject("next").value);
  	var newid = "field"+next;
	var newname = "ans"+next;
	
	$(document).ready(function(){
		var parent = $("#poll_body");
		var ansAdd = "<tr id=\""+newid+"\" class=\"field\"><td><span class=\"label\">Answer: <img src=\"../apps/survey/surv_delete.gif\" /> <a href=\"javascript:void(0)\" onclick=\"removeField('"+newid+"')\">Remove<\/a><\/span><\/td><td><span class=\"box\"><input type=\"text\" name=\""+newname+"\" maxlength=\"50\" value=\"\"><\/span><\/td>";
		parent.append(ansAdd);
		
	});
	
	next++;
	getObject("next").value=next;
}

function removeField(obj) {
	$(document).ready(function(){
		var parent = $("#poll_body"); 
		$("#"+obj).remove();
	});
}

function getObject(obj) {
	var o;
	
	if(document.getElementById) o = document.getElementById(obj);
	else if(document.all) o = document.all[obj];	
	else if(document.layers) o = document.layers[obj];
	
	return o;
}

function postEdit() {
	document.eform.submit();
}
</script>


</body>
</html>
