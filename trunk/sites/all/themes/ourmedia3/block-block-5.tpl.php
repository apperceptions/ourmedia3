<?php
include('iaparser4php4.php');

define('FEEDURL1', 'http://channels.ourmedia.org/mediarss/channel/3');
//define('FEEDURL2', 'http://channels.ourmedia.org/mediarss/channel/1206');
define('FEEDURL2', 'http://channels.ourmedia.org/mediarss/most_discussed');
$urls = array(FEEDURL1, FEEDURL2);

$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);

$cnt = 0;
foreach($urls as $url) {
	$cnt++;
	curl_setopt($ch, CURLOPT_URL, $url);
	$xmlstr = curl_exec($ch);
	$xml = ia_parse($xmlstr);
	$channel = $xml['RSS'][0]['CHANNEL'][0];
	// todo: use channel title for tab titles?
	$channelitems = $channel['ITEM'];
	foreach($channelitems as $channelitem) {
		$item->link = $channelitem['LINK'][0]['VALUE'];
		$item->mediaposturl = $channelitem['MEDIAPOST'][0]['VALUE'];
		$item->mediaurl = $channelitem['MEDIA:CONTENT'][0]['ATTRIBUTES']['URL'];
		$item->mediatitle = check_plain($channelitem['TITLE'][0]['VALUE']);
		$item->mediadescription = check_plain($channelitem['DESCRIPTION'][0]['VALUE']);
		if (strpos($item->mediadescription, '&lt;') === 0) 
			$item->mediadescription = "Click to view media ... ";
		$item->artistname = check_plain($channelitem['ARTIST'][0]['VALUE']);
		$item->artisturl = $channelitem['ARTISTURL'][0]['VALUE'];
		$item->mediathumbnailurl = $channelitem['MEDIA:THUMBNAIL'][0]['ATTRIBUTES']['URL'];
		$item->mediatype = $channelitem['MEDIA:CONTENT'][0]['ATTRIBUTES']['TYPE'];
		$item->commenturl = $channelitem['COMMENTS'][0]['VALUE'];
		$feeds[$cnt][$channelitem['GUID'][0]['VALUE']] = $item;
	}
}

curl_close($ch);

?>

<script>
// todo: onclick handler for items that displays video

function selectfeed(ndx) {
  t1 = document.getElementById("showcasefeedtab1");
  t2 = document.getElementById("showcasefeedtab2");
  o1 = document.getElementById("showcasefeed1");
  o2 = document.getElementById("showcasefeed2");
  if (ndx == 2) {
	o1.style.display = "none";
	o2.style.display = "block";
	t1.className = "";
	t2.className = "selected";
  } else {
	o2.style.display = "none";
	o1.style.display = "block";
	t2.className = "";
	t1.className = "selected";
  }
}

function swapmedia(url, enc, com) {
	//alert(url);
	// todo: check for url in description (embed or object or iframe)
	
	// checp trick for now
	enc = enc.replace(/\.mpg/, ".flv");
	enc = enc.replace(/\.mp4/, ".flv");
	enc = enc.replace(/\.wmv/, ".flv");
	enc = enc.replace(/\.mov/, ".flv");

    if (!com.length) 
		com = "javascript: alert('No comment url available for this media item.');";
		
	ac = document.getElementById("addcomment");
	ac.href = com;
	
	if (enc.length && (enc.indexOf(".flv") > 0)) {
		// todo: use local player
		url = "http://ourmedia.org/sites/default/themes/ourmedia-downes/players/flvplayer.swf?file=" + enc + "&autostart=false";
		swfobject.embedSWF(url, "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
		return;
	}
	

	if (enc.length && (enc.indexOf(".mp3") > 0)) {
		// todo: use local player
		enc = encodeURIComponent(enc);
		url = "http://ourmedia.org/sites/default/themes/ourmedia-downes/players/flvplayer.swf?file=" + enc + "&autostart=false";
		swfobject.embedSWF(url, "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
		return;
	}

	if (url.indexOf("youtube") != -1) {
		url = url.replace(/watch\?v=/, "v/");
		swfobject.embedSWF(url, "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
	} else if (url.indexOf("ourmedia") != -1) {
    	swfobject.embedSWF("http://www.youtube.com/v/O-tkqpHnxTI", "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
	} else {
    	swfobject.embedSWF("http://www.youtube.com/v/xKAoz0kwZ34", "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
	}
}
</script>

<script type="text/javascript">
    swfobject.embedSWF("http://www.youtube.com/v/O-tkqpHnxTI", "spotvideocontent", "310", "258", "8", "swfobject/expressInstall.swf");
</script>

<div id="spotlight">
	<ul class="spotTabs">
		<li><a id='showcasefeedtab2' href='#' onclick='selectfeed(2); return false;' class=''>Most Discussed</a></li>
		<li><a id='showcasefeedtab1' href='#' onclick='selectfeed(1); return false;' class='selected'>In the spotlight</a></li>
	</ul> 

	<br class="clearAll"/>

	<div id="spotlightBox">
		
		<div id="spotLeftSide">
			<h3>Spotlight</h3>
			<a id='addcomment' href="x" class="more">Add your comment</a>
			
			<br class="clearAll"/>
			
			<div id="spotvideocontent">
			  <p>Video ...</p>
			</div>
		</div>

		<div id="spotRightSide">
		
<?php

$cnt = 0;
foreach($feeds as $feeditems) {
	$cnt++;
?>
	<ul id="showcasefeed<?php print $cnt ?>" <?php if ($cnt > 1) print 'style="display:none;"' ?> >
<?php
	foreach ($feeditems as $item) {
		$link = $item->link; 
		$mediaposturl = $item->mediaposturl; 
		$mediaurl = $item->mediaurl;
		$mediatitle = substr(strip_tags($item->mediatitle), 0, 22);
		$mediadescription = substr(strip_tags($item->mediadescription), 0, 40) . " ... ";
		$artistname = substr(strip_tags($item->artistname), 0, 20);
		$artisturl = $item->artisturl;
		$mediathumbnailurl = $item->mediathumbnailurl;
		if (strlen($mediathumbnailurl)==0)
			$mediathumbnailurl = "http://channels.ourmedia.org/sites/all/themes/ourmedia-downes/images/ourmedia-thumbnail.png";
		$mediatype = $item->mediatype;
		$commenturl = $item->commenturl;
?>
		<li>
			<a href="#" onclick="swapmedia('<?php print $mediaposturl ?>', '<?php print $mediaurl ?>', '<?php print $commenturl ?>')"><img alt="thumb" src="<?php print $mediathumbnailurl ?>" /></a>
			<div class="spotlightText">
				<label><a href="<?php print $mediaposturl ?>"><?php print $mediatitle ?></a></label><br/>
				by <a href="<?php print $artisturl ?>"><?php print $artistname ?></a><br/>
				<p class="bioText">
					<label>Why is it spotlighted?</label><br/>
					<?php print $mediadescription ?>
				</p>
			</div>
		</li>
<?php
	}
?>
	</ul>
<?php
}
?>
		</div>
		<!-- end spotRightSide -->
		
	</div>
	<!-- end spotlightBox -->
	
</div>
<!-- end spotlight -->
		