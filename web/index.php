<!doctype html>
<head>
  <meta charset="utf-8">  
  <meta name="description" content="">
  
  <style type="text/css">
  
/**
 * HTML5 ✰ Boilerplate
 *
 * style.css contains a reset, font normalization and some base styles.
 *
 * Credit is left where credit is due.
 * Much inspiration was taken from these projects:
 * - yui.yahooapis.com/2.8.1/build/base/base.css
 * - camendesign.com/design/
 * - praegnanz.de/weblog/htmlcssjs-kickstart
 */


/**
 * html5doctor.com Reset Stylesheet (Eric Meyer's Reset Reloaded + HTML5 baseline)
 * v1.6.1 2010-09-17 | Authors: Eric Meyer & Richard Clark
 * html5doctor.com/html-5-reset-stylesheet/
 */

html, body, div, span, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
abbr, address, cite, code, del, dfn, em, img, ins, kbd, q, samp,
small, strong, sub, sup, var, b, i, dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, figcaption, figure,
footer, header, hgroup, menu, nav, section, summary,
time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 100%;
  font: inherit;
  vertical-align: baseline;
}

article, aside, details, figcaption, figure,
footer, header, hgroup, menu, nav, section {
  display: block;
}

blockquote, q { quotes: none; }

blockquote:before, blockquote:after,
q:before, q:after { content: ""; content: none; }

