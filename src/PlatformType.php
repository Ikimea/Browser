<?php

namespace Ikimea\Browser;

enum PlatformType: string
{
    case Unknown = 'unknown';
    case Windows = 'Windows';
    case WindowsCE = 'Windows CE';
    case WindowsPhone = 'Windows Phone';
    case Mac = 'mac';
    case Linux = 'Linux';
    case Ubuntu = 'Ubuntu';
    case iPhone = 'iPhone';
    case iPod = 'iPod';
    case iPad = 'iPad';
    case Android = 'Android';
    case BlackBerry = 'BlackBerry';
    case Nokia = 'Nokia';
    case FreeBSD = 'FreeBSD';
    case OpenBSD = 'OpenBSD';
    case NetBSD = 'NetBSD';
    case SunOS = 'SunOS';
    case OpenSolaris = 'OpenSolaris';
}
