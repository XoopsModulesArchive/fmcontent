Edit .htaccess codes for make your URL :

some example :

1- normal :
  RewriteRule   ^([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)\.html$ content.php?id=$2&page=$3 [L]
  RewriteRule   ^fmcontent/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)\.html$ modules/fmcontent/content.php?id=$2&page=$3 [L]
  
2- if you edit module name to NEWNAME: 
  RewriteRule   ^([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)\.html$ content.php?id=$2&page=$3 [L]
  RewriteRule   ^NEWNAME/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)\.html$ modules/fmcontent/content.php?id=$2&page=$3 [L]
  
3- if you remove module name : 
  RewriteRule   ^([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)\.html$ content.php?id=$2&page=$3 [L]
  RewriteRule   ^([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)\.html$ modules/fmcontent/content.php?id=$2&page=$3 [L]
  
4- if you remove Url extension  
  RewriteRule   ^([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)$ content.php?id=$2&page=$3 [L]
  RewriteRule   ^fmcontent/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)$ modules/fmcontent/content.php?id=$2&page=$3 [L]
  
5- if you use short URL
  RewriteRule   ^([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)\.html$ content.php?page=$3 [L]
  RewriteRule   ^fmcontent/([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)\.html$ modules/fmcontent/content.php?page=$3 [L]
  