# Demo FullStack Project for Teamway.io

The request was to build a simple personality test application, that takes 3-5 different questions, maps them into a score and produces a personality trait of either Introvert or Extrovert. The stack used for its implementation is Laravel and Vue.js

### Requirements

- PHP >= 7.4
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension for Sqlite
- Tokenizer PHP Extension
- XML PHP Extension


### Installation Guide

Run: 

```
cp .env.example .env
php artisan key:generate
touch storage/app/database.sqlite
php artisan migrate --seed
php artisan serve
```

