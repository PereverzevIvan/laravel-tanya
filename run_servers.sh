cd /home/felix-laravel/
php artisan serve --port=3000 &
npm run dev &
php artisan queue:work & 
php artisan schedule:work