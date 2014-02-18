<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  <?php include_stylesheets() ?>
  </head>
  <body>
  <div id="header">
  <div class="storm">

  <h1><a href="/" title="PicStorms!">Picstorms.com <span id="site-visit-button"><span>to PicStorms!</span></span></a></h1>
  
   <?php 
    if($sf_user->isAuthenticated()){
      //echo $sf_user->getUserObject()->getName();
      echo link_to('logout', '@logout', array('class' => 'logout'));
    }
    ?>
    
		<?php if($sf_user->isAuthenticated()){ ?>
      <div id="nav">
        <ul class="level1" id="navPrimary">
        <li>
          <?php echo link_to('Users', '@user', array('class' => 'nav_users')); ?>
        </li>
        <li>
          <?php echo link_to('Themes', '@theme', array('class' => 'nav_themes')); ?>
        </li>
        <li>
          <?php echo link_to('Weather', '@weather', array('class' => 'nav_weather')); ?>
        </li>
      </ul> 
    <?php } ?>

    </div>
    </div> <!--! end of .storm -->
  </div>
  <div class="content">
    <?php echo $sf_content ?>
  </div>
  </body>
</html>
