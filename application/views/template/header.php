
<?php if(!$this->session->userdata('people_login') or $this->session->userdata('people_login') == "") header("Location:/project3/") ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php

	$application_name = $this->Main_model->application_name();
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $application_name ?> | <?=  $this->router->fetch_method(); ?></title>

</head>

<body
	class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed border-bottom-0 layout-footer-fixed Kanit-Regular"
	data-siteurl="<?= site_url() ?>">

	<div class="wrapper">

		<!-- Preloader -->
		<div class="preloader flex-column justify-content-center align-items-center">
			<img class="animation__shake " src="<?= base_url('assets/images/_logo_1.png') ?>" alt="">
		</div>

