Detecting the user’s browser type and version is helpful in web applications that harness some of the newer bleeding edge concepts.


Typical Usage:

```php
<?php

use Ikimea\Browser

  $browser = new Browser();
  if( $browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= 2 ) {
   	echo 'You have FireFox version 2 or greater';
 }

```