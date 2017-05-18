<?php
require("../classes/cls.condb.php"); 

	function displayArray($array)    { echo "<pre>"; print_r($array); echo "</pre><hr />"; }
	
	$db = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die ('Could not connect to the database.');
	mysql_select_db(DB_NAME);



	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'id', 'account_name', 'account_category', 'contacts', 'telephone', 'email', 'county', 'location', 'account_speciality', 'published' );
	
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id";
	
	/* DB table to use */
	$sTable = "dhub_app_vw_directory";

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
	//$sLimit = "LIMIT 0, 15";
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
				 	mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	
	
	$sQuery = "SELECT SQL_CALC_FOUND_ROWS `id`, `account_name`, `account_category`, `contacts` , `telephone`, `email`,`county`, concat_ws(' ' , `sub_county` , `location`) as `location` , `account_speciality`, `published` 
	FROM $sTable 
	$sWhere
	$sOrder
	$sLimit
	"; 
	$rResult 	= $cndb->dbQuery($sQuery); 
	
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = $cndb->dbQuery( $sQuery) ;
	$aResultFilterTotal = $cndb->fetchRow($rResultFilterTotal);
	$iFilteredTotal     = $aResultFilterTotal[0];


	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	$rResultTotal = $cndb->dbQuery( $sQuery ) ;
	$aResultTotal = $cndb->fetchRow($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	
	while ( $aRow = $cndb->fetchRow( $rResult ) )
	{
		$row = array();
		//$row['DT_RowClass'] = 'check_'.$aRow['id'];
		$row['check_id'] = 'check_'.$aRow['id'];
		
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			//
			if ( $aColumns[$i] == "id" )
			{
				$row[] = '<input type="checkbox" class="selCheck" id="check_'.$aRow[''.$sIndexColumn.''].'" name="check['.$aRow[''.$sIndexColumn.''].']" value="'.$aRow[''.$sIndexColumn.''].'" >'; 
			}
			
			elseif ( $aColumns[$i] == "account_name" )
			{
				$row[] = '<a href="?id='.$aRow[''.$sIndexColumn.''].'">'.$aRow[$aColumns[$i]].''; 
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
		
	
?>