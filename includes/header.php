<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
ensure_session_started();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- SEO meta description-->

  <meta name="description"
    content="Are you looking to hire a junior developer? Take a look at my portfolio which showcases recent projects I have been working on and a downloadable CV. Built using BootStrap, check out my experience, qualifications & skills. I look forward to hearing from you" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.1/css/hover-min.css"
    type="text/css" />

  <!-- Fav icon -->
  <link rel="icon" type="image/png" href="/assets/images/logo-ITCHY-removebg-preview.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="/assets/images/logo-ITCHY-removebg-preview.png" sizes="16x16" />
  <link rel="shortcut icon" type="img/png" href="/assets/images/logo-ITCHY-removebg-preview.png" />

  <link rel="stylesheet" type="text/css" href="/assets/css/style.css" />

  <link rel="stylesheet" type="text/css" href="/assets/css/dark.css" />

  <!-- SEO Page Title-->

  <title>CV | Hoàng Quốc Việt</title>
</head>

<body>
<?php
$successMessage = flash('success');
$errorMessage = flash('error');
?>
<?php if ($successMessage): ?>
  <div class="container mt-3">
    <div class="alert alert-success" role="alert">
      <?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?>
    </div>
  </div>
<?php endif; ?>
<?php if ($errorMessage): ?>
  <div class="container mt-3">
    <div class="alert alert-danger" role="alert">
      <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
    </div>
  </div>
<?php endif; ?>
