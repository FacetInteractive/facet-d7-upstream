<?php

//Revert all features
// Temporary run drush fra before drush updb
echo "Reverting all features...\n";
passthru('drush fra -y');
echo "Reverting complete.\n";

// Disable Features from other Environments
echo "Disabling features meant for other environments...\n";
//passthru('drush dis devel -y');
echo "Disabling complete.\n";

// Enable New Features
echo "Enabling UUID module which has to generate uuids for all content on first enable...\n";
//passthru('drush en uuid, uuid_features -y');
echo "Enabling complete.\n";

//Update the database
echo "Update the database...\n";
passthru('drush updb -y');
echo "Database update complete.\n";

// Disable Features from other Environments
echo "Disabling features meant for other environments...\n";
//passthru('drush dis  -y');
echo "Disabling complete.\n";

// Always Check the Environment and Switch Modules on or off based on config
$environments  = [
                    'dev' => 'development',
                    'develop' => 'development',
                    'test' => 'production',
                    'live' => 'production',
                    'live-backup' => 'production'
                  ];

echo "Checking Environment and Disabling or Enabling Development modules\n";
/* @description If environment is in predefined production or development
 *              ENVs pass it through, otherwise default to development */
$env_catch = (isset($environments[$_ENV['PANTHEON_ENVIRONMENT']])) ? $environments[$_ENV['PANTHEON_ENVIRONMENT']] : 'development';
$env_switch = 'drush env-switch ' . $env_catch . ' --force --no-halt-on-error';
passthru($env_switch);
echo "Environment switch complete.\n";

//Clear all cache
echo "Clearing cache.\n";
passthru('drush cc all');
echo "Clearing cache complete.\n";