## Why Laravel-Security

Laravel-Security helps you secure your Laravel apps by setting various HTTP headers. it can help!

## Quick start

First, You can install the package via composer: 
 <pre> composer require royalcms/laravel-security </pre> 

## Documentation

For installation instructions, in-depth usage and deployment details, please take a look at the official [documentation](https://getspooky.github.io/Laravel-Mitnick/).

## Requirements

Laravel-Security  has a few requirements you should be aware of before installing :

* Composer
* Laravel Framework 5.4+

## Solved : Security vulnerability

| Vulnerability | Middleware Class  |   Included
| ------- | --- | --- |
| Cache Control Attack | Royalcms\Laravel\Security\Cache::class |  ✔
| Cross-Origin Resource Sharing (CORS) |  Royalcms\Laravel\Security\CORS::class |✔
| X-Permitted-Cross-Domain-Policies | Royalcms\Laravel\Security\CrossDomain::class | ✔
| DNS Prefetch Control | Royalcms\Laravel\Security\DNS::class |✔
| Click Jacking Attack | Royalcms\Laravel\Security\FrameGuard::class |✔
| Strict-Transport-Security | Royalcms\Laravel\Security\HSTS::class |✔
| Mime Sniffing Attack | Royalcms\Laravel\Security\NoSniff::class |✔
| X-Powered-By Attack  | Royalcms\Laravel\Security\XPoweredBy::class | ✔
| XSS Attack | Royalcms\Laravel\Security\XSS::class |✔
  
## License

The Laravel-Security package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
