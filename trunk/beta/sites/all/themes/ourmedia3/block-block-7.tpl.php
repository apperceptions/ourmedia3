<?php
// $Id$

/* @file
 * get most recent three tools
 */

$list_no = 3;

$query = "SELECT DISTINCT n.nid, n.created
  FROM {node} n
  WHERE n.type = 'tool' AND n.status = 1
  ORDER BY n.created DESC
  LIMIT $list_no";

$sql = db_rewrite_sql($query);
$result = db_query($sql);
$items = array();

while ($item = db_fetch_object($result)) {

  $node = node_load($item->nid);

  // $term_names = array();
  // # gather, into $term_names, all the terms because of which this node was selected:
  // foreach (taxonomy_node_get_terms($item->nid) as $term) {
  //    if (in_array($term->tid, $taxo_id_arr))
  //        $term_names[] = $term->name;
  // }

  // $items[]= l($item->title, "node/$item->nid") .
  //   '<br />' .
  //   'Created ' . format_date($item->created, 'custom', 'Y-m-d') . '.';

  $title = drupal_substr(strip_tags(check_plain($node->title)), 0, 22);
  $link = "/node/". $node->nid;
  $clink = "/comment/reply/". $node->nid ."#comment-form";
  $description = trim(strip_tags(check_plain($node->body)));
  if ((strpos($description, '<') !== FALSE) || (strpos($description, '&lt;') !== FALSE) || (drupal_strlen($description) == 0))
    $description = "More";
  $description = drupal_substr($description, 0, 65) ." ... ";
  $image = "";

// todo: move this to a function (file attachments ok, but image attachments not supported in views?  bummer!)

  $files = upload_load($node);
  foreach ($files as $file) {
    if (strpos($file->filemime, "image") === 0) {
      $image = "/" . $file->filepath;
      break;
    }
  }
  if (($node->iid) && ($imagenode = node_load($node->iid))) {
    $files = upload_load($imagenode);
    foreach ($files as $file) {
      if (strpos($file->filepath, ".thumb") > 0) {
        $image =  "/" . $file->filepath;
        break;
      }
    }
    //$files = upload_load($imagenode);
    if ($imagenode->images)
      $image = $imagenode->images['thumbnail'];
  }
  if (drupal_strlen($image)==0)
    $image = "$directory/images/toolsImg.jpg";

$items[] =<<< EOS
      <div class="toolsItem">
        <a href="$link" title='Click to read review'><img class="toolsImg" src="$image" /></a>
        <div class="toolTxt">
          <span><strong>$title</strong></span><br />
          $description<br />
          &raquo; <a href="$link" title='Click to read review'>Read more</a><br />
          &raquo; <a href="$clink" title='Click to add a comment'>Post a comment</a><br />
        </div>
      </div>
EOS;
}
?>

<div id="toolsbox">
  <h2>Producer Tools</h2>
<?php
if(count($items)) {
  print theme('item_list', $items);
}
?>
<br/>
<div class="more-link">&raquo;&nbsp;<a href="/content/tools" title="Click to view all tools review posts">View more tools</a></div>
</div>

