<?php
// $Id$

/**
 * @file
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * By default, all user profile data is printed out with the $user_profile
 * variable. If there is a need to break it up you can use $profile instead.
 * It is keyed to the name of each category or other data attached to the
 * account. If it is a category it will contain all the profile items. By
 * default $profile['summary'] is provided which contains data on the user's
 * history. Other data can be included by modules. $profile['picture'] is
 * available by default showing the account picture.
 *
 * Also keep in mind that profile items and their categories can be defined by
 * site administrators. They are also available within $profile. For example,
 * if a site is configured with a category of "contact" with
 * fields for of addresses, phone numbers and other related info, then doing a
 * straight print of $profile['contact'] will output everything in the
 * category. This is useful for altering source order and adding custom
 * markup for the group.
 *
 * To check for all available data within $profile, use the code below.
 *
 *   <?php print '<pre>'. check_plain(print_r($profile, 1)) .'</pre>'; ?>
 *
 * @see user-profile-category.tpl.php
 *      where the html is handled for the group.
 * @see user-profile-field.tpl.php
 *      where the html is handled for each item in the group.
 *
 * Available variables:
 * - $user_profile: All user profile data. Ready for print.
 * - $profile: Keyed array of profile categories and their items or other data
 *   provided by modules.
 *
 * @see template_preprocess_user_profile()
 */

  $channels = $profile['channels'];
  $reels = $profile['reels'];
  $showcase_reel = $profile['showcase_reel'];

if ($account->status==0) {
  print "<div class='profile-blocked'>Member status is not active.</div>";
  return;
}

?>

<div class="profile">

<?php if ($GLOBALS['base_url'] == $GLOBALS['ourmedia_base_url']) { ?>

  <div id="producer-showcase">
    <h3>Showcase</h3>
    <div id='producer-reels-content'><?php print theme('producer_showcase', $account, $reels, $user) ?></div>
  </div>

  <div id="producer-reels">
    <h3>Favorite Reels</h3>
    <div id='producer-reels-content'><?php print theme('producer_reels', $account, $reels, $user) ?></div>
  </div>

<!--<h3>Comments</h3>-->

<?php if ($account->profile_hidechannels != "1") { ?>
  <!-- My Groups Section -->
    <div>
      <h3>Channels I subscribe to (<?php print(count($channels)) ?>)</h3>
<?php if (count($channels))  { ?>
        <div>
          <span><?php $cnt=0; foreach ($channels as $channel) { print($cnt++ ? ", " : "") . $channel; } ?></span>
        </div>
<?php } ?>
<?php if (!count($channels))  { ?>
        <div>No channels yet.</div>

        <div class="explain">Channels <a title="Channels are simply a way of pulling together any collection of media items — created by you or others ... " href="<?php print $GLOBALS['ourmedia_base_url'] ?>/features#channels">explained</a>.</div>
<?php } ?>
    </div>

    <?php if (($user->uid == $account->uid) && ($account->uid > 0)) { ?>

      <div>
        <a href='<?php print $GLOBALS['channels_base_url'] ?>/node/add/channel' title='Create a channel ...'>Create your own channel</a>
      </div>

    <?php } ?>

<?php } ?>

  <?php /* print $user_profile;*/ ?>

  <br/>
  <br/>
  <div class='directory-link'><a href='<?php print $GLOBALS['ourmedia_base_url'] ?>/producers' title='Click here to browse or search the Digital Producers Directory'>Browse or search the <strong>Digital Producers Directory</strong></a></div>

<?php } else { ?>
  <?php if (user_access('administer nodes') || node_access("update", $node)) { ?>
  <div>This is your channels account page.</div>

  <div>To edit your channels settings, click the 'edit' tab above.</div>

  <div>To edit your ourmedia account settings, click <a href="<?php print $GLOBALS['ourmedia_base_url'] ?>/user/<?php print arg(1) ?>">here</a></div>

  <?php } else { 
    drupal_goto($GLOBALS['ourmedia_base_url'] ."/user/". arg(1));
 } ?>
<?php } ?>

</div>