ins { background-color: #ff9; color: #000; text-decoration: none; }

mark { background-color: #ff9; color: #000; font-style: italic; font-weight: bold; }

del { text-decoration: line-through; }

abbr[title], dfn[title] { border-bottom: 1px dotted; cursor: help; }

table { border-collapse: collapse; border-spacing: 0; }

hr { display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0; }

input, select { vertical-align: middle; }


/**
 * Font normalization inspired by YUI Library's fonts.css: developer.yahoo.com/yui/
 */

body { font:13px/1.231 sans-serif; *font-size:small; 
  /* Prevents Mobile Safari from bumping up font sizes in landscape */
	-webkit-text-size-adjust: 100%; 
	-webkit-tap-highlight-color: rgb(255,255,0);
} /* Hack retained to preserve specificity */


select, input, textarea, button { font:99% sans-serif; }

/* Normalize monospace sizing:
   en.wikipedia.org/wiki/MediaWiki_talk:Common.css/Archive_11#Teletype_style_fix_for_Chrome */
pre, code, kbd, samp { font-family: monospace, sans-serif; }


/**
 * Minimal base styles.
 */

/* Always force a scrollbar in non-IE */
html { overflow-y: scroll; }

/* Accessible focus treatment: people.opera.com/patrickl/experiments/keyboard/test */
a:hover, a:active { outline: none; }

ol { list-style-type: decimal; }

/* Remove margins for navigation lists */
nav ul, nav li { margin: 0; list-style:none; list-style-image: none; }

small { font-size: 85%; }
strong, th { font-weight: bold; }

td { vertical-align: top; }

/* Set sub, sup without affecting line-height: gist.github.com/413930 */
sub, sup { font-size: 75%; line-height: 0; position: relative; }
sup { top: -0.5em; }
sub { bottom: -0.25em; }

pre {
  /* www.pathf.com/blogs/2008/05/formatting-quoted-code-in-blog-posts-css21-white-space-pre-wrap/ */
  white-space: pre; white-space: pre-wrap; word-wrap: break-word;
  padding: 15px;
}

textarea { overflow: auto; } /* www.sitepoint.com/blogs/2010/08/20/ie-remove-textarea-scrollbars/ */

.ie6 legend, .ie7 legend { margin-left: -7px; } 

/* Align checkboxes, radios, text inputs with their label by: Thierry Koblentz tjkdesign.com/ez-css/css/base.css  */
input[type="radio"] { vertical-align: text-bottom; }
input[type="checkbox"] { vertical-align: bottom; }
.ie7 input[type="checkbox"] { vertical-align: baseline; }
.ie6 input { vertical-align: text-bottom; }

/* Hand cursor on clickable input elements */
label, input[type="button"], input[type="submit"], input[type="image"], button { cursor: pointer; }

/* Webkit browsers add a 2px margin outside the chrome of form elements */
button, input, select, textarea { margin: 0; }

/* Colors for form validity */
input:valid, textarea:valid   {  }
input:invalid, textarea:invalid {
   border-radius: 1px; -moz-box-shadow: 0px 0px 5px red; -webkit-box-shadow: 0px 0px 5px red; box-shadow: 0px 0px 5px red;
}
.no-boxshadow input:invalid, .no-boxshadow textarea:invalid { background-color: #f0dddd; }


/* These selection declarations have to be separate
   No text-shadow: twitter.com/miketaylr/status/12228805301
   Also: hot pink! */
::-moz-selection{ background: #FF5E99; color:#fff; text-shadow: none; }
::selection { background:#FF5E99; color:#fff; text-shadow: none; }

/* j.mp/webkit-tap-highlight-color */
a:link { -webkit-tap-highlight-color: #FF5E99; }

/* Make buttons play nice in IE:
   www.viget.com/inspire/styling-the-button-element-in-internet-explorer/ */
button {  width: auto; overflow: visible; }

/* Bicubic resizing for non-native sized IMG:
   code.flickr.com/blog/2008/11/12/on-ui-quality-the-little-things-client-side-image-resizing/ */
.ie7 img { -ms-interpolation-mode: bicubic; }

/**
 * You might tweak these..
 */

body, select, input, textarea {
  /* #444 looks better than black: twitter.com/H_FJ/statuses/11800719859 */
  color: #444;
  /* Set your base font here, to apply evenly */
  /* font-family: Georgia, serif;  */
}

/* Headers (h1, h2, etc) have no default font-size or margin; define those yourself */
h1, h2, h3, h4, h5, h6 { font-weight: bold; }

a, a:active, a:visited { color: #57c5ec; }
a:hover { color: #35333c; }


/**
 * Primary styles
 *
 * Author: 
 */
 
body{ xposition: relative;}



/* Header
------------------------------- */
header{
  height: 130px;
  position: relative;
}

h1{
  color: #35333c;
  text-align: center;
  background: url(/images/logo_picStorms.png) no-repeat 0 0;
  width:  246px;
  height: 110px;
  text-indent: -9999px;
  display: block;
  margin: 0 auto;
}

h1 a{ text-decoration: none; }

h1 a:hover{ text-decoration: underline; }



nav{
  background: rgba(255,255,255,.2);
  position: absolute;
  right: 0;
  top: 7px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
}

nav a,
nav a:visited,
nav span{
  float: left;
  padding: 2px 7px;
  text-decoration: none;
}

nav a:active, 
nav a:hover{
}

#loginformwrapper,
#registerformwrapper{ position: relative; }

#loginform,
#registerform{ margin: 0; }

.login .bar{
  padding-left: 10px;
}

.menu-open{
  background-color: rgba(255,255,255,.9);
  border-radius: 5px 5px 0 0;
  -moz-border-radius: 5px 5px 0 0;
  -webkit-border-top-left-radius:5px;
  -webkit-border-top-right-radius:5px;
}

#signinMenu{
  color: #555;
  background-color: rgba(255,255,255,.9);
  border: 0 none;
  border-radius: 5px 0 5px 5px;
	box-shadow: 0 3px 3px rgba(0, 0, 0, 0.6);
  margin: 0;
  padding: 8px;
  position: absolute;
  right: 63px;
  text-align: left;
  top: 20px;
  width: 175px;
  height: 120px;
  z-index: 10000;
  display: block;
  -moz-border-radius-topleft:5px;
  -moz-border-radius-bottomleft:5px;
  -moz-border-radius-bottomright:5px;
  -webkit-border-top-left-radius:5px;
  -webkit-border-bottom-left-radius:5px;
  -webkit-border-bottom-right-radius:5px;
}

#registerMenu{
  color: #333;
  background-color: rgba(255,255,255,.9);
  border: 0 none;
  border-radius: 5px 0 5px 5px;
	box-shadow: 0 3px 3px rgba(0, 0, 0, 0.6);
  margin: 0;
  padding: 8px;
  position: absolute;
  right: 0;
  text-align: left;
  top: 20px;
  width: 250px;
  height: 250px;
  z-index: 10000;
  display: block;
  -moz-border-radius-topleft:5px;
  -moz-border-radius-bottomleft:5px;
  -moz-border-radius-bottomright:5px;
  -webkit-border-top-left-radius:5px;
  -webkit-border-bottom-left-radius:5px;
  -webkit-border-bottom-right-radius:5px;
}

#signinMenu label,
#registerMenu label{
  margin-bottom: 5px;   
	color: #555;
  float: left;
}

#signinMenu input,
#registerMenu input{
  float: left;	
  margin-bottom: 5px;
  width: 97%;
}

#registerMenu p{
  margin: 10px 0 20px;;
  font-size: 11px;
  color: #666;
}

#registerSubmit{
  margin-top: 5px;
}

#forecast{
  float: left;
  margin: 10px 0 10px 35px;
  padding: 5px;
  width: 160px;
  background: rgba(255,255,255,.2);
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  text-align: center;
}

#forecast .condition{
  width: 75px;
  float: left;
  font-size: 11px;
}

