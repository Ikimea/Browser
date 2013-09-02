Ikimea/Browser
===================

Detecting the user’s browser type and version is helpful in web applications that harness some of the newer bleeding edge concepts.



Requirements
------------

Brower works with PHP 5.3.3 or later.


Installation
------------

### 1. Add the bundle to your composer.json

```
"require": {
    ...
    "ikimea/browser": "dev-master"
}
```

### 2. Install the bundle using composer

```bash
$ php composer.phar update ikimea/browser
```

Usage
-----

```php
<?php

use Ikimea\Browser\Browser;

$browser = new Browser();
if( $browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= 2 ) {
   	echo 'You have FireFox version 2 or greater';
}

```
