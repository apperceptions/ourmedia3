<?php
// $Id$
/* @file
 * user list block
 */
//var_dump(get_defined_vars());

if (user_access('access content')) {
  // Count users with activity in the past defined period.
  $time_period = variable_get('user_block_seconds_online', 900);

  // Perform database queries to gather online user lists.
  $users = db_query('SELECT uid, name, access, picture FROM {users} WHERE access >= %d AND uid <> 0 ORDER BY access DESC', time() - $time_period);
  $total_users = mysql_num_rows($users);

  $output .= "<div id='block-userlist' class='block'>\n<h2>Who's Online - <small>There are currently ". $total_users ." user". ($total_users == 1 ? "" : "s") ." online</small></h2>\n";
  // Display a list of currently online users.
  $max_users = variable_get('user_block_max_list_count', 10);
  if ($total_users && $max_users) {
    $output .= "<ul class='userlist'>\n";
    $cnt = 0;
    $rowcnt = 1;
    while ($max_users-- && $account = db_fetch_object($users)) {
      if (empty($account->picture))
        $picture = "/". $directory ."/images/whosImg.jpg";
      else
        $picture = $account->picture;
      $output .= "<li class=\"whosBox\"><a href=\"/user/". $account->uid ."\"><img class='userthumb' src=\"". $picture ."\" /></a><br/><a href=\"/user/". $account->uid ."\">" . $account->name ."</a></li>\n";
      $cnt++;
      if ($cnt % 4 == 0) {
        if ($max_users && ($cnt < $total_users)) {
          $output .= "</ul>\n<br/>\n";
          $output .= "<ul class='userlist'>\n";
          $rowcnt++;
        }
      }
    }
    $output .= "<div class='whosListHidden'>\n";
    for ($i=0; $i<$rowcnt; $i++) {
      $output .= "<div class='whosBoxHidden'><img src='/". $directory ."/images/whosImg.jpg' /><br/>X</div>\n";
    }
    $output .= "</div>\n";
    $output .= "</ul>\n<br/>\n";
  }
  $output .= "<div class=\"whyJoin\"><a href=\"/why-register\">Why join Ourmedia?</a></div>\n";
  $output .= "</div>\n";
}
print $output;

