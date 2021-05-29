
# PHP ReST API using Lumen Framework (with lumen-passport OAuth2), built with Controller - Service - Repository Layer

[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

This is a simple example to show a Lumen App (API) which works with Laravel Passport (OAuth 2.0).

## Installation
Clone this repository. Run the following commands:

```sh  
$ cd lumen-passport-api
$ cp .env.example .env
$ php artisan key:generate
$ docker-compose -f ./mysql-docker-compose.yaml up -d
```  
  
Create your database and enter the details in your `.env` file. Now run the following commands:  
  
```sh  
$ php artisan migrate
$ php artisan migrate --seed
$ php artisan passport:install
```  
You will get this set of messages:  
```sh  
Encryption keys generated successfully.
Personal access client created successfully.
Client ID: 1
Client secret: sTS2574wBOx6lkWfvfpT3qNQuh1nrln4BmD78Ofu
Password grant client created successfully.
Client ID: 2
Client secret: eKpfVNe8Y3bkuqigQuKHq8sYgeXI3kPLROD690fH
```  
  
You should see two client ID and secret pairs.  
The first one is Personal Access Client and second one is Password Grant Client.  
The Password Grant Client will allow us to generate new tokens for users.  
  
### Testing the API  
  
We have already added two users in UserSeeder.php.  
Their credentials are:

```ini
name : <random_name>  
email : test1@bssd.vn  
password : password

name : <random_name>  
email : test2@bssd.vn  
password : password
```

**Obtain access token:**  
  
```sh  
curl --location --request POST 'http://127.0.0.1:8080/oauth/token' \--form 'client_id="2"' \  
    --form 'client_secret="96qaUVmKljukaF2Cacrr5i4y8UIf6T7zcM18HcDJ"' \  
    --form 'grant_type="password"' \  
    --form 'username="test2@bssd.vn"' \  
    --form 'password="password"'  
```  
OR
```sh  
curl --location --request POST 'http://127.0.0.1:8080/oauth/token' \--header 'Content-Type: application/json' \  
    --data-raw '{
    "client_id": 2, 
    "client_secret": "96qaUVmKljukaF2Cacrr5i4y8UIf6T7zcM18HcDJ", 
    "grant_type": "password",
    "username": "test1@bssd.vn",
    "password": "password"
    }'  
```  

Thus, we will get a response which has access token,

```json  
 { 
    "token_type": "Bearer", 
    "expires_in": 31536000, 
    "access_token": "VeryVeryVeryLongAccessToken", 
    "refresh_token": "YourRefreshToken"
 }  
```  

## Development
How to start developing?
### Repository

*Generate Eloquent model before generate repository is recommended. Be aware that only interact with DB should be here*

***Generate***
- Generate repository
``` sh
php artisan make:repository UserRepository
```
- Generate repository with a existed model
``` sh
php artisan make:repository UserRepository --model User
```
***Available methods*** can be found [here](https://github.com/orkhanahmadov/eloquent-repository/blob/master/README.md#available-methods)
### Services

*Handler business logic*
- Create new service by add a new **interface** in folder **app\Service\Contracts**
```php
<?php

namespace App\Services\Contracts;

use App\Models\Stock;

interface StockService
{
    public function all();

    public function create(Stock $stock);
}

```
- Create the implementation by add a new php class in folder **app\Service\Impls**
```php
<?php

namespace App\Services\Impls;

use App\Models\Stock;
use App\Repositories\StockRepository;
use App\Repositories\ProductRepository;
use App\Services\Contracts\StockService;

class StockServiceImpl implements StockService
{

    private StockRepository $stockRepo;
    
    private ProductRepository $productRepo;

    /**
     * StockServiceImpl constructor.
     *
     * @param  StockRepository  $stockRepo
     * 
     * @param  ProductRepository  $productRepo
     */

    public function __construct(StockRepository $stockRepo, ProductRepository  $productRepo)
    {
        $this->stockRepo = $stockRepo;
        $this->productRepo = $productRepo;
    }

    public function all()
    {
        return $this->stockRepo->all();
    }


    public function create(Stock $stock)
    {
        return $this->stockRepo->create($stock->toArray());
    }
}
```
- Register bindings in **App\Providers\AppServiceProvider**
```php
    public function register()
    {
        $this->app->singleton(StockService::class, StockServiceImpl::class);
        $this->app->singleton(UserService::class, UserServiceImpl::class);
        $this->app->singleton(ProductService::class, ProductServiceImpl::class);
        ...
    }
```

### Controller

*Only dispatch to business logic handling (service layer).* ***Shouldn't call or use any repositories here***

- Declare controller and usage services
```php
<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\Contracts\StockService;
use Illuminate\Http\Request;

class StockController extends BaseController
{
    private StockService $stockSv;

    /**
     * StockController constructor.
     *
     * @param  StockService  $stockSv
     */
    public function __construct(StockService $stockSv)
    {
        $this->stockSv = $stockSv;
    }

    public function fetchAll()
    {
        return $this->stockSv->all();
    }

    public function create(Request $request)
    {
        return $this->stockSv->create($this->jsonToObject($request, Stock::class));
    }
}

```
## License

MIT License.
