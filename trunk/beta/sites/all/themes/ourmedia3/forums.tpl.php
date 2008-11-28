<?php
// $Id$

/**
 * @file
 * Default theme implementation to display a forum which may contain forum
 * containers as well as forum topics.
 *
 * Variables available:
 * - $links: An array of links that allow a user to post new forum topics.
 *   It may also contain a string telling a user they must log in in order
 *   to post.
 * - $forums: The forums to display (as processed by forum-list.tpl.php)
 * - $topics: The topics to display (as processed by forum-topic-list.tpl.php)
 * - $forums_defined: A flag to indicate that the forums are configured.
 *
 * @see template_preprocess_forums()
 * @see theme_forums()
 */
?>

<h2>Welcome to the Ourmedia Forums</h2>

<p>We've created a place where you can post new discussion topics or participate in existing discussions by adding a comment.  The forums are organized into categories to make it easier to find topics of interest.</p>
<br/>
<p>To explore the forums, click on a link in the list below and drill down to the discussions that interest you.  Icon colors and "new" item links indicate recently added discussion topics and replies that have been posted since the last time you visited.</p>
<br/>

<?php if ($forums_defined): ?>
<div id="forum">
  <?php print theme('links', $links); ?>
  <?php print $forums; ?>
  <?php print $topics; ?>
</div>
<?php

endif;

