# BlogKu - Blog Multi-User

Project Akhir Pemrograman Web - FMIPA UNIMED

## Fitur

- Multi-user (Admin & Author)
- CRUD Post dengan upload gambar
- Kategori & Filter
- Search Artikel
- Komentar & Like (AJAX)
- Bookmark Artikel
- Follow Author
- Trending Posts & Reading Time
- Share ke Sosial Media
- WYSIWYG Editor (Summernote)
- Filament Admin Panel
- Responsive dengan Tailwind CSS
- Breeze Authentication

## Teknologi

- Laravel 13
- Laravel Breeze
- Filament 4
- Tailwind CSS
- Summernote
- MySQL

## Cara Install

1. `composer install`
2. Copy `.env.example` ke `.env`
3. Buat database `blogku_db`
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `php artisan storage:link`
7. `npm install && npm run build`
8. `php artisan serve`

## Akun Demo

- Admin: admin@mail.com / password
- Author: author@mail.com / password
