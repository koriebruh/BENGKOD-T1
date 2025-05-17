php artisan make:migration create_periksa_tabel --create=periksa
php artisan make:migration create_obat_tabel --create=obat
php artisan make:migration create_detail_periksa_tabel --create=detail_periksa
php artisan make:migration create_jadwal_periksa_tabel --create=jadwal_periksa

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
php artisan make:model JadwalPeriksa

#MAKE CONTROLLER, itu gabungan repository service dan handler
php artisan make:controller AuthController
php artisan make:controller DokterController
php artisan make:controller PasienController

#test model
php artisan tinker
App\Models\User::all();
App\Models\Periksa::all();
App\Models\Obat::all();
App\Models\DetailPeriksa::all();

php artisan make:seeder ObatTableSeeder
php artisan make:seeder PeriksaTableSeeder
php artisan make:seeder DetailPeriksaTableSeeder
#
php artisan db:seed
php artisan db:seed --class=PeriksaTableSeeder
php artisan db:seed --class=ObatTableSeeder
php artisan db:seed --class=DetailPeriksaTableSeeder

