USE om;

/*
clean up - once before any extraction
*/

UPDATE ourmedia.users SET picture="" WHERE picture <> "" AND picture NOT LIKE "sites\/default\/files\/pictures\/%";
UPDATE ourmedia.users SET picture="" WHERE picture like "sites\/default\/files\/pictures\/picture-0.jpg";
	
 -- correct empty emails
UPDATE ourmedia.users SET mail = name WHERE mail = "" AND name LIKE "%@%";

 -- optional for fresh start, but never delete users 0 (anon) or 1 (admin)
DELETE FROM om.users WHERE uid > 1;


 -- TODO: do load statements need "CHARACTER SET latin1" added (or utf-8)?


/*
INSERT INTO om.users (
  uid,
  name,
  pass,
  mail,
  mode,
  sort,
  threshold,
  theme,
  signature,
  created,
  access,
  status,
  timezone,
  language,
  picture,
  init,
  data
)*/


SELECT
  uid,
  name,
  pass,
  mail,
  mode,
  sort,
  threshold,
  theme,
  signature,
  created,
  changed AS access,
  status,
  timezone,
  language,
  picture,
  init,
  data
FROM ourmedia.users 
WHERE uid > 1 AND status = 1
INTO OUTFILE '/tmp/users.txt';

 -- replace existing info
LOAD DATA INFILE '/tmp/users.txt' REPLACE INTO TABLE om.users (
  uid,
  name,
  pass,
  mail,
  mode,
  sort,
  threshold,
  theme,
  signature,
  created,
  access,
  status,
  timezone,
  language,
  picture,
  init,
  data
)

 -- generate shell commands like cp /opt/wwwvhost/ourmedia.org/sites/default/files/pictures/picture-3.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/pictures/ 

 -- some of these files are missing or invalid (some are not even valid filenames)

SELECT CONCAT("cp /opt/wwwvhost/ourmedia.org/", picture, " /opt/wwwvhost/dev.ourmedia.org/sites/default/files/pictures/") FROM ourmedia.users WHERE picture <> "" AND status = 1 INTO OUTFILE '/tmp/picturescp.sh';

 -- also site/ourmedia.org/files
 -- also www?

/*
SELECT nid, title, body FROM ourmedia.node WHERE body LIKE "%sites\/default\/files\/%" LIMIT 3\G

*/
	
/*
 profile fields - this only need be done once unless ourmedia.org updated
*/	
INSERT INTO om.profile_fields (
fid,
title,
name,
explanation,
category,
page,
type,
weight,
required,
register,
visibility,
options
)
SELECT 
fid,
title,
name,
explanation,
category,
page,
type,
weight,
required,
register,
visibility,
options
FROM ourmedia.profile_fields;

-- fix - can not use account here

UPDATE om.profile_fields SET type = "Options" WHERE type ="account";

INSERT INTO om.profile_values
SELECT DISTINCT pv.* FROM ourmedia.profile_values pv, ourmedia.users u
WHERE pv.uid=u.uid AND u.status=1;


 -- roles - only need import once
INSERT INTO om.role SELECT * FROM ourmedia.role;

 -- TODO: do not copy authenticated role? (later: why? rethink this query)

INSERT INTO om.users_roles SELECT * FROM ourmedia.users_roles ur, users u 
WHERE ur.uid=u.uid AND u.status=1;

 -- attachments (files)
INSERT INTO om.files SELECT fid, uid, filename, filepath, filemime, filesize, 1 AS status, UNIX_TIMESTAMP() FROM ourmedia.files f, ourmedia.node n WHERE filepath LIKE 'sites/default/files/%' AND filesize > 0 AND f.nid=n.nid AND status=1 AND type NOT LIKE "%media";

 -- note: using join as validation filter
SELECT CONCAT("cp '/opt/wwwvhost/ourmedia.org/", filepath, "' /opt/wwwvhost/dev.ourmedia.org/sites/default/files/") FROM ourmedia.files f, ourmedia.node n WHERE filepath LIKE 'sites/default/files/%' AND filesize > 0 AND f.nid=n.nid AND status=1 AND type NOT LIKE "%media" INTO OUTFILE '/tmp/filescopy.sh';


