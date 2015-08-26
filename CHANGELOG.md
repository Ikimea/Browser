CHANGELOG for 1.x
===================

 * 1.12.0  (2015-08-26)
 
    * Added Microsoft Edge support
    * PHP 5.3 Support

 * 1.11.0 (2014-09-14)
 
    * Fix for IE11 detection

 * 1.10.0 (2013-08-18)
 
     * Fixing Opera Browser version (Thanks PWalkow)
     * Change LICENSE GPL to MIT
     
 * 1.9.0 (2010-08-20
 
     *  Added MSN Explorer Browser (legacy)
     *  Added Bing/MSN Robot (Thanks Rob MacDonald)
     *  Added the Android Platform (PLATFORM_ANDROID)
     *  Fixed issue with Android 1.6/2.2 (Thanks Tom Hirashima)
 
 * v1.8.0 (2010-04-27)
 
    *  Added iPad Support

 * 1.7.0 (2010-03-07) 
     *  *MAJOR* Rebuild (preg_match and other "slow" routine removal(s))
     *  Almost allof Gary's original code has been replaced
     *  Large PHPUNIT testing environment created to validate new releases and additions
     *  Added FreeBSD Platform
     *  Added OpenBSD Platform
     *  Added NetBSD Platform
     *  Added SunOS Platform
     *  Added OpenSolaris Platform
     *  Added support of the Iceweazel Browser
     *  Added isChromeFrame() call to check if chromeframe is in use
     *  Moved the Opera check in front of the Firefox check due to legacy Opera User Agents
     *  Added the __toString() method (Thanks Deano)
     *  Updated the checkes for Firefox
     *  Added the NOKIA platform
     *  Added Checks for the NOKIA brower(s)
     *  PHP 5.3 Support
     *  Added support for BlackBerry OS and BlackBerry browser
     *  Added support for the Opera Mini browser
     *  Added additional documenation
     *  Added support for isRobot() and isMobile()
     *  Added support for Opera version 10
     *  Added support for deprecated Netscape Navigator version 9
     *  Added support for IceCat
     *  Added support for Shiretoko
     
 * 1.8.0 (2010-04-27)
 
     *  Added iPad Support
     *	Updated to support PHP 5.3 - removed all deprecated function calls
     *  Updated to remove all double quotes (") -- converted to single quotes (')
     *  Updated the IE check to remove a typo and bug (thanks John)
     *  Added detection for GoogleBot
     *  Added detection for the W3C Validator.
     *  Added detection for Yahoo! Slurp
     *  Added detection for iPods.
     *  Added Platform detection for iPhones
     *  Added Platform detection for iPods
     *  Added version detection for Android phones. (Rick Hale)
     *  Added Google's Chrome to the detection list
     *  Added isBrowser(string) to the list of functions special thanks to Daniel 'mavrick' Lang for the function concept (http://mavrick.id.au)
     *  Added class constants
     *  Added detection and version detection for Google's Chrome
     *  Updated the version detection for Amaya
     *  Updated the version detection for Firefox
     *  Updated the version detection for Lynx
     *  Updated the version detection for WebTV
     *  Updated the version detection for NetPositive
     *  Updated the version detection for IE
     *  Updated the version detection for OmniWeb
     *  Updated the version detection for iCab
     *  Updated the version detection for Safari
     *  Updated Safari to remove mobile devices (iPhone)
     *  Added detection for iPhone
     *  Added detection for robots
     *  Added detection for mobile devices
     *  Added detection for BlackBerry
     *  Removed Netscape checks (matches heavily with firefox & mozilla)