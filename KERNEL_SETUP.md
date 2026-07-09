# Pendaftaran Middleware `role`

## Laravel 10 (app/Http/Kernel.php)

Buka `app/Http/Kernel.php`, tambahkan baris berikut ke dalam
properti `$middlewareAliases`:

```php
protected $middlewareAliases = [
    // ...alias bawaan lainnya...
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

## Laravel 11 (bootstrap/app.php)

Jika Anda menggunakan skeleton Laravel 11 (tanpa file Kernel.php), buka
`bootstrap/app.php` dan tambahkan di dalam method `withMiddleware`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

Setelah itu, seluruh route yang memakai `->middleware('role:admin,petugas')`
pada `routes/web.php` akan berfungsi sesuai rancangan hak akses per role.