INSERT INTO om.upload SELECT fid, f.nid, f.nid AS vid, "" AS description, list, 0 AS weight FROM ourmedia.files f, ourmedia.node n WHERE filepath LIKE 'sites/default/files/%' AND filesize > 0 AND f.nid=n.nid AND status=1 AND type NOT LIKE "%media";

/*
cp /opt/wwwvhost/ourmedia.org/sites/default/files/LC_topper.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/
cp /opt/wwwvhost/ourmedia.org/sites/default/files/audio.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/
cp /opt/wwwvhost/ourmedia.org/sites/default/files/images.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/
cp /opt/wwwvhost/ourmedia.org/sites/default/files/text.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/
cp /opt/wwwvhost/ourmedia.org/sites/default/files/video.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/
cp /opt/wwwvhost/ourmedia.org/sites/default/files/multimedia.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/
cp /opt/wwwvhost/ourmedia.org/sites/default/files/open.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/
cp /opt/wwwvhost/ourmedia.org/sites/default/files/topic.gif /opt/wwwvhost/dev.ourmedia.org/sites/default/files/

INSERT INTO om.files (fid, uid, filename, filepath, filemime, filesize, status,  timestamp) VALUES (100, 3, 'LC_topper.gif', 'sites/default/files/LC_topper.gif', 'image/gif', 1, UNIX_TIMESTAMP());
INSERT INTO om.files (fid, uid, filename, filepath, filemime, filesize, status,  timestamp) VALUES (101, 3, 'audio.gif', 'sites/default/files/audio.gif', 'image/gif', 1, UNIX_TIMESTAMP());
INSERT INTO om.files (fid, uid, filename, filepath, filemime, filesize, status,  timestamp) VALUES (102, 3, 'images.gif', 'sites/default/files/images.gif', 'image/gif', 1, UNIX_TIMESTAMP());
INSERT INTO om.files (fid, uid, filename, filepath, filemime, filesize, status,  timestamp) VALUES (103, 3, 'text.gif', 'sites/default/files/text.gif', 'image/gif', 1, UNIX_TIMESTAMP());
INSERT INTO om.files (fid, uid, filename, filepath, filemime, filesize, status,  timestamp) VALUES (104, 3, 'video.gif', 'sites/default/files/video.gif', 'image/gif', 1, UNIX_TIMESTAMP());
INSERT INTO om.files (fid, uid, filename, filepath, filemime, filesize, status,  timestamp) VALUES (105, 3, 'multimedia.gif', 'sites/default/files/multimedia.gif', 'image/gif', 1, UNIX_TIMESTAMP());
INSERT INTO om.files (fid, uid, filename, filepath, filemime, filesize, status,  timestamp) VALUES (106, 3, 'open.gif', 'sites/default/files/open.gif', 'image/gif', 1, UNIX_TIMESTAMP());
INSERT INTO om.files (fid, uid, filename, filepath, filemime, filesize, status,  timestamp) VALUES (107, 3, 'topic.gif', 'sites/default/files/topic.gif', 'image/gif', 1, UNIX_TIMESTAMP());

 -- how get resulting fids in an automated fashion? 

INSERT INTO om.upload (fid, nid, vid, description, list, weight) VALUES (100, 220800, 220800, '', 0, 0);
INSERT INTO om.upload (fid, nid, vid, description, list, weight) VALUES (101, 220800, 220800, '', 0, 0);
INSERT INTO om.upload (fid, nid, vid, description, list, weight) VALUES (102, 220800, 220800, '', 0, 0);
INSERT INTO om.upload (fid, nid, vid, description, list, weight) VALUES (103, 220800, 220800, '', 0, 0);
INSERT INTO om.upload (fid, nid, vid, description, list, weight) VALUES (104, 220800, 220800, '', 0, 0);
INSERT INTO om.upload (fid, nid, vid, description, list, weight) VALUES (105, 220800, 220800, '', 0, 0);
INSERT INTO om.upload (fid, nid, vid, description, list, weight) VALUES (106, 220800, 220800, '', 0, 0);
INSERT INTO om.upload (fid, nid, vid, description, list, weight) VALUES (107, 220800, 220800, '', 0, 0);
*/

 -- add new types (just do this once)
