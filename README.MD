Laravel-helper
==============

Laravel-helper Component is a simple package that has been designed to help you generate code specification and robust architecture.

[![Latest Stable Version](http://img.shields.io/packagist/v/alicfeng/laravel-helper.svg)](https://packagist.org/packages/alicfeng/laravel-helper) [![Total Downloads](https://poser.pugx.org/alicfeng/laravel-helper/d/total.svg)](https://packagist.org/packages/alicfeng/laravel-helper) [![Build Status](http://img.shields.io/travis/alicfeng/laravel-helper.svg)](https://travis-ci.org/alicfeng/laravel-helper) 

#### What function does it have?

- Generate Unified Structure Package Following RESTful
- Response Package Encrypt By Middleware



#### Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "alicfeng/laravel-helper": "^1.1.0"
    }
}
```

And then run `composer install` from the terminal.



#### Quick Installation

Above installation can also be simplify by using the following command:

```shell
composer require  "alicfeng/laravel-helper=^1.1.0" -vvv
```



#### Configuration

- Configure ServiceProvider

  ```php
  'providers' => [
     AlicFeng\Helper\ServiceProvider\HelperServiceProvider::class,
  ]
  ```

- Execute command on terminal

  ```php
  php artisan vendor:publish --provider="AlicFeng\Helper\ServiceProvider\HelperServiceProvider"
  ```

  

#### Usage

###### ResponseHelper

- Generate Unified Structure Package Following RESTful

  > For example about `Controller - Service`
  >
  > using `return $this->result($codeEnum, $result);` 

  Developers only care about the results of service processing, while the response structure is built by components.

  ```php
  ## HelloController
  class HelloController extends Controller
  {
      private $helloService;
      public function __construct(HelloService $helloService)
      {
          $this->helloService = $helloService;
      }
      public function package()
      {
        	$name = request('name','');
          return $this->helloService->package($name);
      }
  }
  
  ## BaseHelloService
  class BaseHelloService {
      /**
       * @var ResponseHelper
       */
      protected $rspHelper;
  
      public function __construct()
      {
          $this->rspHelper = app(ResponseHelper::class);
      }
  }
  
  ## HelloService 
  class HelloService extends BaseHelloService {
      public function __construct()
    {
          parent::__construct();
    }
      public function package(string $name = '')
      {
          $codeEnum = [1000, 'success']; // this should define in app/Enum/CodeEnum.php
          $result   = [
              'name'   => $name,
              'age'    => 24,
          ];
          return $this->rspHelper->result($codeEnum, $result);
      }
  }
  ```
  
  Request Result
  
  ```shell
  ➜ curl -s "https://dev.samego.com/api/package?name=alicfeng" | jq .
  {
    "code": 1000,
    "message": "success",
    "data": {
      "name": "alicfeng",
      "age": 24
    }
  }
  ```



- Response Package Encrypt By Middleware

  > First register middle in Kernel 
  >
  > Then add middleware in route file or __construct

  `app/Http/Kernel.php`

  ```php
  protected $routeMiddleware = [
    'package.encrypt'=>\AlicFeng\Helper\Middleware\EncryptMiddleware::class
  ];
  ```

  `routes/api.php`

  ```php
  Route::middleware('package.encrypt')->get('/package', 'HelloController@package');
  ```

  Request Result

  ```shell
  ➜  demo curl -s "http://127.0.0.1:8181/api/package?name=alicfeng"       
  1aGGUAPDs0x80Qqnacwv1LQOd5crQrJZRJ6-7AbmrYb2EqvhUZ4flXBe6DKbKGGYbboU--qwz64epLapZc9nxSCsn4XIW-QG8taK-g_bteE
  ```

  Component provides the function of decrypting ciphertext through Web !!! see~

  now open you browser input `{$host/helper/decrypt}` then enter.

  ![decrypt-web](https://raw.githubusercontent.com/alicfeng/laravel-helper/master/doc/web@2x.png)

  

  > You can specify instances of encryption and decryption by configuring them，
  >
  > `config/helper.php` in `package.crypt.instance`
  >
  > have to implements `HelperCryptServiceInterface`
  
   
  
