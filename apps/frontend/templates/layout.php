<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    
<head>
  <meta charset="utf-8">
  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="author" content="Ideawise">
  
  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Fancy Apple 'fake webapp' support -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <link rel="apple-touch-startup-image" href="images/splash.png">  

  <title>Picstorms.com | Share photos based on a theme</title>
  <meta content="photo share, theme, picture share, picture" name="keywords">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<link href='http://fonts.googleapis.com/css?family=Lobster+Two:700,700italic&v2' rel='stylesheet' type='text/css'>

  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="/js/libs/modernizr-1.7.min.js"></script>

	<?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <?php include_stylesheets() ?>
  <?php include_javascripts() ?>

  <!-- Fallback if browser does not support media queries + javascript (Read: Internet Explorer 7 - 8) -->
  <link rel="stylesheet" href="/10col.css" media="all" />
  
  <!-- Media Queries / LESS -->
  <link rel="stylesheet" href="/css/10col.css" media="only screen and (min-width: 992px)" />
  <link rel="stylesheet" href="/css/8col.css" media="only screen and (min-width: 768px) and (max-width: 991px)" />
  <link rel="stylesheet" href="/css/3col.css" media="only screen and (max-width: 767px)" />
  <link rel="stylesheet" href="/css/5col.css" media="only screen and (min-width: 480px) and (max-width: 767px)" />    
  
  <script src="/js/libs/jquery-1.6.2.min.js"></script>   
  <script src="/js/script.js"></script>   
  
  <!-- Bring the Thunder! -->
  <link rel="stylesheet" href="/css/storms.css" media="all" />
  
  <!-- Development tool: Less Grid by @RnowM, http://arnaumarch.com/en/less-grid.html 
  <script //src="/js/libs/less-grid-4.js"></script>-->
       
	<!--[if !IE 7]>
	<style type="text/css">
		.storm{display:table;height:100%}
	</style>
	<![endif]-->    
       
  <!-- Media Queries for IE --> 
  <script src="/js/libs/jquery.mediaqueries1.2.js"></script>    

  <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-9434024-5']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
  
</head>
<?php

$currentWeather = $sf_user->getAttribute('current_weather');
$nextWeather = $sf_user->getAttribute('next_weather');

?>

<body class='<?php echo $currentWeather->getBodyClass(); ?>'>
<div class="storm">
	<div class="stormelement"></div>
  <div class="storm2">
  <div id="container">
    <header>

      <?php echo link_to('<h1>Pic Storms</h1>', '@homepage'); ?>
      
    <div id="forecast">
    	<h3>PicStorms Forecast</h3>
      <div class="condition current">
      	<h4>Current Conditions</h4>
				<span class="icon <?php echo $currentWeather->getBodyClass(); ?>"></span>
        <p><?php echo $currentWeather->getTitle(); ?></p>
      </div>
      <?php if(!empty($nextWeather)):?>
      <div class="condition upcoming">
      	<h4>Upcoming <span>(<?php echo ($nextWeather->getMaxPhotoNumber() - $sf_user->getCurrentTheme()->getCurrentPhotoNumbers()); ?> Pics)</span></h4>
				<span class="icon <?php echo $nextWeather->getBodyClass(); ?>"></span>
				<p><?php echo $nextWeather->getTitle();?></p>
      </div>
      <?php endif;?>
    </div>
   
   <nav> 
		<ul id="nav"> 
			<li>
        <a title="About" href="<?php echo url_for("user/login"); ?>" id="aboutlink"><strong>Get the App</strong></a>
        <div style="display:none;" id="aboutwrapper" class="dropdown">
          <div id="aboutMenu">
          <p><strong>Picstorms is a theme based photo community.</strong></p>
          <p>In order to submit pictures you need our Android application. Scan the QR code below to download the app or <a href="http://www.picstorms.com/picstorms.apk" onClick="_gaq.push(['_trackEvent', 'clicks', 'download', 'picstorms.apk']);">click here to download the beta app.</a></p>
          <a href="http://www.picstorms.com/picstorms.apk" onClick="_gaq.push(['_trackEvent', 'clicks', 'download', 'picstorms.apk']);"><img src="/images/qr_appv1.png"></a>
          </div>
        </div>
    </li>
    <li>
			<?php 
        if($sf_user->isAuthenticated()){
          printf('<span class="username">%s</span>', $sf_user->getUserObject()->getName());
          echo link_to('Logout', 'user/logout');	
        }else{
      ?>
    </li>
		<li>
			<a title="Register" href="<?php echo url_for("user/register"); ?>" id="registerlink">Register</a>
      <div style="display:none;" id="registerformwrapper" class="dropdown">
        
        <fieldset id="registerMenu">
          <p>Registration for Pic Storms is free and simple. It will take you longer to read this than to fill out the form below. </p>
          <form id='registerForm' method='post' action='<?php echo url_for("user/register"); ?>'>
            <label for="registerName">Username *</label>
            <input type="text" name="registerName" id="registerName" required value=""  />
            <label for="registerPassword">Password *</label>
            <input type="password" name="registerPassword" id="registerPassword" required  value="" />
            <label for="registerEmail">Email (optional)</label>
            <input name="registerEmail" id="registerEmail" value="" type="email" />
            <input type="submit" class="button" value="Register" id="registerSubmit">
          </form>
        </fieldset>
      </div>
    </li>
		<li>
			<a title="Login" href="<?php echo url_for("user/login"); ?>" id="loginlink">Login</a>
			<div style="display:none;" id="loginformwrapper" class="dropdown">
        <fieldset id="signinMenu">
          <form method="post" action="<?php echo url_for("user/login"); ?>" id="loginform">
          <label for="name">Username</label> 
          <input type="text" size="20" value="" name="name" required id="name">
          
          <label for="password">Password</label> 
          <input type="password" size="20" name="password" required id="password">
          
          <input type="submit" class="button" value="Login" name="submit">
          </form>
        </fieldset>
			</div>
		</li>
		<?php	}	?>        
	</ul>
	</nav>
      
  </header>
  <div id="main" role="main">
  
    <?php echo $sf_content ?>
  
  </div>  
  
  </div> <!--! end of #container -->
  </div> <!--! end of .storm2 -->
  </div> <!--! end of .storm -->
  
  <footer>
    <div class="land">
      <div class="character"></div>
  
  
 <?php if($sf_user->isAuthenticated() && $sf_user->getUserObject()->getName() == 'nic'):?>
       <div id="themechanger">
        <a class="sunny" href="#">sunny</a>
        <a class="lightrain" href="#">lightrain</a>
        <a class="thunderstorm" href="#">thunderstorms</a>
        <a class="clearnight" href="#">clearnight</a>
        <a class="aurora" href="#">aurora borealis</a>
       </div>
 <?php endif;?>
  
    </div>
  </footer>
    

    
</body>
</html>