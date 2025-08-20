<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= $title ?></title>
<!-- Tell the browser to be responsive to screen width -->

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?= isset($description) ? $description :'Website Donasi' ?>">
<meta name="keywords" content="<?= isset($keyword) ? $keyword :'Website Donasi' ?>">
<meta name="author" content="uxliner"/>
<!-- v4.1.3 -->
<link rel="stylesheet" href=" <?= base_url('public/dist/bootstrap/css/bootstrap.min.css') ?>">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('public/dist/img/favicon-16x16.png') ?>">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url('public/dist/css/style.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/dist/css/font-awesome/css/font-awesome.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/dist/css/et-line-font/et-line-font.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/dist/css/themify-icons/themify-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/dist/css/simple-lineicon/simple-line-icons.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/dist/css/skins/_all-skins.min.css') ?>">

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('public/dist/plugins/datatables/css/dataTables.bootstrap.min.css') ?>">

<!-- form wizard -->
<link rel="stylesheet" href="<?= base_url('public/dist/plugins/formwizard/jquery-steps.css') ?>">

<!-- dropify -->
<link rel="stylesheet" href="<?= base_url('public/dist/plugins/dropify/dropify.min.css') ?>">

<!-- Chartist CSS -->
<link rel="stylesheet" href="<?= base_url('public/dist/plugins/chartist-js/chartist.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/dist/plugins/chartist-js/chartist-plugin-tooltip.css') ?>">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper boxed-wrapper">