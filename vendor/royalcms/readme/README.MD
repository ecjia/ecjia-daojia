## Royalcms Packages's Readme File(Docs) Viewer

This package generates a html page that you can see all of your packages's readme file, So you no longer need to go to each package's homepage to find documents。

### Install

Require this package with composer using the following command:

```bash
composer require royalcms/readme
```

After updating composer, add the service provider to the `providers` array in `config/provider.php`

```php
Royalcms\Component\Readme\ReadmeServiceProvider::class,
```

To install this package on only development systems, add the `--dev` flag to your composer command:

```bash
composer require --dev royalcms/readme
```

In Royalcms, instead of adding the service provider in the `config/system.php` file, you can add the following code to your `app/Providers/AppServiceProvider.php` file, within the `register()` method:

```php
public function register()
{
    if ($this->royalcms->environment() == 'local') {
        $this->royalcms->register('Royalcms\Component\Readme\ReadmeServiceProvider');
    }
    // ...
}
```

This will allow your application to load the Royalcms Packages's Readme File(Docs) Viewer on non-production enviroments.

### Usage

You can now view all the docs of your packages in your browser by follow url.

```bash
http://yoursite.app/readme
```

### Custom Route

If you need to custom route, you need to publish config file first

```bash
php artisan vendor:publish --tag=readme
```

Then you can change route in '/config/readme.php'

```php
'route' => [
        'prefix' => '/readme/{packageName?}',
        'action' => 'Royalcms\Component\Readme\Controllers\ReadmeController@index',
        'name' => 'readme.index',
],
```


### License

The Royalcms Packages's Readme File(Docs) Viewer is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
