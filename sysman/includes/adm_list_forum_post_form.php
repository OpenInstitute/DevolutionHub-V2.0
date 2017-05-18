
  
<?php

$sq_edit = "SELECT
    `dhub_forum_posts`.`post_id`
    , `dhub_forum_posts`.`post_date`
    , `dhub_forum_posts`.`post_content`
    , `dhub_forum_topics`.`topic_id`
    , `dhub_forum_topics`.`topic_subject`
    , concat_ws(' ',`dhub_reg_users`.`firstname`, `dhub_reg_users`.`lastname`) as `post_owner`
    , `dhub_forum_posts`.`post_published`
FROM
    `dhub_forum_posts`
    INNER JOIN `dhub_forum_topics` 
        ON (`dhub_forum_posts`.`post_topic` = `dhub_forum_topics`.`topic_id`)
    LEFT JOIN `dhub_reg_users` 
        ON (`dhub_forum_posts`.`post_by` = `dhub_reg_users`.`id`)
WHERE (`dhub_forum_posts`. `post_id` = ".mysql_real_escape_string($entry_id).") ; ";

$rs_edit = $cndb->dbQuery($sq_edit);
			
if($rs_edit)
{
	$cn_edit 		   = $cndb->fetchRow($rs_edit, 'assoc');

	$post_id		  = $cn_edit['post_id'];
	$post_date		  = date('d-m-Y', strtotime($cn_edit['post_date']));
	$post_content  		= trim(html_entity_decode(stripslashes($cn_edit['post_content'])));
	$topic_subject  		= trim(html_entity_decode(stripslashes($cn_edit['topic_subject'])));
	$post_pub		  = $cn_edit['post_published'];
	$post_owner	      = trim(html_entity_decode(stripslashes($cn_edit['post_owner'])));
	
	$post_published_y   = '';
	$post_published_n   = '';
	if($post_pub == 1) { $post_published_y = ' checked '; }
	if($post_pub == 0) { $post_published_n = ' checked '; }	//value="0"
		
}

		
?>
<form method="post" action="adm_forum_posts.php?d=<?php echo $dir; ?>" class="fm_base admform" name="edit_posts" id="edit_posts">
<input type="hidden" name="formname" value="forum_edit_posts" />
<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" /> 
<input type="hidden" name="f_ac_id" value="<?php echo $id; ?>" /> 
<input type="hidden" name="dir" value="<?php echo $dir; ?>" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="width:150px;">Post Brief</td>
		<td>by <strong><?php echo $post_owner; ?></strong> - <?php echo $post_date; ?></td>
	</tr>
	<tr>
		<td>Post Contents</td>
		<td><textarea name="post_content" id="post_content" class="wysiwyg" style="height:300px" /><?php echo $post_content; ?></textarea></td>
	</tr>
	
	
	<tr>
		<td>Parent Topic</td>
		<td><?php echo $topic_subject; ?></td>
	</tr>
	<tr>
		<td nowrap="nowrap">Publish Post:</td>
		<td>
		<label><input type="radio" id="published_y" name="published" <?php echo $post_published_y; ?> value="on" class="radio"/> Yes</label>
		<label><input type="radio" id="published_n" name="published" <?php echo $post_published_n; ?> value="off" class="radio"/> No</label>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Submit" /></td>
	</tr>
</table>
</form>