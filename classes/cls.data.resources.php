<?php

class data_devhub extends master
{

	public $barNumbers = array();

	
/* ============================================================================== 
/*	@COUNTIES ARRAY
/* ------------------------------------------------------------------------------ */		
	function get_resCounties($county = '')
	{
		$result = array();
		
		$sq_qry = "SELECT
    `dhub_conf_county`.`county_id`
    , `dhub_conf_county`.`county`
    , `dhub_conf_county`.`county_seo`
    , COUNT(`dhub_dt_downloads_parent`.`resource_id`) AS `num_resources`
FROM
    `dhub_conf_county`
    LEFT JOIN `dhub_dt_downloads_parent` 
        ON (`dhub_conf_county`.`county_id` = `dhub_dt_downloads_parent`.`county_id`)
GROUP BY `dhub_conf_county`.`county_id`
ORDER BY `dhub_conf_county`.`county` ASC;";
		
		$result = $this->dbQueryFetch($sq_qry);		
		
		return $result;
	}
	
	
/* ============================================================================== 
/*	@DOWNLOAD TYPES ARRAY
/* ------------------------------------------------------------------------------ */		
	function get_resTypes($res_type = '')
	{
		$result = array();
		
		$sq_qry = "SELECT
    `dhub_dt_downloads_type`.`download_type`
    , `dhub_dt_downloads_type`.`res_type_seo`
    , COUNT(`dhub_dt_downloads_parent`.`resource_id`) AS `num_resources`
FROM
    `dhub_dt_downloads_type`
    LEFT JOIN `dhub_dt_downloads_parent` 
        ON (`dhub_dt_downloads_type`.`res_type_id` = `dhub_dt_downloads_parent`.`res_type_id`)
GROUP BY `dhub_dt_downloads_type`.`res_type_id` order by `dhub_dt_downloads_type`.`download_type` ASC;";
		
		$result = $this->dbQueryFetch($sq_qry);		
		
		return $result;
	}
	
	
	
	
/* ============================================================================== 
/*	@DROP-DOWN ORGANIZATION MULTI
/* ------------------------------------------------------------------------------ */	
	
	function get_orgMulti($org_opts, $org_selected = '')
	{
		$out 	= '<option value=""></option>';
		$userid = $_SESSION['sess_erp_member']['userid'];
		$this->get_companyList();
		$org_arr = master::$companyArr;
		
		foreach($org_arr as $id => $arr)
		{
			if(in_array($id, $org_opts)){
				$selected = "";
				if($arr['organization_id'] == $org_selected) { $selected = " selected ";} 
				$out .= '<option value="'.$arr['organization_id'].'" '.$selected.'>'.$arr['org_name'].'</option>';
			}
		}
		return $out;
	}
	
	
	
/* ============================================================================== 
/*	@company list array
/* ------------------------------------------------------------------------------ */		
	function get_companyList()
	{
		$result = array();
		if(count(master::$companyArr) == 0)
		{
			$sq_qry = "SELECT * FROM `erp_organization` where `published`=1 ; ";
			$rs_qry = $this->dbQuery($sq_qry);		

			
			while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
			{
				$cn_qry  	= array_map("clean_output", $cn_qry_a);

				$org_id	 	= $cn_qry['organization_id'];
				$org_name	= $cn_qry['org_name'];

				$result[$org_id] = $cn_qry;
			}
			master::$companyArr = $result;
		} else {
			$result = master::$companyArr;
		}
		
		return $result;
	}
	

		
/* ============================================================================== 
/*	@Staff list array
/* ------------------------------------------------------------------------------ */		
	function get_companyStaffList()
	{
		$result = array();
		$user_arr = array();
		
			$sq_qry = "SELECT * FROM `_adminuser` where `published`=1 order by `fname` ASC; ";
			$rs_qry = $this->dbQuery($sq_qry);		
			
			while($cn_qry_a = $this->fetchRow($rs_qry, 'assoc'))
			{
				$cn_qry  	= array_map("clean_output", $cn_qry_a);
				
				$user_id	= $cn_qry['userid'];
				$user_name 	= $cn_qry['fname'].' '.$cn_qry['lname'];
				$user_email	= $cn_qry['email'];
				
				$org_id	 	= $cn_qry['organization_id'];
				$org_multi	= $cn_qry['organization_multi'];
				
				$org_other	= $cn_qry['organization_other'];

				$user_arr[$org_id][$user_id] = array(
					'user_id' 	=> $user_id,
					'user_name' => "".$user_name."", 'user_email' => "".$user_email.""
				);
				
				if($org_multi == 1 and $org_other <> ''){
					$org_other_arr = explode(',', $org_other); 
					foreach($org_other_arr as $org_other_id){
						$user_arr[$org_other_id][$user_id] = array(
							'user_id' 	=> $user_id,
							'user_name' => "".$user_name."", 'user_email' => "".$user_email.""
						);
					}
				}				
			}
		//displayArray($user_arr);
		
		return $user_arr;
	}
	
	
/* ============================================================================== 
/*	@GET CONSULTATION TEAM
/* ------------------------------------------------------------------------------ */	
	
	function consultTeam_options($req_id = '', $org_id = '')
	{
		$result = array();
		$team   = array();
		if($req_id <> ''){
			$sq_team = "SELECT `consult_team` FROM `request_status` WHERE (`request_id` = ".q_si($req_id).");";
			$rs_team = current($this->dbQueryFetch($sq_team));
			if(count($rs_team) == 1){
				$team = explode(",", $rs_team['consult_team']);
			}
		}
		
		$out = '<option value=""></option>';
		
		//$sq_qry = "SELECT `userid`, `fname`, `lname`, `email`, `role_id` FROM `_adminuser` WHERE ( `published` =1) order by `fname` asc;";	
		//$result = $this->dbQueryFetch($sq_qry);	
		
		$users_arr 	= $this->get_companyStaffList();
		$result 	= $users_arr[$org_id]; 
		
		foreach($result as $k => $arr){
			$rec_id 	= $arr['user_id'];
			$rec_title 	= $arr['user_name'];
			$rec_email  = $arr['user_email'];
			
			$selected = "";
			if(count($team)) { if(in_array($rec_id, $team)) { $selected = " checked";}  }
			
			$out .=  '<label class="col-md-6 nopadd "><input type="checkbox" name="invite['.$rec_id.']" id="invite_'.$rec_id.'" '.$selected.' value="'.$rec_email.'" class="require-user" /> '.$rec_title.'</label>';
		}
		return $out;
	}

	
	
	
/* ============================================================================== 
/*	@GET COLUMN NAMES
/* ------------------------------------------------------------------------------ */	
	
	function get_boostColumns()
	{
		$result = array();
		
		$sq_qry = "SELECT `Class`, `Adm1`, `Adm2`, `Adm3`, `Adm4`, `Adm5`, `2015-16-initial-budget`, `2015-16-Reallocation`, `2015-16-final-budget`, `2015-16-final-expenditure`, `2014-15-initial-budget`, `2014-15-Reallocation`, `2014-15-final-budget`,  `2014-15-final-expenditure`FROM `boost_yearly_view`  limit 0, 1";
		$rs_qry = $this->dbQuery($sq_qry);		
		
		$comms = '';
		while ($fieldinfo= mysqli_fetch_field($rs_qry))
		{
			$result[] = $fieldinfo->name; 
		}

		return $result;
	}
	
	
	
	
	
	
	
	
	

/*
* END CLASS
*/	
}


$dispDt = new data_devhub;


?>