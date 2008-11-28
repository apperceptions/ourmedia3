// thumbnail slider vars
var curPos = 0;
var sliderWidth = 483;				// constant
var thumbWidth = 69;
var slidesWidth = sliderWidth;		// init value - recalculated
var doScroll = 0;
var numThumbnails = 0;

// thumbnail slider mouse handlers
function slide_thumbnails( amt ) {
	if (amt) {
		curPos -= amt;
		diff = slidesWidth - sliderWidth  - numThumbnails;
		if (diff < 0)
			diff = 0;
		if (-curPos > diff) {
			curPos = -diff;
			stop_thumbnails();
		}
		if (curPos > 0) { 
			curPos = 0;
			stop_thumbnails();
		}
		//curPos = curPos + ((-curPos) % thumbWidth);
		
		var obj = document.getElementById("thumbnail_slider");
		obj.style.left = "" + curPos +"px";

	//	updateThumbsDisplay();
	
	}
	
    if (window.event && window.event.srcElement)
        window.event.returnValue=false;
	else
		return false;
}

function rew_thumbnails() {
	slide_thumbnails(-17);
	doScroll = setTimeout("rew_thumbnails()", 16);
		
    if (window.event && window.event.srcElement)
        window.event.returnValue=false;
	else
		return false;
}

function fwd_thumbnails() {
	slide_thumbnails(17);
	doScroll = setTimeout("fwd_thumbnails()", 16);
			
    if (window.event && window.event.srcElement)
        window.event.returnValue=false;
	else
		return false;
}

function stop_thumbnails() {
	if (doScroll)
		clearTimeout(doScroll);
		
	//updateThumbsDisplay();
	
    if (window.event && window.event.srcElement)
        window.event.returnValue=false;
	else
		return false;
}

// thumbnail onclick handler
function updatefeaturedvideo(imgpath, videourl, title, artist, mediatype, artistpage, 
                             mediapage, height, width, autostart, notes, path2theme) {
	
	div = document.getElementById("artist_name");
	if (artist.length) {
		if (artistpage.length) 
			div.innerHTML = "<a href='" + artistpage + "' title='Visit producer page...'>" + artist + "</a>";
		else
			div.innerHTML =  artist; 
	} else {
		if (artistpage.length) 
			div.innerHTML = "<a href='" + artistpage + "' title='Visit producer page...'>Producer Page</a>";
		else
			div.innerHTML =  "Unknown Producer"; 
	}

	div = document.getElementById("media_title");
	if (title.length) {
		if (mediapage.length) 
			div.innerHTML = "<a href='" + mediapage + "' title='Visit media page...'>" + title + "</a>";
		else {
			if (videourl.length) 
				div.innerHTML = "<a href='" + videourl + "' title='Media link...'>" + title + "</a>";
			else
				div.innerHTML =  title; 
		}
	} else {
		if (mediapage.length) 
			div.innerHTML = "<a href='" + mediapage + "' title='Visit media page...'>Media Page</a>";
		else {
			if (videourl.length) 
				div.innerHTML = "<a href='" + videourl + "' title='Media link...'>Untitled Work</a>";
			else
				div.innerHTML =  "Untitled Work"; 
		}
	}

	div = document.getElementById("media_playbtn");
	if (videourl.length) {
	  s = videourl.toLowerCase();
	  if ((s.indexOf(".png")==-1) && (s.indexOf(".gif")==-1) && (s.indexOf(".jpg")==-1) && 
		  (s.indexOf(".jpeg")==-1) && (s.indexOf(".tiff")==-1) && (s.indexOf(".bmp")==-1) && (s.indexOf(".svg")==-1))
			div.innerHTML  = "<div class=\"media_playbtn\"><a href=\"#\" onclick=\"playselectedvideo('" + path2theme + "')\" ><img src=\"" + path2theme + "/images/playButtonWhiteBkgd.png\" border=\"0\" /> </a></div>";
	  else
		div.innerHTML = "";
	} else {
	  div.innerHTML = "";
	}

	document.getElementById("videourl").value = videourl;
	document.getElementById("height").value = height;
	document.getElementById("width").value = width;
	document.getElementById("notes").value = notes;

	ifm = document.getElementById("featuredVideo");
	ifm.src = path2theme + "/featured_video.php?video=" + videourl 
							+ "&notes=" + notes + "&height=" + height 
							+ "&width=" + width + "&autostart=" + autostart;
	ifm.location = ifm.src;
	ifm.width = width;
	ifm.height = height;
	
  	return false;
}

// reloads and plays the selected video in iframe when the homepage play button graphic is clicked
function playselectedvideo(pathtotheme) {
	document.getElementById("featuredVideo").src = "/" + pathtotheme + 
												"/featured_video.php" + 
												"?video=" +  document.getElementById("videourl").value + 
												"&notes=" +  document.getElementById("notes").value + 
												"&height=" +  document.getElementById("height").value + 
												"&width=" +  document.getElementById("width").value + 
												"&autoplay=true";
  
	document.getElementById("featuredVideo").location = document.getElementById("featuredVideo").src;
}
