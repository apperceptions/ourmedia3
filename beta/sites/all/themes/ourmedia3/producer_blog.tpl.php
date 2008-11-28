<!-- Weblog -->
<div id="weblog">
  <?php if (($user->uid == $account->uid) && ($account->uid > 0)) { ?>
  <center><div style='vertical-align:middle'>
    <a href='/node/add/blog' title='Add a blog post ...'><img src="<?php print $directory ?>/images/plusBtnTransBkgd.png" alt="Add a blog post ..." /><h3>Post to your blog</h3></a>
  </div></center>
  <?php } ?>

  <div class="mypage-nodes">
    <?php print($blog)?>
  </div>

  <?php if ((drupal_strlen($blog) == 0) && (count($omblog) == 0)) { ?>
    <div>No blog entries yet.</div>
  <?php } ?>

    <?php print "<div class=\"xml-icon\">&nbsp;&nbsp;<a href=\"blog/$account->uid/feed\"><img src=\"". $directory ."/images/rssIcon.gif\" width=\"36\" alt=\"Subscribe to member's feed\" title=\"Subscribe to member's blog feed\" /></a>&nbsp;&nbsp; Subscribe to this member's blog posts. </a> RSS subscriptions <a href='". $GLOBALS['ourmedia_base_url'] ."/node/41292'>explained</a></div>"; ?>

</div>


  <div class='directory-link'><a href='/producers' title='Click here to browse or search the Digital Producers Directory'>Browse or search the <h3>Digital Producers Directory<h3></a></div>
