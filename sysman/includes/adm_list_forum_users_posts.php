<?php

$crit_list 	  = "";


if($id) 
{ 


$sq_list = "SELECT
    `dhub_forum_posts`.`post_id`
    , `dhub_forum_posts`.`post_date`
    , `dhub_forum_posts`.`post_content`
    , `dhub_forum_topics`.`topic_id`
    , `dhub_forum_topics`.`topic_subject`
    , concat_ws(' ',`dhub_reg_users`.`firstname`, `dhub_reg_users`.`lastname`) as `post_owner`
	, `dhub_forum_posts`.`post_by`
    , `dhub_forum_posts`.`post_published`
FROM
    `dhub_forum_posts`
    INNER JOIN `dhub_forum_topics` 
        ON (`dhub_forum_posts`.`post_topic` = `dhub_forum_topics`.`topic_id`)
    LEFT JOIN `dhub_reg_users` 
        ON (`dhub_forum_posts`.`post_by` = `dhub_reg_users`.`id`) 
	 WHERE (`dhub_forum_posts`.`post_by` = ".quote_smart($id).")
ORDER BY `dhub_forum_posts`.`post_date` DESC, `dhub_forum_posts`.`post_published` ASC;";

$rs_list = $cndb->dbQuery($sq_list);
			
if(!$rs_list)
{
	echo '<p>Posts list could not be displayed, please try again later.</p>';
}
else
{
	/*echo '<form action="#" method="post" id="adm_forum_posts">
		<div style="padding:10px;"><label><input type="checkbox" name="check_all" id="check_all" > Check All &nbsp; &nbsp; &nbsp;</label>
		<select name="fm_selection" id="fm_selection">
		<option value="" selected="selected">With Selected</option>
		<option value="posts_approve">Publish</option>		
		</select>
		<input type="submit" value="go" />
		</div>
	';*/
	/*class="topic tims" id="gradient-style"*/
	echo '<table class="display" id="example" border="0" cellpadding=0 cellspacing=0 width="100%">
	<thead><tr>
			<th style="min-width:10%">Post Date</th>
			<th style="min-width:50%">User Post</th>
			<th style="min-width:30%">Forum Topic</th>
			<th style="min-width:5%" title="Published">Published</th>
			<th></th>
		</tr></thead><tbody>';
					
	while($cn_list = $cndb->fetchRow($rs_list, 'assoc'))
	{
		$post_id		  = $cn_list['post_id'];
		$post_date		  = date('M d Y H:i', strtotime($cn_list['post_date']));
		$post_content  	 = strip_tags(trim(html_entity_decode(stripslashes($cn_list['post_content']))));
		$post_content	 = substr($post_content,0,80)."...";
		$post_owner  	    = trim(html_entity_decode(stripslashes($cn_list['post_owner'])));
		$post_pub		 = $cn_list['post_published'];
		$post_by	      = $cn_list['post_by'];
		$topic_id		  = $cn_list['topic_id'];
		
		$topic_subject   = substr(trim(html_entity_decode(stripslashes($cn_list['topic_subject']))),0,50);
		
			$post_topic	   = '';
		if($ftopic == '') {
		$post_topic  = '<td><div class="jtrunc">'.$topic_subject .'</div></td>';
		}
		
		
		if($post_pub == 0) { $post_pub = '<img src="image/off.png" />'; }
		if($post_pub == 1) { $post_pub = '<img src="image/on.png" />'; }
		
		
		$post_item = '<div class="jtrunc">' .$post_content. '<a href="topic.php?id=' .$topic_id. '"></a></div>'; 
		
		echo '<tr>
				<td>' .$post_date. '</td>
				<td>' .$post_item. '</td>
				' .$post_topic. '
				<td>' .$post_pub. '</td>
				<td><a href="?d='.$dir.'&op=view&id=' .$post_by. '&post_id=' .$post_id. '">View</a></td>
			  </tr>';
	}
	
	echo '</tbody></table>';
}

}
//&radic; = √ 
?> 