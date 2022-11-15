# Supafunc

PHP client for [Supabase](https://supabase.io) Functions.(WIP) untested,do not use for now. Will edit and finalize very soon.


## Installation

Available via [Composer](https://getcomposer.org)


To install, add the following line to your `composer.json` file:

Add the follow line to your `composer.json` file:

```json
"supabase/functions" : "^0.0.1"
```

or run

```sh
composer require supabase/functions
```

Here's how you would initialize a client:

```php
<?php

require "vendor/autoload.php";

$client = FunctionsClient(
    "YOUR_API_KEY", 
    "https://asdfggggg.supabase.co/"
);
```



