<div class='node-forum<?php print($page ? "-page" : "" ); ?>' <?php print $attributes; ?> >
<?php if ($page <> 0) { ?>
  <h2><?php print check_plain($node->title); ?></h2>
<?php }
else { ?>
  <h2><a href="<?php print $node_url ?>"><?php print check_plain($node->title); ?></a></h2>
<?php } ?>

<?php if ($picture) print $picture; ?>

<?php if ($submitted): ?>
  <span class="submitted"><?php print t('Submitted by ') . theme('username', $node) . t(' on ') . date("F j, Y, g:i a", $node->created); ?></span>
<?php endif; ?>

  <br/>
  <br/>
  <div class="content"><?php print $content; ?></div>
  <br/>

<?php if ($links): ?>
  <div class="links"><?php print $links; ?></div>
<?php endif; ?>


  <div class="forum-comments">
    <h3>Comments</h3>
   </div>

</div> <!-- /#node-<?php print $node->nid; ?> -->

