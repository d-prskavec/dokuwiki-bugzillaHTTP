dokuwiki-bugzilla-HTTP
======================

This dokuwiki plugin gives you the possibility to quite easily render 
a table of bugs from your bugzilla instance within your dokuwiki. It is
published under the GNU GPL v3.

This plugin was developed for and "tested" with:
dokuwiki release 2012-01-25 "Angua"
and bugzilla v3.4.13

It fetches the xml-view of a single or multiple bugzilla bugs and renders
them into a coloured table in the dokuwiki.  


To get this to work in your dokuwiki instance:
----------------------------------------------

1. call ./build.sh
2. upload the generated .zip file (in dist/) to a web accessible dir
3. login as admin into dokuwiki
4. go to plugin manager
5. enter the url of the zip file
6. go to configuration settings
7. enter the urls of your bugzilla instance


How to use it in your dokuwiki:
-------------------------------

the syntax is:

	[buglist | <bugid>,<bugid>,...]
e.g.: 

	[buglist | 1,23,543 , 69]

!always enter ``~~NOCACHE~~`` at the top of your wikipage, otherwise the 
bugstatus will not update on the reload of the page, because it is prerendered.
