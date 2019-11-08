<?php

/**
 * @file
 * Drupal cache configuration.
 * @link http://helpdesk.getpantheon.com/customer/portal/articles/408428
 */
if (defined('PANTHEON_ENVIRONMENT')) {
  // Drupal caching in development environments.
  if (!in_array(PANTHEON_ENVIRONMENT, ['test', 'live'])) {
    // Anonymous caching.
    $conf['cache'] = 0;
    // Block caching - disabled.
    $conf['block_cache'] = 0;
    // Expiration of cached pages - none.
    $conf['page_cache_maximum_age'] = 0;
    // Aggregate and compress CSS files in Drupal - off.
    $conf['preprocess_css'] = 0;
    // Aggregate JavaScript files in Drupal - off.
    $conf['preprocess_js'] = 0;
    // Turn on All Error Reporting
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    $conf['error_level'] = 2;
  }
  // Drupal caching in test and live environments.
  else {
    // Anonymous caching - enabled.
    $conf['cache'] = 1;
    // Block caching - enabled.
    $conf['block_cache'] = 1;
    // Expiration of cached pages - 15 minutes.
    $conf['page_cache_maximum_age'] = 900;
    // Aggregate and compress CSS files in Drupal - on.
    $conf['preprocess_css'] = 1;
    // Aggregate JavaScript files in Drupal - on.
    $conf['preprocess_js'] = 1;
  }

  // Minimum cache lifetime - always none.
  $conf['cache_lifetime'] = 0;
  // Cached page compression - always off.
  $conf['page_compression'] = 0;

  switch(PANTHEON_ENVIRONMENT) {
    case 'live':
      // Disable email rerouting.
      $conf['reroute_email_enable'] = 0;
      // Set Admin Notification Email Group for Live
      $conf['reroute_email_address'] = "hosting@facetinteractive.com";
      break;
    default:
      // Enable email rerouting
      $conf['reroute_email_enable'] = 1;
      // Set Reroute Email Group
      $conf['reroute_email_address'] = "hosting@facetinteractive.com";
      break;
  }

  /**
   * Redis.
   *
   * Options for Further Redis Tuning:
   * https://github.com/pantheon-systems/pantheon-settings-examples/blob/master/drupal-7/settings.redis.php
   */
  $conf['redis_client_interface'] = 'PhpRedis';
  $conf['cache_backends'][] = 'sites/all/modules/contrib/redis/redis.autoload.inc';
  $conf['cache_default_class'] = 'Redis_Cache';
  $conf['cache_prefix'] = ['default' => 'pantheon-redis'];
  // Do not use Redis for cache_form (no performance difference).
  $conf['cache_class_cache_form'] = 'DrupalDatabaseCache';
  // Use Redis for Drupal locks (semaphore).
  $conf['lock_inc'] = 'sites/all/modules/contrib/redis/redis.lock.inc';

  /**
   * Solr configuration settings for Pantheon.
   */
  // $conf['pantheon_apachesolr_schema'] = 'sites/all/modules/contrib/apachesolr/solr-conf/solr-3.x/schema.xml';

  switch (PANTHEON_ENVIRONMENT) {
    case 'live':
      $base_url = 'https://www.example.com'; // NO trailing slash!
      $conf['https'] = TRUE;
      $cookie_domain = 'www.example.com';
      break;

    case 'test':
      $base_url = 'https://test.example.com'; // NO trailing slash!
      $conf['https'] = TRUE;
      $cookie_domain = 'test.example.com';
      break;

    case 'dev':
      $base_url = 'https://dev.example.com'; // NO trailing slash!
      $conf['https'] = TRUE;
      $cookie_domain = 'dev.example.com';
      break;

    default:
      $conf['https'] = TRUE;
      break;
  }

  /** @description If using composer_manager on Pantheon
   *               /scripts folder is where the real composer_mangager-specific composer.json file lives and is updated by code pushes.
   *               /files/private/composer is where the composer_manager writes the composer file and,
   *               due to autobuild being disabled, there are are no writes to the local server.
   */
  //$conf['composer_manager_file_dir'] = dirname(DRUPAL_ROOT) . '/scripts';
  $conf['composer_manager_file_dir'] = dirname(DRUPAL_ROOT) . '/web/sites/default/files/private/composer';
  $conf['composer_manager_vendor_dir'] = dirname(DRUPAL_ROOT) . '/web/sites/all/vendor';
  $conf['composer_manager_autobuild_file'] = FALSE;
  $conf['composer_manager_autobuild_packages'] = FALSE;

}

if (isset($_ENV['PANTHEON_ENVIRONMENT']) && php_sapi_name() != 'cli') {
  // Redirect to https://$primary_domain in the Live environment
  if ($_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
    /** Replace www.example.com with your registered domain name */
    $primary_domain = 'www.example.com';
  }
  else {
    // Redirect to HTTPS on every Pantheon environment.
    $primary_domain = $_SERVER['HTTP_HOST'];
  }

  if ($_SERVER['HTTP_HOST'] != $primary_domain
    || !isset($_SERVER['HTTP_USER_AGENT_HTTPS'])
    || $_SERVER['HTTP_USER_AGENT_HTTPS'] != 'ON' ) {

    # Name transaction "redirect" in New Relic for improved reporting (optional)
    if (extension_loaded('newrelic')) {
      newrelic_name_transaction("redirect");
    }

    header('HTTP/1.0 301 Moved Permanently');
    header('Location: https://'. $primary_domain . $_SERVER['REQUEST_URI']);
    exit();
  }
}

/**
 * Conditional Memory Limits - See https://docs.acquia.com/article/conditionally-increasing-memory-limits
 */
$path_collection = array(
  '512M' => array(
    'batch',
    'node/%node/edit',
  ),
);

$current_path = preg_replace("/\d+/", '%node', $_GET['q']);
foreach ($path_collection as $limit => $paths) {
  foreach ($paths as $path) {
    if (strpos($current_path, $path) === 0) {
      ini_set('memory_limit', $limit);
    }
  }
}

/**
 * Increase Drush memory limit.
 */
if (drupal_is_cli()) {
  ini_set('memory_limit', '1024M');
}

/**
 * Local Settings.
 */
$local_settings = dirname(__FILE__) . '/settings.local.php';
if (file_exists($local_settings)) {
  include $local_settings;
}
