<!doctype html>
<html class='no-js' lang='<?=$lang?>'>
<head>
<meta charset='utf-8'/>
<title><?=get_title($title)?></title>
<?php if(isset($inlinestyle)):?><style type="text/css"><?=$inlinestyle;?></style><?php endif;?>

<?php if(isset($favicon)): ?><link rel='shortcut icon' href='<?=$favicon?>'/><?php endif; ?>
<?php foreach($stylesheets as $val): ?>
<link rel='stylesheet' type='text/css' href='<?=$val?>'/>
<?php endforeach; ?>
<script src='<?=$modernizr?>'></script>
</head>
<body>
<div class="wrapper" id="content">
	<div id="site-head">
		<header role="banner">
			<?=$header?>
		</header>
	</div>
		<div id="menu">
			<div  role="navigation" id="nav-items"><?=isset($navbar) ? get_navbar($navbar) : null ?></div>
		</div>
	<div id="content-wrapper">
		<main id="main-content" role="main">
			<?=$main?>
		</main>
	</div>
		<footer id="footer">
			<nav><?=$footer?> <a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a></nav>			
		</footer>
</div>

<?php if(isset($jquery)):?><script src='<?=$jquery?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$val?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', <?=$google_analytics?>, 'bth.se');
  ga('send', 'pageview');

</script>
<?php endif; ?>
</body>
</html>