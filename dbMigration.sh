#!/bin/bash

echo "Running database migration files..."

# Running database migration files
php artisan migrate --path=database/migrations/2014_10_12_000000_create_users_table.php

php artisan migrate --path=database/migrations/2025_03_08_153153_create_category_table.php

php artisan migrate --path=database/migrations/2025_03_08_153159_create_product_table.php

php artisan migrate --path=database/migrations/2025_03_08_153205_create_cart_table.php

php artisan migrate --path=database/migrations/2025_03_08_171226_create_voucher_table.php

php artisan migrate --path=database/migrations/2025_03_08_153211_create_sales_table.php

php artisan migrate --path=database/migrations/2025_03_08_153217_create_sales_details_table.php

php artisan migrate --path=database/migrations/2025_03_08_171232_create_sales_voucher_table.php

echo "Migration files completed!"
