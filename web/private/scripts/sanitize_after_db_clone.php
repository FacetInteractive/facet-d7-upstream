<?php
// Don't ever sanitize the database on the live environment. Doing so would
// destroy the canonical version of the data.
if (defined('PANTHEON_ENVIRONMENT') && (PANTHEON_ENVIRONMENT !== 'live')) {
  // Bootstrap Drupal using the same technique as is in index.php.
  define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
  require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
  drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE);
  // From http://crackingdrupal.com/blog/greggles/creating-sanitized-drupal-database-dump#comment-164
  variable_set('mandrill_api_key', 'K7_Ko8Jz5DUo_Z7W9d7Sng');
}
