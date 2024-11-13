set -eu
set -o pipefail
echo "Deploy script started"
git fetch --all
php8.0 artisan down
git reset --hard origin/master
php composer install --no-interaction
php artisan migrate:fresh --seed --force
php artisan optimize:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan view:cache
php  artisan route:cache
php artisan storage:link
php artisan up
echo "Deploy script finished execution"
