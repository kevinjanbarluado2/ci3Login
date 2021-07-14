<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

  <title>Compliance | EliteInsure</title>


  <!-- Bootstrap core CSS -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <?php $isInvalid = isset($_GET['invalid']) ? $_GET['invalid'] : false; ?>
  <form class="form-signin" action="<?= base_url('login/verify'); ?>" method="post">
    <img class="mb-4" src="img/img.png" alt="" width="150px">
    <h1 class="h3 mb-3 font-weight-normal">Compliance App</h1>
    <label for="inputEmail" class="sr-only border-primary">Email address</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control <?= ($isInvalid) ? 'is-invalid' : '' ?>" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="inputPassword" id="inputPassword" class="form-control <?= ($isInvalid) ? 'is-invalid' : '' ?>" placeholder="Password" required>


    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <input type="submit" name="submit" value="Sign in" class="btn btn-lg btn-primary btn-block text-light" type="submit" />
    <p class="mt-5 mb-3 text-muted">&copy; EliteInsure <?= date('Y'); ?> | <?=$version;?> </p>
  </form>
</body>

</html>
<style>
  html,
  body {
    height: 100%;
  }

  body {
    display: -ms-flexbox;
    display: -webkit-box;
    display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
  }

  .btn-shiro {
    background-color: #fc5296;
    background-image: linear-gradient(315deg, #fc5296 0%, #f67062 74%);
    transition: opacity .25s ease-in-out;
    -moz-transition: opacity .25s ease-in-out;
    -webkit-transition: opacity .25s ease-in-out;
  }

  .btn-shiro:hover {
    opacity: 0.8;
    transition: 1s;
    -webkit-transition: 1s;
  }

  .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
  }

  .form-signin .checkbox {
    font-weight: 400;
  }

  .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
  }

  .form-signin .form-control:focus {
    z-index: 2;
  }

  .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }
</style>