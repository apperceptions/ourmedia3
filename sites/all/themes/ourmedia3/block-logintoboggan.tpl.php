
<div id="signIn">
    <form>
		<div id="signInDivider">
			Signed in as <a href="/user/<?php print $user->id ?>" alt="user profile"><?php print $user->name ?></a>
		</div>
		<div id="register">
			<a href="/logout" alt="sign out"><input type="button" name="" value="Sign out" class="button"></a>
		</div>
	</form>
</div>
		
