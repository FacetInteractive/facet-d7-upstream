<?php

// Turn on All Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$conf['error_level'] = 2;

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

/**
 * Composer Manager, if installed
 */
$conf['composer_manager_autobuild_file'] = FALSE;
$conf['composer_manager_autobuild_packages'] = FALSE;
// If Composer Manager, we use a separate folder from the root /vendor
$conf['composer_manager_vendor_dir'] = '/app/web/sites/all/vendor';

/**
 * Local Environment URL
 */
$base_url = 'https://example.lndo.site';
$conf['https'] = TRUE;

/**
 * Stage File Proxy
 */
$conf['stage_file_proxy_origin'] = 'https://www.example.com'; // NO trailing slash

// CLI use more memory on local
if (drupal_is_cli()) {
  ini_set('memory_limit', '2048M');
}

// Enable email rerouting.
$conf['reroute_email_enable'] = 0;
// Enable inserting a message into the email body when the mail is being
// rerouted.
$conf['reroute_email_enable_message'] = 1;
// Space, comma, or semicolon-delimited list of email addresses to pass
// through. Every destination email address which is not on this list will be
// rerouted to the first address on the list.
$conf['reroute_email_address'] = "jordan@facetinteractive.com";
// Set Email Send API Key to Live Key to be able to send emails from local
if ($conf['reroute_email_enable'] == 1) {
  // LIVE KEY
  // Set a Live Email Credential
} else {
  // TEST KEY
  // Set a test email credential
}