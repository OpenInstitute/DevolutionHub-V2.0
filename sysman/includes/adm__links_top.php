<div style="background:#FFE9CC; padding:0px 5px 0px; margin-bottom:0px;" id="menu_wrapX">

<?php 
$forPortalRoot = '';
if($adm_portal_id <> 1)
{ $forPortalRoot = ' style="display:none;"'; }

?>
<ul id="nav_main" class="sf-menu sf-arrows">
	<LI><A href="home.php?d=menus&tk=<?php echo $token; ?>"> Navigation</A>
        <UL>
			<li><a href="home.php?d=menus&tk=<?php echo $token; ?>" id="nvm_menus"> Menus List</a></li>
			<li><a href="adm_menus.php?d=menus&op=new&tk=<?php echo $token; ?>"> NEW MENU</strong></A></li>
        </UL>
	</LI>
	<LI><A href="home.php?d=contents&tk=<?php echo $token; ?>"> Contents</A>
        <UL>
			<li><A href="home.php?d=contents&tk=<?php echo $token; ?>" id="nvm_contents"> Content List</A></li>
			<li><a href="home.php?d=events&tk=<?php echo $token; ?>" id="nvm_events"> Events List</a></li>
			<li><strong>&nbsp;</strong></li>
			<li><a href="adm_articles.php?d=contents&op=new&tk=<?php echo $token; ?>">NEW CONTENT</strong></A></li>	
			<li><a href="adm_events.php?d=events&op=new&tk=<?php echo $token; ?>">NEW EVENT</strong></A></li>
			<!--<li><a href="hforms.php?d=profiles&op=new&tk=<?php echo $token; ?>"> NEW PROFILE</a></li>-->
        </UL>
	</LI>
	
	
	
	
	<li class="sep">&nbsp;</li>
	<li class="sep">&nbsp;</li>
	<li class="sep">&nbsp;</li>
    <LI><A href="home.php?d=image and video uploads&tk=<?php echo $token; ?>">Galleries</A>
        <UL>
			<li><a href="adm_gallery_singles.php?d=image and video uploads&op=new&tk=<?php echo $token; ?>">ADD NEW</strong></A></li>			
			<?php /*?><li><a href="home.php?d=content galleries&tk=<?php echo $token; ?>">Content Galleries</strong></A></li>
            <li><a>----------</a></li><li><a href="home.php?d=image and video uploads&tk=<?php echo $token; ?>">Image & Video Uploads</a></li>  
			<li><a>----------</a></li>
			<li><a href="home.php?d=partner logos&tk=<?php echo $token; ?>">Partner Logos</strong></A></li>  <?php */?>		
        </UL>
	</LI>
	
    <LI><A href="home.php?d=resource library&tk=<?php echo $token; ?>">Resource Library</A>
        <UL>
			<li><a href="adm_downloads.php?d=resource library&op=new&tk=<?php echo $token; ?>">ADD NEW</strong></A></li>			
        </UL>
	</LI>
    <li class="sep">&nbsp;</li>    
    <li class="sep">&nbsp;</li>
	<li class="sep">&nbsp;</li>
   
   
	 
    
	
	<LI><A >User Management</A>
        <UL>
			<li><a href="home.php?d=feedback posts"> Feedback Posts </a></li>     
			<li><a>----------</a></li>
			<li><a href="home.php?d=registered accounts&tk=<?php echo $token; ?>"> Member Accounts  </a></li>	
       		<li><a href="home.php?d=organizations&tk=<?php echo $token; ?>"> Organizations  </a></li>			
        </UL>
	</LI>
	
	
	
	
	
	<li class="sep">&nbsp;</li>
	<li class="sep">&nbsp;</li>
	<li class="sep">&nbsp;</li>
	
	
	<!--<LI><A>Tools</A>
        <UL>
			<li><a href="home.php?d=online polls"> Online Polls </a></li>
        </UL>
	</LI>-->
	
	<li class="sep">&nbsp;</li>
	<li class="sep">&nbsp;</li>
    
    
    <?php if (isset($sys_us_admin['actype_id']) and $sys_us_admin['actype_id'] ==1 ) { ?>
	<li class="sep">&nbsp;</li>
	<li class="sep">&nbsp;</li>
	<LI><A href="#" style="text-transform:uppercase">Admin Modules</A>
	
		<UL>
			
			<li><a href="home.php?d=accounts categories"> Account Categories </a></li>
			<?php /*?><li><a>----------</a></li><?php */?>
            <li><A href="home.php?d=admin accounts">Admin Accounts</A></li>
        </UL>
	</LI>
	<?php } ?>
	
	
		
</ul>
</div>