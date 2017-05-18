<?php session_start(); ob_start();


	$fn=$_GET['fn'].".xls";
	include_once("../classes/cls.report.excel.php");
	$excel_obj=new ExportExcel("$fn");
	$excel_obj->setHeadersAndValues($_SESSION['report_header'],$_SESSION['report_values']); 
	$excel_obj->GenerateExcelFile();
	
	unset($_SESSION['report_header']);
	unset($_SESSION['report_values']);

?>