#forecast h3{
  margin-bottom: 5px;
  
}

.condition h4{
  font-weight: normal;
  font-s
}

.condition h4 span{
  font-weight: bold;
  display: block;
}

#forecast .icon{
  display: block;
  margin-left: 20px;
  width: 32px;
  height: 32px;
  background-size: 100% 100%;
}


/* Content
------------------------------- */
#container{ min-height: 300px; }
h2{
	font-family: 'Lobster Two', serif;
  font-size: 28px;
  margin-bottom: 15px;
  clear: both;
}

h2 em{
  font-style: italic;
}

.subtitle{
  float: left;
  clear: both;
	margin: -10px 0 25px;
  font-style: italic;
  opacity: .8;
}

#main h3{
  float: left;
  clear: both;
}

.photoGroup{
  float: left;
  margin-bottom: 20px;
}
  
.photoGroup .photo img{
 float: left;
 width: 50px;
 height: 50px;
 overflow: hidden;
 background: #666;
 outline: 1px solid #fff;
}

#photoSingle .photo{
  text-align: center;
}

#photoSingle .photo img{
  height: 600px;
  background: #fff;
  display: block;
}


/* Single Photo Page
------------------------------- */

#photoSingle .photo img{
  width: 100%;
  max-width: 800px;
  margin-bottom: 5px;
}

#photoSingle .photoInfo{
  text-align: left;
  float: left;
  list-style-type: none;
  font-size: 11px;
}

#photoSingle .photoInfo li{
  float: left;
  margin-right: 10px;
}

.photo .description{
  clear: both;
  float: left;
  margin: 10px 0;
}

#comments{
  clear: both;
  float: left;
  margin-top: 20px;
  width: 100%;
  text-align: left;
}

#comments-list{
  margin-bottom: 10px;
}

#comments-list li{  
  list-style: none;
  padding-bottom: 10px;
}

.comment-author{
  font-weight: bold;
}

#commentForm textarea{
  margin-bottom: 5px;
  width: 100%;
}


/* footer
------------------------------- */

footer{
 position: absolute;
  bottom: 0;
  margin-top: 30px;
  clear: both;
  height: 176px;
  width: 100%;
}

footer .land{
  width: 837px;
  height: 139px;
  display: block;
  margin: 0 auto;
}





/**
 * Non-semantic helper classes: please define your styles before this section.
 */

/* For image replacement */
.ir { display: block; text-indent: -999em; overflow: hidden; background-repeat: no-repeat; text-align: left; direction: ltr; }

/* Hide for both screenreaders and browsers:
   css-discuss.incutio.com/wiki/Screenreader_Visibility */
.hidden { display: none; visibility: hidden; }

/* Hide only visually, but have it available for screenreaders: by Jon Neal.
  www.webaim.org/techniques/css/invisiblecontent/  &  j.mp/visuallyhidden */
.visuallyhidden { border: 0; clip: rect(0 0 0 0); height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; }
/* Extends the .visuallyhidden class to allow the element to be focusable when navigated to via the keyboard: drupal.org/node/897638 */
.visuallyhidden.focusable:active,
.visuallyhidden.focusable:focus { clip: auto; height: auto; margin: 0; overflow: visible; position: static; width: auto; }

/* Hide visually and from screenreaders, but maintain layout */
.invisible { visibility: hidden; }

/* The Magnificent Clearfix: Updated to prevent margin-collapsing on child elements.
   j.mp/bestclearfix */
.clearfix:before, .clearfix:after { content: "\0020"; display: block; height: 0; overflow: hidden; }
.clearfix:after { clear: both; }
/* Fix clearfix: blueprintcss.lighthouseapp.com/projects/15318/tickets/5-extra-margin-padding-bottom-of-page */
.clearfix { zoom: 1; }



/**
 * Media queries for responsive design.
 *
 * These follow after primary styles so they will successfully override.
 */

