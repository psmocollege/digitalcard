#!/bin/sh
set -e

# Set ownership for the directories Drupal needs to write to.
# This ensures that the mounted persistent volumes are owned by the web server user.
chown -R www-data:www-data /var/www/html/web/sites/default/files
chown -R www-data:www-data /var/www/html/web/sites/default/private
# If you have a config sync directory, uncomment the next line
# chown -R www-data:www-data /var/www/html/config

# Execute the command passed to this script (e.g., "apache2-foreground")
exec "$@"
