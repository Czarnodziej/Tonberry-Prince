<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
						<?php	echo	$this->Html->charset('utf8');	?>

						<?php	echo	$this->Html->meta(array('name'	=>	'viewport',	'content'	=>	'width=device-width, initial-scale=1.0, user-scalable=no'));	?>

      <title>Wesoła wycieczka w treść</title>
						<?php
						echo	$this->Html->meta('icon');
						echo	$this->Html->css(array('style.min',	'smoothness/jquery-ui-1.10.3.custom.min.css'));
						echo	$this->Html->script('vendor/modernizr-2.6.2.min.js');
						?>

    </head>
    <body>
      <!--[if lt IE 8]>
        <p class="chromeframe">Używasz <strong>przestarzałej</strong> przeglądarki.
        Gorąco zalecam <a href="http://browsehappy.com/">aktualizację</a>
        lub <a href="http://www.google.com/chromeframe/?redirect=true">aktywację Google Chrome Frame</a>.
        Aktualna przeglądarka to podstawa prawidłowego wyświetlania stron i bezpiecznego korzystania z internetu.</p>
      <![endif]-->
      <div id="gora-kontener">
        <nav id="topbar">
          <span id="logo">
            <a href="<?php	echo	$this->Html->url("/");	?>"><i class="icon-fixed-width icon-home"></i>SuperLogo</a></span>
          <a href="<?php	echo	$this->Html->url("/teksty");	?>">Teksty</a>
          <a href="<?php	echo	$this->Html->url("/javascript");	?>">Javascript</a>
          <a href="<?php	echo	$this->Html->url("/autor");	?>">Autor</a>
        </nav>
      </div>
      <div id="main-container">
        <nav id="lewa-kolumna">
          <ul id="sidenav">
            <li>
              <a href="<?php	echo	$this->Html->url("/teksty");	?>"><i class="icon-fixed-width icon-book"></i>Teksty dowolne</a>
            </li>
            <li id="rozwin">
              <a href="<?php	echo	$this->Html->url("/javascript");	?>"><i class="icon-fixed-width icon-magic"></i>Javascript</a>
              <a href="<?php	echo	$this->Html->url("/javascript");	?>">"Czysty" Javascript</a>
              <a href="<?php	echo	$this->Html->url("/javascript");	?>">jQuery</a>
            </li>
            <li>
              <a href="<?php	echo	$this->Html->url("/autor");	?>"><i class="icon-fixed-width icon-thumbs-up"></i>Autorskie opisy</a>
            </li>
          </ul>
          <div class="social">
            <a href="https://www.facebook.com/marcin.marcinowy.5">
              <span class="fb"></span>
            </a>
            <a href="https://twitter.com/Czarnodziej">
              <span class="tw"></span>
            </a>
            <a href="<?php	echo	$this->Html->url("/kontakt");	?>">
              <span class="mail"></span>
            </a>
            <a href="https://github.com/Czarnodziej">
              <span class="gh"></span>
            </a>
												<a href="http://cakephp.org/"><img class="ciasto" src="<?php	echo	$this->Html->url("/img/cake.power.gif");	?>" alt="cakephp"></a>
          </div>

        </nav>
        <article class="clearfix"><!--żeby float zachowywał wysokość kontenera-->
          <!--content start-->
										<?php	echo	$this->fetch('content');	?>

          <!--content end-->
        </article>
        <footer id="stopka-strony">
          <div class="social">
            <a href="https://www.facebook.com/marcin.marcinowy.5">
              <span class="fb"></span>
            </a>
            <a href="https://twitter.com/Czarnodziej">
              <span class="tw"></span>
            </a>
            <a href="<?php	echo	$this->Html->url("/kontakt");	?>">
              <span class="mail"></span>
            </a>
            <a href="https://github.com/Czarnodziej">
              <span class="gh"></span>
            </a>
          </div>
          <p>©2013. Kopiowanie treści tekstów zawartych na stronie bez zgody autora jest czynem karygodnym.<br>
												<a href="//github.com/Czarnodziej/Tonberry-Prince/commits/master"><?php	echo	$this->element('date_mod');	?></a></p>
        </footer>
        </div>
        <!--[if lt IE 9]>
        <script src="<?php	echo	$this->Html->url("/js/vendor/respond.min.js");	?>" type="text/javascript"></script>
        <![endif]-->
								<?php
								echo	$this->fetch('bottom_scripts');
								echo	$this->element('sql_dump');
								?>
        <script defer async src="<?php	echo	$this->Html->url("/js/script-min.js");	?>"></script>
    </body>
  </html>