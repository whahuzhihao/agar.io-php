# Agar.io-php
Transplanted from (agar-io clone)[https://github.com/huytd/agar.io-clone].  
Backend rewrite with PHP swoole extension 

# NOT FINISHED YET
* TODO Still have problem with QuadTree. Use simple collision detection instead.

## Requirements
* PHP version > 5.3.10
* Swoole extension for PHP

## Installation
1. Install swoole extension via pecl 

	```bash
	pecl install swoole
	```
2. Download php libs via composer

	```bash
	composer install -o
	```

3. Download nodejs libs via npm
	```bash
	npm install
	```

## Run
Run with `npm start`, and visit http://localhost:3000 in your browser.