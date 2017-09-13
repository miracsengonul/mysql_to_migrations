# #Laravel 5 Mysql to Migrations Paketi


Bu paket ile Mysql veritabanınızı migration dosyası haline getirebilirsiniz.


Kurulum için öncelikle paketi kurunuz.
```
composer require mirac/m2m dev-master
```

```config/app.php``` dosyasına aşağıda bulunan satırları ekleyelim.
```php
return array(
    // ...

    'providers' => array(
        // ...

        mirac\m2m\M2MServiceProvider::class,
    ),

    // ...

    'aliases' => array(
        // ...

        'm2m'=> mirac\m2m\Facades\M2M::class,
    ),
);
```

#Ayarlar

database/migrations klasörünün chmod(izin) ayarlarını 777 yaparak klasöre erişim izni veriniz.

#Kullanımı


routes/web.php içerisinde
```php
Route::get('export', function (){

    new mirac\m2m\M2M();

});
```

Controller dosyanızın içerisinde ise
```php

use mirac\m2m\M2M;

public function index(){

        new M2M();

     }

```

kullanabilirsiniz.
