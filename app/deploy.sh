#!/bin/sh -v

cd ~/tmp

DIRECTORY="grecocos"
if [ -d "$DIRECTORY" ]; then
  rm -rf grecocos
fi

cp -r ~/Sites/cake/1.3.0-RC2 $DIRECTORY
cd grecocos
rm .htaccess
rm -rf app
git clone git@github.com:sunny36/grecocos.git app
cd app/config
rm database.php
mv database.php.production database.php
cd ../../
rm index.php 
cp -r app/webroot/* . 
rm index.php 
cp ~/Sites/cake/1.3.0-RC2/index.php .
cp -r ~/Sites/cake/1.3.0-RC2/app/tmp app/
