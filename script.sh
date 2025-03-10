php artisan make:migration create_periksa_tabel --create=periksa
php artisan make:migration create_obat_tabel --create=obat
php artisan make:migration create_detail_periksa_tabel --create=detail_periksa

#php artisan make:factory UserFactory --model=User
php artisan make:seeder UsersTableSeeder

#generate table
php artisan migrate
#generate seeder
php artisan db:seed
php artisan migrate:refresh --seed

# MODEL ITU DI LARAVEL ITU SAMA KEK ENTITY
php artisan make:model User
php artisan make:model Periksa
php artisan make:model Obat
php artisan make:model DetailPeriksa

#MAKE CONTROLLER, itu gabungan repository service dan handler
php artisan make:controller AuthController
php artisan make:controller PeriksaController
php artisan make:controller ObatController

