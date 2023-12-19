
# Sobat Sehat

Backend system of sobat sehat web platform


## Environment Variables

Untuk memulai dan menjalankan aplikasi, ubah

`DB_CONNECTION=mysql`

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=sobat_sehat`

`DB_USERNAME=username_mysql`

`DB_PASSWORD=password_mysql`


## Installation

Buat database sobat Sehat

```bash
  CREATE DATABASE sobat_sehat;
```

Install Sobat Sehat Project By Composer

```bash
  composer install
  composer dump autoload
```


Jalankan Konfigurasi Artisan
```bash
  php artisan migrate
  php artisan db:seed DatabaseSeeder
  php artisan jwt:secret
```
## Authors

- [@billiyagi](https://www.github.com/billiyagi)
- [@maxzcv](https://github.com/Mr101003)
- [@IlmanNK](https://github.com/IlmanNK)
- [@Dimasriooo](https://github.com/Dimasriooo)
- [@iraprtw12](https://github.com/iraprtw12)
- [@Abdulghofar1234](https://github.com/Abdulghofar1234)

