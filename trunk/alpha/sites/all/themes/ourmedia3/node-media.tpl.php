<?php 

//todo: move all code to prepare module and define variables

$mediaid = key($node->files); 
$node = node_build_content($node);
$archiveidentifier = check_plain($node->field_identifier[0]['value']);
$player = Ourmedia3_player($node->files[$mediaid]->filepath, $node->files[$mediaid]->filemime);

?>

<div <?php print $attributes; ?>>

  <h3 class="title"><a href="<?php print $node_url ?>"><?php print check_plain($node->title); ?></a></h3>

<?php if ($picture) print $picture; ?>

<?php if ($submitted): ?>
  <span class="submitted"><?php print t('Posted ') . date("F j, Y, g:i a",$node->files[$mediaid]->timestamp) . t(' by ') . theme('username', $node); ?></span>
<?php endif; ?>

<?php if ($page <> 0): ?>
  <div class='media-player'>
<?php print $player ?>
  </div>
<?php endif; ?>

</div> <!-- /#node-<?php print $node->nid; ?> -->



<?php if ($page <> 0): ?>
			


			<div>
				DETAILS
			</div>
			
			<div class="rightModules">

  <div class="content">
<?php print $node->body; ?>
  </div>


				<span class="bold">Format:</span> <?php print $node->files[$mediaid]->filemime; ?>
				<div class="horzRule"></div>

				<span class="rightSubTitles">Download or watch</span><br>
				<span class="bold">Ourmedia:</span>  <a href="x">Flash</a>    &nbsp;    
				
				<span class="bold">Archive.org:</span> <a href="http://archive.org/details/<?php print $archiveidentifier ?>">Download original file</a> &nbsp;|&nbsp; <a href="x">Re-sync</a>
				<div class="horzRule"></div>
				<span class="rightSubTitles">How you may use this work</span><br>
				<div style="float:right;width:250px">
					License: <br>
					<img src="images/tradCopy.gif" alt="" width="93" height="33" border="0"><br>
					Traditional Copyright
				</div>
				<span class="bold">Share it?</span> No 	<br>
				<span class="bold">Remix it?</span> No 	<br>
				<span class="bold">Use commercially?</span> No<br>
				<span class="bold">Copyright statement:</span> the original <br>
				copyright holders retain their copyrights
				
				
				<div class="horzRule"></div>
				
				
				<span class="rightSubTitles">Tags</span><br>
<?php if (count($taxonomy)): ?>
  <div class="taxonomy">
<?php print $terms ?>
  </div>
<?php endif; ?>


				<div class="horzRule"></div>
				
				
				<span class="rightSubTitles">Links</span><br>
<?php if ($links): ?>
  <div class="links">
<?php print $links; ?>
  </div>
<?php endif; ?>
				
			</div>
		
			<div class="rightTitles">
				YOU LIKE?
			</div>	
			
			<div class="rightModules">
				<div style="float:right;width:350px">
					<span class="rightSubTitles">Copy to your site (flowplayer)</span><br>
					Copy the code below and paste it into your favorite pages.<br>
					<form action="x" method="post" class="nopadding" style="margin-top:8px">
						<input name="embedcode" type="text" value="<object type='application/x-shockwave-flash' width" style="width:335px">
					</form>
				</div>
			
				<span class="rightSubTitles">Add this item to a channel</span><br>
				<form action="x" method="post" class="nopadding" style="margin-top:8px">
					<select style="width:170px">
						<option value="Item goes here">Item goes here</option>
						<option value="Item goes here">Item goes here</option>
						<option value="Item goes here">Item goes here</option>
					</select>
					<input type="submit" name="" value="Add" class="button" style="width:50px"> 
				</form>
			<br clear="all">
			</div>
			
			<div class="rightTitles">
				<div style="float:right;">
					&raquo; <a href="x" class="white">View All</a>
				</div>
				RELATED MEDIA (23)
			</div>	
			
			<div class="rightModules">
				<div class="relatedBox">
				<img src="images/relatedImg.jpg" alt="" border="0"><br>
				<a href="x">Some title goes here...</a>
				</div>
				<div class="relatedBox">
				<img src="images/relatedImg.jpg" alt="" border="0"><br>
				<a href="x">Some title goes here...</a>
				</div>
				<div class="relatedBox">
				<img src="images/audioThumb.jpg" alt="" border="0"><br>
				<a href="x">Some title goes here...</a>
				</div>
				<div class="relatedBox">
				<img src="images/relatedImg.jpg" alt="" border="0"><br>
				<a href="x">Some title goes here...</a>
				</div>
				<br clear="all"><br>
				<div align="center">
					<img src="images/b4vBtn.jpg" alt="" border="0">
				</div>
			</div>
			
			<div class="rightTitles">
				COMMENTS
			</div>			


<?php endif; ?>

