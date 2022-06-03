php artisan migrate
php artisan db:seed ActionSeeder
php artisan db:seed ConfigSeeder
php artisan db:seed POSTransaction2ProductColumnBasePriceSeeder
php artisan db:seed ProductNewPriceColumnsSeeder
php artisan db:seed PosTransaction2ProductSellingPriceSeeder

echo off
set /p x="Press any key to exit"