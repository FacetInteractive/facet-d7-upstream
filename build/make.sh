#!/usr/bin/env bash

# Switch to document root.
cd "$(dirname "$0")"
# switch to web directory
cd ../web/

# Delete existing files.
printf "Deleting contrib modules, themes, and libraries...\n "
rm -rf sites/all/libraries/*
rm -rf sites/all/modules/contrib/
rm -rf sites/all/themes/contrib/

# Drush Make
printf "Executing Drush Make...\n"
drush make ../scripts/site.make.yml -y

# Switch back to document root
printf "Installing composer in project root  \n"
cd "$(dirname "$0")"
# Update composer
composer update --lock
printf "Composer installed...\n"

printf "Build Complete...\n"