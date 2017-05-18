<?php //echo $my_redirect;
$crumbpadd = 'breadcrumbpadd';
if(  $my_redirect == 'index.php' or  $my_redirect == 'result.php' or $my_redirect == 'mailing.php' or $my_redirect == 'search.php' or $my_redirect == 'accounts.php' or $my_redirect == '404X.php') 
{ $my_breadcrumb = ''; $crumbpadd = 'padd0';}
if($my_breadcrumb <> '') {
 ?>	
	
	<div> <div class="breadcrumb">
	<!-- @beg:: bcrumbs -->
		<div class="page_width">
		<div class="subcolumns">
			<div class="c75l"><div class="<?php  echo $crumbpadd;  ?>"><?php  echo $my_breadcrumb;  ?></div></div>
			<div class="c25r">
				
			</div>
			
		</div>
		</div>
	
	
	<!-- @end:: bcrumbs -->	
	</div>
	</div>
<?php } ?>
<!-- @beg:: alert -->	
<?php //if($this_page <> 'result.php') {  include("includes/wrap_alert.box.php"); } ?>
<!-- @end :: alert -->

