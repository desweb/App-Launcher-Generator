<!DOCTYPE html>
<html lang="fr">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Ecran de lancement mobile</title>

  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="favicon.ico">

  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="css/jumbotron.css" rel="stylesheet">
  <link href="css/dropzone.css" rel="stylesheet">

  <script type="text/javascript" src="//code.jquery.com/jquery.js"></script>

  <!--[if lt IE 9]>
    <script src="../../assets/js/html5shiv.js"></script>
    <script src="../../assets/js/respond.min.js"></script>
  <![endif]-->

  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/dropzone.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="http://code.desweb-creation.fr/app-icon/">Ic&ocirc;nes mobile</a>
        <a class="navbar-brand" href="http://code.desweb-creation.fr/app-launcher/">Ecrans de lancement mobile</a>
      </div>
      <div class="navbar-collapse collapse" id="navbar-main">
        <div class="nav navbar-nav navbar-right">
          <img style="margin-top:10px;" src="https://insight.sensiolabs.com/projects/7f603b2c-6499-44ba-8b0a-789a733dd5ed/small.png" alt="Insight Sensiolab Medal"/>
        </div>
      </div>
    </div>
  </div>

  <div class="jumbotron">
    <div class="container">
      <h1>G&eacute;n&eacute;ration d'&eacute;crans de lancement pour application mobile <sup>b&ecirc;ta</sup></h1>

      <p>
        1. Glissez/d&eacute;posez votre &eacute;cran de lancement<br />
        2. Patientez quelques instants<br />
        3. T&eacute;l&eacute;chargez votre fichier zip<br />
        4. Disposez de tous les &eacute;crans de lancement dont vous aurez besoin pour votre application mobile iPhone & Android
      </p>
      <p><a href="https://developer.apple.com/library/ios/documentation/UserExperience/Conceptual/MobileHIG/LaunchImages.html" target="_blank">Documentation iOS</a></p>
      <p><a href="http://developer.android.com/guide/practices/screens_support.html" target="_blank">Documentation Android</a></p>
    </div>
  </div>

  <div class="container">
    <div class="alert alert-info" id="load">
      <img src="images/loader.gif"/> Chargement...
    </div>
    <div class="alert alert-success" id="upload_success">
      Cr&eacute;ation des &eacute;crans de lancement effectu&eacute;s avec succ&egrave;s.<br />
      <a href="#" target="_blank" id="zip_link">T&eacute;l&eacute;charger mes &eacute;crans de lancement</a>
    </div>
    <div class="alert alert-danger" id="upload_failed">
      Erreur lors de l'envoi de l'icône.
    </div>
    <div class="alert alert-danger" id="file_error">
      Attention, votre image ne respecte pas les conditions requises :
      <ul>
        <li>Poids maximum : 5Mo</li>
        <li>Format : PNG</li>
        <li>Dimensions : 2048px * 2048px</li>
        <li>R&eacute;solution : 72dpi</li>
      </ul>
    </div>

    <?php $now = time(); ?>
    <form method="post" action="upload.php?time=<?= $now ?>" data-time="<?= $now ?>" enctype="multipart/form-data" role="form" class="dropzone" id="dropzone"></form>
    </div>
  </div>
</body>
</html>