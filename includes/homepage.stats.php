<style type="text/css">
.stats {
  text-align: center;
  text-transform: uppercase;
  margin:10px auto;
}

.stats a {
  text-decoration: none;
}

.stats img {
  margin-bottom: 12px;
  max-width: 45px;
  margin-left: auto; margin-right: auto;
}

.stats h4 {
  color: #666;
  font-size: 16px;
  font-weight: 700;
}

.stats h5 {
  font-family: 'Monda', sans-serif;
  font-size: 32px;
  font-weight: 700;
}

.stats h4:hover {
  color: #999;
}

.stats a:hover {
  text-decoration: none;
}

.people h5, .people h4, .people i:first-child {
  color: #B0BC2A;
}

.cases h5 {
  color: #800080;
}

.orgs h5, .orgs h4, .orgs i:first-child {
  color: #FF5555;
}

.events h5, .events h4, .events i:first-child {
  color: #37abc8;
}

.land h5 {
  color: #419ce8;
}

.cat h5, .cat h4, .cat i:first-child {
  color: #419ce8;
}

.figures {
  margin-top: 24px;
}
.peopleC{
	background-color: red;
}
.lineX {
	width:60%;
	margin:auto;
	border-bottom: 1px dotted #000000;
}
</style>
<?php
	$qd = "SELECT * FROM `dhub_dt_downloads` where  published=1";
	$rd = $cndb->dbQuery($qd);
	$resources = $cndb->recordCount($rd);

	$qry = "SELECT * FROM `dhub_dt_content` where `id_section` = '6' and published=1 and approved=1";
	$res = $cndb->dbQuery($qry);
	$events = $cndb->recordCount($res);

	//$qO = "SELECT * FROM `dhub_conf_organizations` where  published=1";
	$qO = "SELECT `dhub_conf_organizations`.`organization_id`, `dhub_conf_organizations`.`organization` FROM `dhub_conf_organizations` INNER JOIN `dhub_dt_downloads_parent` ON (`dhub_conf_organizations`.`organization_id` = `dhub_dt_downloads_parent`.`organization_id`)WHERE (`dhub_conf_organizations`.`published` =1) GROUP BY `dhub_conf_organizations`.`organization_id`;";
	$rO = $cndb->dbQuery($qO);
	$orgs = $cndb->recordCount($rO);

	//$qC = "SELECT * FROM `dhub_dt_downloads` GROUP BY `content_type`";
	$qC = "SELECT * FROM `dhub_dt_downloads_type` where  published=1";
	$rC = $cndb->dbQuery($qC);
	$cats = $cndb->recordCount($rC);

	

?>
<div class="lineX"></div>
<div class="container stats">
<div class="col-md-3 stats people">
	<a href="resources/">
	<span class="fa-stack fa-3x">
		<i class="fa fa-circle fa-stack-2x"></i>
		<i class="fa fa-file fa-stack-1x fa-inverse"></i>
	</span>
	<h5 class="nopadd"><?php echo $resources; ?></h5>
	<h4 class="nopadd">Resources</h4>
	</a>
</div>
<div class="col-md-3 stats events">
	<a href="events/">
	<span class="fa-stack fa-3x">
		<i class="fa fa-circle fa-stack-2x"></i>
		<i class="fa fa-calendar fa-stack-1x fa-inverse"></i>
	</span>
	<h5 class="nopadd"><?php echo $events; ?></h5>
	<h4 class="nopadd">Events</h4>
	</a>
</div>
<div class="col-md-3 stats orgs">
	<a href="organizations/">
	<span class="fa-stack fa-3x">
		<i class="fa fa-circle fa-stack-2x"></i>
		<i class="fa fa-briefcase fa-stack-1x fa-inverse"></i>
	</span>
	<h5 class="nopadd"><?php echo $orgs; ?></h5>
	<h4 class="nopadd">Organizations / Publishers</h4>
	</a>
</div>
<div class="col-md-3 stats cat">
	<a href="categories/">
	<span class="fa-stack fa-3x">
		<i class="fa fa-circle fa-stack-2x"></i>
		<i class="fa fa-tags fa-stack-1x fa-inverse"></i>
	</span>
	<h5 class="nopadd"><?php echo $cats; ?></h5>
	<h4 class="nopadd">Categories</h4>
	</a>
</div>
</div>