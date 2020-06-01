#!/bin/bash

# Developer setup after installing a new copied prod db.
drush=/usr/local/bin/drush

# Switch to document root.
cd "$(dirname "$0")"
cd ../web/

# Rebuild the registry.
$drush rr

# Enable development modules.
$drush env-switch development

# Enable local development modules
$drush en stage_file_proxy -y && \

# Update database.
$drush updb -y && \

# Rebuild the registry.
$drush rr && \

# Revert all features.
$drush fra -y && \

# Sanitize user emails and passwords.
# @TODO - Enable user sanitization as needed
# $drush -y sqlsan --sanitize-email='user-%uid@localhost.dev' --sanitize-password=pwd && \

COMPLETE=$?

# Rebuild the registry again.
$drush rr

# Login
if [ "$COMPLETE" == "0" ]; then
  $drush uli
else
  echo "An error occurred during DB sanitization..."
fi
