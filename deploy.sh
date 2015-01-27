#!/bin/sh

PATH=$PATH:$HOME/bin
export PATH

cd public_html/hrblog/wp-content/themes
git init
git remote add origin git@github.com:diegobcorrea/hrmag.git
git pull origin master
