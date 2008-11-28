Description
------------------
  Provides shortcut paths to current user's pages, eg user/me, blog/me, 
  tracker/me etc. This means logged in users no longer have to know or
  remember their uid, and it makes it easier to link to user-specific 
  pages from a site help page (without resorting to using php to put 
  $user->uid in the link).

  Specified paths are recursive; If you specify user/me, user/me/edit 
  will also work.

Author
-----------------
Aldo Hoeben <aldo AT hoeben DOT net>