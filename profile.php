<?php require("classes/cls.constants.php"); include("classes/cls.paths.php"); ?>
<?php include("zscript_meta.php"); 

if(!isset($_SESSION['sess_dhub_member']))
{	
	if($this_page == 'profile.php') { header("Location: index.php?qst=199"); }
}
?>

<body>
<?php include("includes/wrap_head.php"); ?>



<div>
	
		<div class="head_width">
		<div class="padd15_0">
		<div class="subcolumns clearfix" style="overflow:visible;">
			
			<div class="col-md-3">
				<div class="padd15_r">
				
				<!--<h3>&nbsp;</h3>-->
				<div class="box-cont">
				<div class="box-cont-title"><?php echo $sess_mbr['u_fname'].' '.$sess_mbr['u_lname']; ?></div>

				<ul class="nav_side">
					<?php echo conf_usAccLinks(2); ?>
				</ul>


				</div>
			
				</div>
			</div>
		
			<div class="c75rX col-md-9">
				<div class="padd15_l" style="min-height:300px;">
				<div id="wrapper" class="">
				<?php
					//displayArray($_SESSION['sess_dhub_member']);
					//echobr($ptab);
				if($ptab == 'resources'){	
					echo display_PageTitle('My Resources');
					include("includes/members/mem_resources.php");
				}
					
				if($ptab == 'profile'){	
					echo display_PageTitle('My Account');
					include("includes/members/mem_profile.php");
				}
					
				if($ptab == 'calendar'){	
					echo display_PageTitle('My Calendar');
					include("includes/members/mem_calendar.php");
				}
				if($ptab == 'members'){	
					echo display_PageTitle('Organization Members');
					include("includes/members/mem_org_members.php");
				}	
					
				if($ptab == 'organization'){	
					echo display_PageTitle('Organization Profile');
					include("includes/members/mem_org_profile.php");
				}	
					
					
				if($ptab == 'org_resources'){	
					echo display_PageTitle('Organization Resources', 'h1');
					include("includes/members/mem_org_resources.php");
				}	
					
					
				if($ptab == 'org_calendar'){	
					echo display_PageTitle('Organization Calendar', 'h1');
					include("includes/members/mem_org_calendar.php");
				}		
				?>
				</div>
				</div>
			</div>

		

		</div>
		</div>
		</div>
	
	
</div>



<?php include("includes/wrap_foot.php"); ?>
<?php include("zscript_vary.php"); ?>




</body>
</html>