INSERT INTO om.node_type (type, name, module, description, help, has_title, title_label, has_body, body_label, min_word_count, custom, modified, locked, orig_type) 
VALUES ("audiomedia", "Audio media", "node", "", "", 1, "Title", 1, "Body", 0, 1, 1, 0, "");

INSERT INTO om.node_type (type, name, module, description, help, has_title, title_label, has_body, body_label, min_word_count, custom, modified, locked, orig_type) 
VALUES ("imagemedia", "Image media", "node", "", "", 1, "Title", 1, "Body", 0, 1, 1, 0, "");

INSERT INTO om.node_type (type, name, module, description, help, has_title, title_label, has_body, body_label, min_word_count, custom, modified, locked, orig_type) 
VALUES ("textmedia", "Text media", "node", "", "", 1, "Title", 1, "Body", 0, 1, 1, 0, "");

INSERT INTO om.node_type (type, name, module, description, help, has_title, title_label, has_body, body_label, min_word_count, custom, modified, locked, orig_type) 
VALUES ("videomedia", "Video media", "node", "", "", 1, "Title", 1, "Body", 0, 1, 1, 0, "");

CREATE TABLE content_type_audiomedia (
  `vid` int(10) unsigned NOT NULL default '0',
  `nid` int(10) unsigned NOT NULL default '0',
  `field_identifier` longtext,
  PRIMARY KEY  (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE content_type_imagemedia (
  `vid` int(10) unsigned NOT NULL default '0',
  `nid` int(10) unsigned NOT NULL default '0',
  `field_identifier` longtext,
  PRIMARY KEY  (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE content_type_textmedia (
  `vid` int(10) unsigned NOT NULL default '0',
  `nid` int(10) unsigned NOT NULL default '0',
  `field_identifier` longtext,
  PRIMARY KEY  (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE content_type_videomedia (
  `vid` int(10) unsigned NOT NULL default '0',
  `nid` int(10) unsigned NOT NULL default '0',
  `field_identifier` longtext,
  PRIMARY KEY  (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO om.content_node_field ( field_name, type, global_settings, required, multiple, db_storage, module, db_columns, active) VALUES ('field_identifier', 'text', 'a:4:{s:15:"text_processing";s:1:"0";s:10:"max_length";s:0:"";s:14:"allowed_values";s:0:"";s:18:"allowed_values_php";s:0:"";}', 0, 0, 1, 'text', 'a:1:{s:5:"value";a:4:{s:4:"type";s:4:"text";s:4:"size";s:3:"big";s:8:"not null";b:0;s:8:"sortable";b:1;}}', 1);

INSERT INTO om.content_node_field_instance (field_name, type_name, weight, label, widget_type, widget_settings, display_settings, description, widget_module, widget_active) VALUES ('field_identifier', 'audiomedia', 0, 'Identifer', 'text_textfield', 'a:3:{s:4:"rows";i:1;s:13:"default_value";a:1:{i:0;a:1:{s:5:"value";s:0:"";}}s:17:"default_value_php";N;}
', 'a:6:{s:5:"label";a:1:{s:6:"format";s:5:"above";}s:6:"teaser";a:1:{s:6:"format";s:7:"default";}s:4:"full";a:1:{s:6:"format";s:7:"default";}i:4;a:1:{s:6:"format";s:7:"default";}i:2;a:1:{s:6:"format";s:7:"default";}i:3;a:1:{s:6:"format";s:7:"default";}}
', '', 'text', 1);

INSERT INTO om.content_node_field_instance (field_name, type_name, weight, label, widget_type, widget_settings, display_settings, description, widget_module, widget_active) VALUES ('field_identifier', 'imagemedia', 0, 'Identifer', 'text_textfield', 'a:3:{s:4:"rows";i:1;s:13:"default_value";a:1:{i:0;a:1:{s:5:"value";s:0:"";}}s:17:"default_value_php";N;}
', 'a:6:{s:5:"label";a:1:{s:6:"format";s:5:"above";}s:6:"teaser";a:1:{s:6:"format";s:7:"default";}s:4:"full";a:1:{s:6:"format";s:7:"default";}i:4;a:1:{s:6:"format";s:7:"default";}i:2;a:1:{s:6:"format";s:7:"default";}i:3;a:1:{s:6:"format";s:7:"default";}}
', '', 'text', 1);

INSERT INTO om.content_node_field_instance (field_name, type_name, weight, label, widget_type, widget_settings, display_settings, description, widget_module, widget_active) VALUES ('field_identifier', 'textmedia', 0, 'Identifer', 'text_textfield', 'a:3:{s:4:"rows";i:1;s:13:"default_value";a:1:{i:0;a:1:{s:5:"value";s:0:"";}}s:17:"default_value_php";N;}
', 'a:6:{s:5:"label";a:1:{s:6:"format";s:5:"above";}s:6:"teaser";a:1:{s:6:"format";s:7:"default";}s:4:"full";a:1:{s:6:"format";s:7:"default";}i:4;a:1:{s:6:"format";s:7:"default";}i:2;a:1:{s:6:"format";s:7:"default";}i:3;a:1:{s:6:"format";s:7:"default";}}
', '', 'text', 1);

INSERT INTO om.content_node_field_instance (field_name, type_name, weight, label, widget_type, widget_settings, display_settings, description, widget_module, widget_active) VALUES ('field_identifier', 'videomedia', 0, 'Identifer', 'text_textfield', 'a:3:{s:4:"rows";i:1;s:13:"default_value";a:1:{i:0;a:1:{s:5:"value";s:0:"";}}s:17:"default_value_php";N;}
', 'a:6:{s:5:"label";a:1:{s:6:"format";s:5:"above";}s:6:"teaser";a:1:{s:6:"format";s:7:"default";}s:4:"full";a:1:{s:6:"format";s:7:"default";}i:4;a:1:{s:6:"format";s:7:"default";}i:2;a:1:{s:6:"format";s:7:"default";}i:3;a:1:{s:6:"format";s:7:"default";}}
', '', 'text', 1);



 -- update content nodes

SELECT
  n.nid, 
  n.nid as vid,   
  n.type,
  "" as language,
  n.title,
  n.uid,
  n.status,
  n.created,
  n.changed,
  n.comment,
  n.promote,
  n.moderate,
  n.sticky,
  0 as tnid,
  0 as translate
FROM ourmedia.node n, ourmedia.users u
WHERE n.status = 1 AND n.type NOT IN ('', 'event', 'flexinode-2', 'flexinode-5', 'flexinode-8', 'flexinode-9', 'forum', 'media', 'og', 'poll', 'survey') AND n.uid = u.uid AND u.status = 1
INTO OUTFILE '/tmp/node.txt';

 -- replace existing info
LOAD DATA INFILE '/tmp/node.txt' REPLACE INTO TABLE om.node (
  nid,
  vid,
  type,
  language,
  title,
  uid,
  status,
  created,
  changed,
  comment,
  promote,
  moderate,
  sticky,
  tnid,
  translate 
);

  
 -- update node revisions

 -- TODO: consider charsets
 -- also, filter with valid users

SELECT
  n.nid,    
  n.nid as vid,
  n.uid,
  n.title,
  n.body,
  n.teaser,
  "" as log,
  0 as timestamp,
  n.format
FROM ourmedia.node n, ourmedia.users u
WHERE n.status = 1 AND n.type NOT IN ('', 'event', 'flexinode-2', 'flexinode-5', 'flexinode-8', 'flexinode-9', 'forum', 'media', 'og', 'poll', 'survey') AND n.uid = u.uid AND u.status = 1
INTO OUTFILE '/tmp/node_revisions.txt';
     
 -- replace existing info
LOAD DATA INFILE '/tmp/node_revisions2.txt' REPLACE INTO TABLE om.node_revisions (
  nid,
  vid,
  uid,
  title,
  body,
  teaser,
  log,
  timestamp,
  format
);


-- node-comment-stats for tracking

SELECT
  n.nid, 
  0 as comment_count
FROM ourmedia.node n, ourmedia.users u
WHERE n.status = 1 AND n.type NOT IN ('', 'event', 'flexinode-2', 'flexinode-5', 'flexinode-8', 'flexinode-9', 'forum', 'media', 'og', 'poll', 'survey') AND n.uid = u.uid AND u.status = 1
INTO OUTFILE '/tmp/node_comment_statistics.txt';

 -- replace existing info
LOAD DATA INFILE '/tmp/node_comment_statistics.txt' REPLACE INTO TABLE om.node_comment_statistics (
  nid,
  comment_count
);

  


 -- clean up types
UPDATE om.node SET type = 'media' WHERE type LIKE "%media";

 -- url aliases

SELECT pid, src, dst FROM ourmedia.url_alias 
INTO OUTFILE '/tmp/url_alias.txt';         

 -- replace existing info
LOAD DATA INFILE '/tmp/url_alias.txt' REPLACE INTO TABLE om.url_alias (pid, src, dst);

 -- archive identifiers to cck
 -- TODO: filter on ia status or identifier?

SELECT
  n.nid, 
  n.nid as vid,
  ia_identifier as field_identifier_value 
FROM ourmedia.node n, ourmedia.ia, ourmedia.users u WHERE ia.nid=n.nid AND u.uid=n.uid AND n.status=1 AND u.status=1 AND n.type IN ('audiomedia', 'imagemedia', 'textmedia', 'videomedia') AND ia.ia_identifier <> ""
INTO OUTFILE '/tmp/ia.txt';

 -- replace existing info
LOAD DATA INFILE '/tmp/ia.txt' REPLACE INTO TABLE om.content_type_media (nid, vid, field_identifier_value);

  
 -- convert media types to a category (cat 4 values of audio=19..video=21 are hard coded here.  you may need to change to fit yours

SELECT
  n.nid, n.nid as vid, if(n.type='audiomedia', 18, if(n.type='imagemedia', 19, if(n.type='textmedia', 20, 21)))
FROM ourmedia.node n, ourmedia.users u WHERE u.uid=n.uid AND n.status=1 AND u.status=1 AND n.type IN ('audiomedia', 'imagemedia', 'textmedia', 'videomedia')
INTO OUTFILE '/tmp/mediatype.txt';


 -- replace existing info
LOAD DATA INFILE '/tmp/mediatype.txt' REPLACE INTO TABLE om.term_node (nid, vid, tid);


 -- set filepath so redirection goes to archive
/*
SELECT count(*) FROM ourmedia.files f, ourmedia.node n, ourmedia.users u, ourmedia.ia WHERE u.uid=n.uid AND filepath = "" AND n.nid=f.nid AND n.type LIKE "%media" AND filesize > 0 AND filemime <> "" AND filename <> "" and u.status =1 AND n.status=1 AND ia.nid = f.nid AND ia.ia_identifier <> "";

SELECT f.fid, f.nid, f.filename, f.filemime FROM ourmedia.files f, ourmedia.node n, ourmedia.users u, ourmedia.ia WHERE u.uid=n.uid AND filepath = "" AND n.nid=f.nid AND n.type LIKE "%media" AND filesize > 0 AND filemime <> "" AND filename <> "" and u.status =1 AND n.status=1 AND ia.nid = f.nid AND ia.ia_identifier <> "";

*/

  
INSERT INTO om.files SELECT f.fid, n.uid, f.filename, CONCAT("internetarchive/", ia.ia_identifier, "/", f.filename), f.filemime, f.filesize, 1 AS status, UNIX_TIMESTAMP() FROM ourmedia.files f, ourmedia.node n, ourmedia.users u, ourmedia.ia  WHERE u.uid=n.uid AND filepath = "" AND n.nid=f.nid AND n.type LIKE "%media" AND filesize > 0 AND filemime <> "" AND filename <> "" and u.status =1 AND n.status=1 AND ia.nid = f.nid AND ia.ia_identifier <> "";


 -- set list to 1

/*
INSERT INTO om.upload SELECT f.fid, f.nid, f.nid AS vid, "" AS description, f.list, 0 AS weight FROM ourmedia.files f, ourmedia.node n, ourmedia.users u, ourmedia.ia WHERE u.uid=n.uid AND filepath = "" AND n.nid=f.nid AND n.type LIKE "%media" AND filesize > 0 AND filemime <> "" AND filename <> "" and u.status =1 AND n.status=1 AND ia.nid = f.nid AND ia.ia_identifier <> "";
*/

INSERT INTO om.upload SELECT f.fid, f.nid, f.nid AS vid, "" AS description, 1 AS list, 0 AS weight FROM ourmedia.files f, ourmedia.node n, ourmedia.users u, ourmedia.ia WHERE u.uid=n.uid AND filepath = "" AND n.nid=f.nid AND n.type LIKE "%media" AND filesize > 0 AND filemime <> "" AND filename <> "" and u.status =1 AND n.status=1 AND ia.nid = f.nid AND ia.ia_identifier <> "";


 -- media node descriptions

SELECT
  m.nid, 
  m.nid AS vid,
  u.uid, 
  n.title,
  m.value AS body,
  n.teaser AS teaser,
  "" as log,
  0 as timestamp,
  n.format
FROM ourmedia.metadata_data m, ourmedia.node n, ourmedia.ia, ourmedia.users u, ourmedia.files f WHERE m.nid=n.nid AND u.uid=n.uid AND filepath = "" AND n.nid=f.nid AND n.type LIKE "%media" AND f.filesize > 0 AND f.filemime <> "" AND f.filename <> "" AND u.status =1 AND n.status=1 AND ia.nid = f.nid AND ia.ia_identifier <> "" AND m.type = "metadata_description"
INTO OUTFILE '/tmp/nodedesc.txt';

 -- replace existing info
LOAD DATA INFILE '/tmp/nodedesc.txt' REPLACE INTO TABLE om.node_revisions (
  nid,
  vid,
  uid,
  title,
  body,
  teaser,
  log,
  timestamp,
  format
);

 -- comments - not tested yet

SELECT 
c.cid,
c.pid,
c.nid,
c.uid,
c.subject,
c.comment,
c.hostname,
c.timestamp,
c.status,
c.format,
c.thread,
c.users,
c.name,
c.mail,
c.homepage 
FROM ourmedia.comemnts c, ourmedia.node n, ourmedia.users u WHERE c.nid=n.nid AND u.uid=n.uid AND u.status=1 AND n.status=1 AND c.status=1
INTO OUTFILE '/tmp/comments.txt';

LOAD DATA INFILE '/tmp/comments.txt' REPLACE INTO TABLE om.comments (
cid,
pid,
nid,
uid,
subject,
comment,
hostname,
timestamp,
status,
format,
thread,
users,
name,
mail,
homepage
);

/*

 -- repeat for by, by-nc, by-nc-sa, by-nc-nd, etc
 -- rest are traditional copyright
 -- also 2.0 and 2.5 and 3.0

SELECT 
cc.nid,
FROM ourmedia.creativecommons cc, ourmedia.node n, ourmedia.users u, ourmedia.ia ia
WHERE n.nid=cc.nid AND u.uid=n.uid AND ia.nid=cc.nid AND u.status=1 AND n.status=1 AND ia.ia_identifier <> ""
AND data LIKE "%http://creativecommons.org/licenses/by/2.0%"
INTO OUTFILE '/tmp/cc-by-2.0.txt';

SELECT 
cc.nid,
FROM ourmedia.creativecommons cc, ourmedia.node n, ourmedia.users u, ourmedia.ia ia
WHERE n.nid=cc.nid AND u.uid=n.uid AND ia.nid=cc.nid AND u.status=1 AND n.status=1 AND ia.ia_identifier <> ""
AND data LIKE "%http://creativecommons.org/licenses/by/2.0%"
INTO OUTFILE '/tmp/copyright.txt';
*/

 -- extract for shell processing - note that there may be dup nid's here

-- todo: use  ESCAPED BY ""

SELECT
cc.nid,
cc.data
FROM ourmedia.creativecommons cc, ourmedia.node n, ourmedia.users u, ourmedia.ia ia
WHERE n.nid=cc.nid AND u.uid=n.uid AND ia.nid=cc.nid AND u.status=1 AND n.status=1 AND ia.ia_identifier <> ""
INTO OUTFILE '/tmp/licenses.txt' FIELDS TERMINATED BY ':' ;

-- extract node id and two parts of uri (if any)
awk 'BEGIN { FS=OFS=":" } { print $1 "," $10$11 }' licenses.txt > licenses2.txt
-- fix escaped uri colon from mysql export - can remove if use  ESCAPED BY ""
awk '{sub(/\\/,":");print}' licenses2.txt > licenses3.txt
-- remove leftover trailing data from export of serialized drupal data element
awk '{sub(/;s\\/,"");print}' licenses3.txt > licenses4.txt
-- replace copyright licences with null string
awk '{sub(/license_name\";N;s:12\\/,"\"");print}' licenses4.txt > licenses5.txt
awk '{sub(/license_name\";N;s:21\\/,"\"");print}' licenses5.txt > licenses6.txt
-- strip main part of uri's
awk '{sub(/http:\/\/creativecommons.org\/licenses\//,"");print}' licenses6.txt > licenses7.txt
-- get rid trailing quote in license
awk '{gsub(/\"/,"");print}' licenses7.txt > licenses8.txt
-- back to tab delimited format for mysql inport
awk '{gsub(/,/,"\t");print}' licenses8.txt > licenses9.txt


 -- import licenses into cck - but do not load directly however as it will replace exiting data

use om;

CREATE TABLE `temp_license` (
  `nid` int(10) unsigned NOT NULL default '0',
  `license` longtext,
  PRIMARY KEY  (`nid`)
);

LOAD DATA INFILE '/tmp/licenses9.txt' REPLACE INTO TABLE om.temp_license (nid, license);

 -- note: could we do this with a category instead?

-- note: we are assuming that nid=vid

UPDATE om.content_type_media m, (
SELECT DISTINCT l.nid, l.license
FROM om.temp_license l) AS e
SET m.field_license_value = e.license
WHERE m.vid = e.nid;

-- term-data keywords (cat 7 in 4.6 and 3 in 6.0) YMMV

SELECT 
td.tid as tid, 
3 as vid, 
"" as description,
0 as weight,
td.name
FROM ourmedia.term_data td
WHERE td.vid = 7
INTO OUTFILE '/tmp/term_data.txt' FIELDS TERMINATED BY ',' ESCAPED BY "";

-- clean up with awk

-- chop after first comma in name
awk 'BEGIN { FS=OFS=","} { print $1 "," $2 "," $3 "," $4 "," $5}' term_data.txt  > term_data2.txt
-- no more than two spaces allowed
awk 'BEGIN { FS=OFS=" "} { print $1 " " $2 " " $3}' term_data2.txt  > term_data3.txt
-- chop after first semi-colon in name
awk 'BEGIN { FS=OFS=";"} { print $1}' term_data3.txt  > term_data4.txt
-- chop after first paren in name
awk 'BEGIN { FS=OFS="("} { print $1}' term_data4.txt  > term_data5.txt
-- no lines over 25 chars long
awk 'BEGIN { if (length() < 25) print}' term_data5.txt  > term_data6.txt

-- import

LOAD DATA INFILE '/tmp/term_data6.txt' REPLACE INTO TABLE om.term_data (nid, license);


-- experiment: get all ourmedia collection contributor emails using oai interface (see separate php file for parser)

awk 'BEGIN {FS=OFS=","} {print $2}' ia2005.txt ia2006.txt ia2007.txt ia2008.txt > iamail.txt
sort -f -u < iamail.txt > iamailsort.txt
wc -l iamailsort.txt 


