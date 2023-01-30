# InfinityBank <img src="https://user-images.githubusercontent.com/110776571/214702642-d7d840d3-8909-4b6a-9301-595bf31e406d.png" width="38" height="27"/>

### InfinityBank is an iBank project that combines the power of the PHP Laravel framework, API calls, and user data management in MySQL.

<p align="justify">InfinityBank clients can open multiple accounts per profile with support for 20 different currencies. Expierience features such as money transfer between accounts, secure payments with two-step verification, full transaction overview with result filtering, and payment history monitoring within current month. Additionally, InfinityBank offers trading in cryptocurrencies and the ability to track the performance of each account's portfolio, including profit and loss.</p>

- [GIF vizualizations](#overview)
- [Full feature list](#features)
- [Technologies used](#technologies-used)
- [Run project](#run-project)
  * [Database Setup](#database-setup)
  * [API Key Setup](#api-key-setup)

## GIF vizualizations

![Recording 2023-01-27 at 02 17 46](https://user-images.githubusercontent.com/110776571/214979218-3efd06dc-9c4b-4028-99e9-3c96fe4bfa9a.gif)

#### Dashboard, single account overview
![InfinityBank-dashboard](https://user-images.githubusercontent.com/110776571/214977870-a8751b68-6126-4096-a6bb-9feb8be448a4.gif)

#### New payment
![InfinityBank-NewPayment](https://user-images.githubusercontent.com/110776571/214978333-4892a36b-1a40-41c1-89c2-b79d83b7aefb.gif)

#### Transaction filtering
![InfinityBank-transactions](https://user-images.githubusercontent.com/110776571/214977253-ba0437da-8037-446c-b78e-5b8d69f9af0d.gif)

#### Crypto trading
![InfinityBank-crypto](https://user-images.githubusercontent.com/110776571/214978523-a6ed2b8a-e8ec-491f-a4a3-7fe20faf8f78.gif)

## Features
- Multiple accounts per profile
- Currency exchange
- Money transfers between accounts
- Two-step verification
- Account label editing
- Monthly payment activity tracking for each account
- Separate bank and crypto transactios with result filtering
- Crypto trading section with search option
- Buy/Sell crypto from any account
- Crypto portfolio connected to bank account
- Profit/Loss tracking
- Closing account

## Technologies used

- [PHP 7.4.33](https://www.php.net/)
- [MySQL 8.0.30](https://dev.mysql.com/)
- [Composer 2.4.4](https://getcomposer.org/)
- [Laravel 8.75](https://laravel.com/)
- [Node.js and npm 8.19.3](https://nodejs.org/en/)

## Run project

- Clone project `git clone https://github.com/LigaLiepkalne/InfinityBank.git`

- Install project dependencies
    - Run `composer install` to install PHP dependencies.
    - Run `npm install` to install JavaScript dependencies.
    - Run `npm run dev` to build the front-end assets.

   #### Database Setup
    - Connection configuration: copy **env.example** file, remove *example* from file name and set DB_DATABASE, DB_USERNAME, and DB_PASSWORD variables to the appropriate values.
    - Run `php artisan migrate` to create the necessary tables.

   #### API Key Setup
  - Cryptocurrency data: [CoinMarketCap](https://coinmarketcap.com/api/). Obtain API key and store in **env** file under constant COIN_MARKET_CAP_API_KEY. 
  - Currency exchange data: [Currencyapi](https://currencyapi.com/). Obtain API key and store in **env** file under constant CURRENCY_EXCHANGE_RATE_API_KEY. 

- Run `php artisan serve` to start the development server.
