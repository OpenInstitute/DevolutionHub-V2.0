<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js"> <![endif]-->

<head>
<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">  
<meta name="title" content="<?php echo $thisSite; ?>">
<meta name="description" content="<?php echo $meta_desc; ?>">
<meta name="keywords" content="<?php echo $meta_keywords; ?>">
<meta name="author" content="<?php echo SITE_TITLE_LONG; ?>">
<meta name="robots" content="index,follow">
<meta name="designer" content="Murage Munene, munene.murage@gmail.com">
<meta name="developer" content="Murage Munene, munene.murage@gmail.com">
<meta name="copyright" content="Copyright <?php echo date("Y"); ?> <?php echo SITE_TITLE_LONG; ?>">
<meta name="generator" content="<?php echo SITE_TITLE_LONG; ?> - http://www.<?php echo SITE_DOMAIN_URI; ?>">

<meta name="google-site-verification" content="2X7e1eNP0jDmrW0fKby-gnJHPx1POVC6QWdr2j6Eg6E" />
<meta property="og:title" content="<?php echo $my_header; ?>">
<meta property="og:description" content="<?php echo @$meta_desc; ?>" />
<meta property="og:type" content="article">
<meta property="og:url" content="<?php echo @$meta_seolink; ?>">
<meta property="og:image" content="<?php echo @$meta_image; ?>">
<meta property="og:site_name" content="<?php echo SITE_TITLE_LONG; ?>">
<meta property="fb:admins" content="507310797">  
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="<?php echo $my_header; ?>" />
<meta name="twitter:description" content="<?php echo $meta_desc; ?>" />
<meta name="twitter:image" content="<?php echo $meta_image; ?>" />


<link rel="alternate" type="application/rss+xml"  href="<?php echo SITE_DOMAIN_LIVE; ?>rss.php" title="<?php echo SITE_TITLE_LONG; ?>">
<link rel="canonical" href="<?php echo @$meta_seolink; ?>"/>
<base href="<?php echo SITE_DOMAIN_LIVE; ?>"><?php /*?><?php */?> 

<title><?php echo $thisSite; ?></title>  

<link rel="alternate" href="<?php echo SITE_DOMAIN_LIVE; ?>" hreflang="en" />
<link rel="shortcut icon" href="image/dev-favi.png" type="image/png" />
<?php if($GLOBALS['SOCIAL_CONNECT'] == true) {  ?> 
<link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' />
<link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Muli|Roboto:regular,bold' />
<?php }  ?> 
<link rel="stylesheet" type="text/css" href="styles/style.css" />  


<!--[if lte IE 8]> <link rel="stylesheet" type="text/css" href="styles/base_site_ie8.css" /> <![endif]-->
<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<!-- css3-mediaqueries.js for IE less than 9 -->
<!--[if lt IE 9]> <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script> <![endif]-->

<script type="text/javascript" src="scripts/jquery-1.12.3.min.js"></script>
</head>