<?php
  if(!isset($pageTitle)){
      $pageTitle="Twitter.It's what happening / Twitter";
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="shortcut icon" href="<?php echo url_for('frontend/assets/favicon/twitter.ico'); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo url_for('frontend/assets/css/font-awesome/css/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css"
    integrity="sha512-w+u2vZqMNUVngx+0GVZYM21Qm093kAexjueWOv9e9nIeYJb1iEfiHC7Y+VvmP/tviQyA5IR32mwN/5hTEJx6Ng=="
    crossorigin="anonymous" />
  <link rel="stylesheet" href="<?php echo url_for('frontend/assets/css/master.css'); ?>">
  <script src="<?php echo url_for("frontend/assets/js/jquery.min.js"); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"
    integrity="sha512-9pGiHYK23sqK5Zm0oF45sNBAX/JqbZEP7bSDHyt+nT3GddF+VFIcYNqREt0GDpmFVZI3LZ17Zu9nMMc9iktkCw=="
    crossorigin="anonymous"></script>
</head>

<body>