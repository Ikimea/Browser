<?php

namespace Ikimea\Browser;

enum BrowserType: string
{
    case Unknown = 'unknown';
    case Chrome = 'Chrome';
    case Firefox = 'Firefox';
    case Safari = 'Safari';
    case Edge = 'Edge';
    case Opera = 'Opera';
    case OperaMini = 'Opera Mini';
    case OperaChromium = 'Opera Chromium';
    case Yandex = 'Yandex Browser';
    case IE = 'Internet Explorer';
    case PocketIE = 'Pocket Internet Explorer';
    case Konqueror = 'Konqueror';
    case ICab = 'iCab';
    case OmniWeb = 'OmniWeb';
    case Iceweasel = 'Iceweasel';
    case Shiretoko = 'Shiretoko';
    case Mozilla = 'Mozilla';
    case Amaya = 'Amaya';
    case Lynx = 'Lynx';
    case iPhone = 'iPhone';
    case iPod = 'iPod';
    case iPad = 'iPad';
    case Android = 'Android';
    case GoogleBot = 'GoogleBot';
    case MSNBot = 'MSN Bot';
    case Slurp = 'Yahoo! Slurp';
    case W3CValidator = 'W3C Validator';
    case BlackBerry = 'BlackBerry';
    case IceCat = 'IceCat';
    case NokiaS60 = 'Nokia S60 OSS Browser';
    case Nokia = 'Nokia Browser';
    case MSN = 'MSN Browser';
    case NetscapeNavigator = 'Netscape Navigator';
    case Facebook = 'Facebook';
    case Brave = 'Brave';
    case Vivaldi = 'Vivaldi';
    case SamsungInternet = 'Samsung Internet';
    case DuckDuckGo = 'DuckDuckGo';
    case UCBrowser = 'UC Browser';
    case MiBrowser = 'Mi Browser';
}
