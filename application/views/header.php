<?php
$privileges=explode(",",$_SESSION['privileges']);
// convert to array

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>EliteInsure | Compliance
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="./assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
  <link rel="icon" type="image/x-icon" href="./img/icon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/complianceapp.css">
</head>

<body class="">
  <input type="hidden" value="<?= base_url(); ?>" id="base_url" />
  <input type="hidden" value="<?= $_SESSION['id'] ?>" id="session_id" />
  <div class="wrapper ">
  
    <div class="sidebar" data-color="azure" data-background-color="white" data-image="./assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo" style="text-align: center;"><a href="#" class="simple-text logo-normal">
          <?php echo ($_SESSION['admin']) ? "Compliance Checker" : "Compliance Adviser"; ?>
        </a>
        <?php echo $_SESSION['name']; ?>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
        <?php if(in_array('dashboard',$privileges)):?>
        <li class="nav-item <?php if($activeNav=="dashboard"){echo "active";} ?>">
            <a class="nav-link" href="<?=base_url(); ?>">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <?php endif;?>
          <?php if(in_array('users',$privileges)):?>
          <li class="nav-item <?php if($activeNav=="users"){echo "active";} ?>">
          <a class="nav-link" href="<?=base_url('users'); ?>">
              <i class="material-icons">person</i>
              <p>User Profile</p>
            </a>
          </li>
          <?php endif;?>
          <?php if(in_array('compliance',$privileges)):?>
          <li class="nav-item <?php if($activeNav=="compliance"){echo "active";} ?>">
            <a class="nav-link" href="<?=base_url('compliance'); ?>">
              <i class="material-icons">content_paste</i>
              <p>Compliance</p>
            </a>
          </li>
          <?php endif;?>
          <?php if(in_array('advisers',$privileges)):?>
          <li class="nav-item <?php if($activeNav=="advisers"){echo "active";} ?>">
            <a class="nav-link" href="<?=base_url('advisers'); ?>">
              <i class="material-icons">groups</i>
              <p>Advisers</p>
            </a>
          </li>
          <?php endif;?>
          <?php if(in_array('fieldmanagement',$privileges)):?>
          <li class="nav-item <?php if($activeNav=="fieldmanagement"){echo "active";} ?>">
            <a class="nav-link" href="<?=base_url('fieldmanagement'); ?>">
              <i class="material-icons">settings</i>
              <p>Fieldmanagement</p>
            </a>
          </li>
          <?php endif;?>
          <?php if(in_array('pdf',$privileges)):?>
          <li class="nav-item <?php if($activeNav=="pdf"){echo "active";} ?>">
            <a class="nav-link" href="<?=base_url('pdf'); ?>">
              <i class="material-icons">print</i>
              <p>PDF</p>
            </a>
          </li>
          <?php endif;?>
          <?php if(in_array('summary',$privileges)):?>
          <li class="nav-item <?php if($activeNav=="summary"){echo "active";} ?>">
            <a class="nav-link" href="<?=base_url('summary'); ?>">
              <i class="material-icons">description</i>
              <p>Summary</p>
            </a>
          </li>
          <?php endif;?>
          <?php if(in_array('advisernotes',$privileges)):?>
          <li class="nav-item <?php if($activeNav=="advisernotes"){echo "active";} ?>">
            <a class="nav-link" href="<?=base_url('advisernotes'); ?>">
              <i class="material-icons">people_alt</i>
              <p>Clients</p>
            </a>
          </li>
          <?php endif;?>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;"><?= ($activeNav == "advisernotes") ? "Client's List" : ucfirst($activeNav); ?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search..">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="javascript:;">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li id="navbarDropdownMenuLink_li" class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div id="navbarDropdownMenuLink_div" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" style="display:none"></div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?= base_url('login/signout'); ?>">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">