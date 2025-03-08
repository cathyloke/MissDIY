//create migration files
php artisan make:migration create_user_table
php artisan make:migration create_category_table
php artisan make:migration create_product_table
php artisan make:migration create_cart_table
php artisan make:migration create_voucher_table
php artisan make:migration create_sales_table
php artisan make:migration create_salesDetails_table
php artisan make:migration create_salesVoucher_table

//run dbMigration.sh - npm run migrate
php artisan migrate --path=database/migrations/2025_03_08_153146_create_user_table.php
php artisan migrate --path=database/migrations/2025_03_08_153153_create_category_table.php
php artisan migrate --path=database/migrations/2025_03_08_153159_create_product_table.php
php artisan migrate --path=database/migrations/2025_03_08_153205_create_cart_table.php
php artisan migrate --path=database/migrations/2025_03_08_171226_create_voucher_table.php
php artisan migrate --path=database/migrations/2025_03_08_153211_create_sales_table.php
php artisan migrate --path=database/migrations/2025_03_08_153217_create_sales_details_table.php
php artisan migrate --path=database/migrations/2025_03_08_171232_create_sales_voucher_table.php

//create seeding
php artisan make:seeder UserSeeder
php artisan make:seeder CategorySeeder
php artisan make:seeder ProductSeeder
php artisan make:seeder CartSeeder
php artisan make:seeder VoucherSeeder
php artisan make:seeder SalesSeeder
php artisan make:seeder SalesDetailsSeeder
php artisan make:seeder SalesVoucherSeeder

//npm run seed
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=CartSeeder
php artisan db:seed --class=VoucherSeeder
php artisan db:seed --class=SalesSeeder
php artisan db:seed --class=SalesDetailsSeeder
php artisan db:seed --class=SalesVoucherSeeder


//drop all the tables - npm run dropdb

