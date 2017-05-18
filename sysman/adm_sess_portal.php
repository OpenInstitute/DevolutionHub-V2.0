<?php
require("../classes/cls.constants.php"); 
$dir = 'menus'; //$_GET["d"];
$portal = $_GET["portal"];

$admPortal = $ddSelect->getActivePortal($portal);
//displayArray($admPortal); exit;
$_SESSION['sess_dhub_adm_portal'] = $admPortal;
?>
<script>location.href="home.php?d=<?php echo $dir."&token=".$conf_token; ?>"; </script>