@media all and (orientation:portrait) {
  /* Style adjustments for portrait mode goes here */

}

@media all and (orientation:landscape) {
  /* Style adjustments for landscape mode goes here */

}

/* Grade-A Mobile Browsers (Opera Mobile, Mobile Safari, Android Chrome)
   consider this: www.cloudfour.com/css-media-query-for-mobile-is-fools-gold/ */
@media screen and (max-device-width: 480px) {


  /* Uncomment if you don't want iOS and WinMobile to mobile-optimize the text for you: j.mp/textsizeadjust */
  /* html { -webkit-text-size-adjust:none; -ms-text-size-adjust:none; } */
}


/**
 * Print styles.
 *
 * Inlined to avoid required HTTP connection: www.phpied.com/delay-loading-your-print-css/
 */
@media print {
  * { background: transparent !important; color: black !important; text-shadow: none !important; filter:none !important;
  -ms-filter: none !important; } /* Black prints faster: sanbeiji.com/archives/953 */
  a, a:visited { color: #444 !important; text-decoration: underline; }
  a[href]:after { content: " (" attr(href) ")"; }
  abbr[title]:after { content: " (" attr(title) ")"; }
  .ir a:after, a[href^="javascript:"]:after, a[href^="#"]:after { content: ""; }  /* Don't show links for images, or javascript/internal links */
  pre, blockquote { border: 1px solid #999; page-break-inside: avoid; }
  thead { display: table-header-group; } /* css-discuss.incutio.com/wiki/Printing_Tables */
  tr, img { page-break-inside: avoid; }
  @page { margin: 0.5cm; }
  p, h2, h3 { orphans: 3; widows: 3; }
  h2, h3{ page-break-after: avoid; }
}





  <!--
/* lightrain
------------------------------- */
body.lightrain{
  background: #00bddf url(/images/storms/lightrain/bg_main.png) repeat;
  
  -moz-animation-duration: 4s;  
  -moz-animation-name: rain;  
  -moz-animation-iteration-count: infinite;
  -moz-animation-timing-function: linear;
  
  -webkit-animation-duration: 4s;  
  -webkit-animation-name: rain;  
  -webkit-animation-iteration-count: infinite;
  -webkit-animation-timing-function: linear;
}

 @-webkit-keyframes rain {
    from {  
      background-position: 0 0;  
    }  
    to {  
      background-position: 0 100px;  
    }  
 }
 @-moz-keyframes rain {  
    from {  
      background-position: 0 0;  
    }  
    to {  
      background-position: 0 100px;  
    }  
  }  

.lightrain a, .lightrain a:active, .lightrain  a:visited { color: #333; }
.lightrain a:hover { color: #333; }

.lightrain .storm{
  background:  url(/images/storms/lightrain/clouds1.png) repeat-x scroll 200% 0;
}

.lightrain .storm2{
  background:  url(/images/storms/lightrain/clouds2.png) repeat-x scroll 70% 0;
  -moz-animation-duration: 20s;  
  -moz-animation-name: clouds;  
  -moz-animation-iteration-count: infinite;
}

 @-moz-keyframes clouds {  
    from {  
      background-position: 0 0;  
    }  
      
    to {  
      background-position: 100% 0;  
    }  
  }  


.lightrain footer{
  background: url(/images/storms/lightrain/bg_footer.png) repeat-x scroll 70% 0;
}

.lightrain .land{
  background: url(/images/storms/lightrain/bg_land.png) no-repeat;
}

.icon.lightrain{
  background: url(/images/storms/lightrain/icon.png) no-repeat;
}




  -->
  </style>
	<link href='http://fonts.googleapis.com/css?family=Lobster+Two:700,700italic&v2' rel='stylesheet' type='text/css'>
  
  </head>

<body class="lightrain sunny">
<div class="storm">
  <div class="storm2">
  <div id="container">
    <header>
    
        </header>
    <div id="main" role="main" style="text-align: center;">
            <h1>Pic Storms</h1>

    <br>
    <br>
    <h2>Current Forecast:<br> PicStorms Photo Sharing Coming Soon</h2>
    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- Place this tag where you want the +1 button to render -->
<g:plusone size="tall"></g:plusone>

<!-- Place this render call where appropriate -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    </div>
    </div></div></div>
      <footer>
    	<div class="land">
        <div class="character"></div>
      </p>


      </div>
    </footer>
    </body>
</html>