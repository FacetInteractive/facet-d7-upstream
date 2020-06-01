<?php

// Rebuild the Registry
echo "Rebuild the registry...\n";
passthru('drush rr');
echo "Registry rebuild complete.\n";

echo "Rebuild the registry...\n";
passthru('drush env-switch development');
echo "Registry rebuild complete.\n";

//Clear all cache
echo "Clearing cache.\n";
passthru('drush cc all');
echo "Clearing cache complete.\n";