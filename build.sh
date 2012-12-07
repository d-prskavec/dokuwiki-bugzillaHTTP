#!/bin/bash
BUILDDIR=build
DISTDIR=dist
#PUBLISHDIR=/var/www/

rm -rf build/*
mkdir $BUILDDIR/bugzillaHTTP
cp -rv src/* $BUILDDIR/bugzillaHTTP/
cd $BUILDDIR
zip -r bugzillaHTTP_`date +%d-%m-%Y`.zip bugzillaHTTP/
cd -
mv $BUILDDIR/*.zip $DISTDIR
#sudo cp $DISTDIR/*.zip $PUBLISHDIR	
rm -rf build/*
