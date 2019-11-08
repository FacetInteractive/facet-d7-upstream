#!/usr/bin/env bash

# Switch to document root.
cd "$(dirname "$0")"
cd ../web/

# optionally add --check-disabled
drush make-update ../scripts/site.make.yml --result-file="../scripts/site.make.yml"