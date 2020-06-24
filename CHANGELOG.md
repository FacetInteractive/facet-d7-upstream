# Changelog

## 2020-06-24

* Update paths for `phpcs` and `phpcompatibility` to correctly install and run.
* Fix `updatemake.sh` for appropriate relative path build.
* Update Drupal to `7.72`. 
* Add new `lando drush-make` command to trigger site build operation.
* Add new `land drush-make-update` command to trigger contrib build update.

## 2020-06-09

* Initial launch of Facet-D7-Upstream to GitHub
* Lando base configuration for Drupal 7
* Opinionated Release Management custom module for tracking updates to configuration with hook_update_N
* Standard `pantheon.yml` configuration
* Standard Pantheon Quicksilver cloud hooks. 
* Programmatic builds with `./build/make.sh` and `./build/updatemake.sh` and a template `./build/site.make.yml`
* Standard / current patches based on PHP7.2 compatibility and known issues in the Issue Queue for contrib projects which have yet to be committed. 