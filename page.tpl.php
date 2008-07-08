<? require('testing-remove/dtd'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>"> 
<head>
	<title><?php print $head_title?></title>
	<?php print $head ?>
	<?php print $styles ?>
	<?php print $scripts ?>
</head>
<body class="<?php print $body_classes ?>" >
<div align="center">
<!-- start header -->
	<div id="header">


	    <?php print $header ?>		

		<a href="/"><img src="<?php print $logo ?>" alt="home page" class="logo"></img></a><br/>
				
		<div id="topNav">
			<?php if (isset($primary_links)) print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
			<?php print $navbar ?>	
		</div>
	</div>
<!-- end header -->

<!-- start main area -->	
	<div id="main">
		
<!-- left col -->		
		<div id="leftCol">
            <?php if ($show_blocks) print $sidebar_left ?>	
            <?php if ($show_blocks) print $sidebar_right ?>	
			<br/>
		</div>
<!-- end left col -->		
		
<!-- start right col -->		
		<div id="rightCol">
		<?php // print $breadcrumb ?>
		<?php // print $help ?>	
		<?php if ($show_messages) print $messages ?>
		<?php print $tabs ?>		
		<?php print $content_top ?>		
		<?php print $content ?>		
		<?php print $content_bottom ?>		
		
		</div> <!-- end right col -->
		<br clear="all"/>
	</div><!-- end main section-->
	
	<!-- footer --->
	<div id="footer">
		
	    <?php if (isset($secondary_links)) print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
		
	</div>
	<!-- end footer --->
	
	
</div> <!-- align center -->

		<?php print $footer ?>	
			
	    <?php if ($show_messages) print $footer_message ?>
	
		<!-- Closure -->
		<?php print $closure; ?>
		

</body>
</html>
