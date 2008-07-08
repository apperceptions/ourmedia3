<?php 
//$item = $variables['item'];

//var_dump(get_defined_vars());

$author = $item->author; 

if ($author) {
	$u = user_load(array("name" => $author));
	if ($u->uid) {
		$pic = $u->picture;
		$artisturl = "/user/" . $u->uid;
	}
} else
	$author = "Unknown";
$author = substr(strip_tags(check_plain($author)), 0, 20);
	
if (strlen($artisturl) == 0)
  $artisturl = $item->link;

if (strlen($pic)==0)
	$pic = "<img src=\"$directory/images/standInImage.jpg\" />";
	
$title = substr(strip_tags(check_plain($item->title)), 0, 22);

if ((strlen($item->description)==0) || (strpos($item->description, '<') === 0)) 
  $description = "Click to view media ...";
else
  $description = substr(strip_tags(check_plain($item->description)), 0, 45) . " ... ";

$link = check_url($item->link);

?>

<a href="<?php echo $link ?>" ><?php echo $pic ?></a>
<div>
	<label><a href="<?php print $link ?>"><?php print $title ?></a></label><br/>
	by <a href="<?php print $artisturl ?>"><?php print $author ?></a><br/>
	<p>
		<?php print $description ?>
	</p>
</div>
<br/>