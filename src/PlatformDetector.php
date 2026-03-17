<?php

namespace Ikimea\Browser;

final class PlatformDetector
{
    public function detect(string $userAgent): PlatformResult
    {
        $ua = strtolower($userAgent);

        [$platform, $mobile] = match (true) {
            str_contains($ua, 'ipad') => [PlatformType::iPad, true],
            str_contains($ua, 'ipod') => [PlatformType::iPod, true],
            str_contains($ua, 'iphone') => [PlatformType::iPhone, true],
            str_contains($ua, 'windows phone') => [PlatformType::WindowsPhone, true],
            str_contains($ua, 'android') => [PlatformType::Android, true],
            str_contains($ua, 'blackberry') => [PlatformType::BlackBerry, true],
            str_contains($ua, 'nokia') => [PlatformType::Nokia, true],
            str_contains($ua, 'mac') => [PlatformType::Mac, false],
            str_contains($ua, 'cros') => [PlatformType::ChromeOS, false],
            str_contains($ua, 'ubuntu') => [PlatformType::Ubuntu, false],
            str_contains($ua, 'linux') => [PlatformType::Linux, false],
            str_contains($ua, 'windows') => [PlatformType::Windows, false],
            str_contains($ua, 'freebsd') => [PlatformType::FreeBSD, false],
            str_contains($ua, 'openbsd') => [PlatformType::OpenBSD, false],
            str_contains($ua, 'netbsd') => [PlatformType::NetBSD, false],
            str_contains($ua, 'opensolaris') => [PlatformType::OpenSolaris, false],
            str_contains($ua, 'sunos') => [PlatformType::SunOS, false],
            default => [PlatformType::Unknown, false],
        };

        return new PlatformResult($platform, $mobile);
    }
}
