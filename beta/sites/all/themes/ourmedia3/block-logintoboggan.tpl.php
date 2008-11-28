<div id="signIn">
    <form>
    <div id="signInDivider">
      Welcome <a href="/user/<?php print $user->id ?>" alt="user profile" title='Click here to visit your profile.'><?php print $user->name ?></a>, click for <a href="http://beta.ourmedia.org/dashboard" alt="dashboard" title='Quick links to your main settings and features.'>dashboard</a>.
    </div>
    <div id="register">
      <a href="/logout" alt="sign out"><input type="button" name="" value="Sign out"></a>
    </div>
  </form>
</div>
