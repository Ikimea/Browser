<?php

namespace Ikimea\Browser\Tests;

use Ikimea\Browser\PlatformDetector;
use Ikimea\Browser\PlatformType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PlatformDetectorTest extends TestCase
{
    private PlatformDetector $detector;

    protected function setUp(): void
    {
        $this->detector = new PlatformDetector();
    }

    #[DataProvider('platformProvider')]
    public function testDetectPlatform(string $userAgent, PlatformType $expected, bool $isMobile): void
    {
        $result = $this->detector->detect($userAgent);

        $this->assertSame($expected, $result->platform);
        $this->assertSame($isMobile, $result->isMobile);
    }

    public static function platformProvider(): iterable
    {
        yield 'Windows 10 - Chrome' => [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            PlatformType::Windows,
            false,
        ];

        yield 'macOS - Safari' => [
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Safari/605.1.15',
            PlatformType::Mac,
            false,
        ];

        yield 'Linux - Firefox' => [
            'Mozilla/5.0 (X11; Linux x86_64; rv:120.0) Gecko/20100101 Firefox/120.0',
            PlatformType::Linux,
            false,
        ];

        yield 'Ubuntu' => [
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:120.0) Gecko/20100101 Firefox/120.0',
            PlatformType::Ubuntu,
            false,
        ];

        yield 'iPhone' => [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            PlatformType::iPhone,
            true,
        ];

        yield 'iPad' => [
            'Mozilla/5.0 (iPad; CPU OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            PlatformType::iPad,
            true,
        ];

        yield 'iPod' => [
            'Mozilla/5.0 (iPod; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            PlatformType::iPod,
            true,
        ];

        yield 'Android' => [
            'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
            PlatformType::Android,
            true,
        ];

        yield 'Windows Phone' => [
            'Mozilla/5.0 (Windows Phone 10.0; Android 6.0.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Mobile Safari/537.36 Edge/15.15254',
            PlatformType::WindowsPhone,
            true,
        ];

        yield 'BlackBerry' => [
            'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 Mobile Safari/534.11+',
            PlatformType::BlackBerry,
            true,
        ];

        yield 'FreeBSD' => [
            'Mozilla/5.0 (X11; FreeBSD amd64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            PlatformType::FreeBSD,
            false,
        ];

        yield 'Unknown' => [
            'SomeRandomBot/1.0',
            PlatformType::Unknown,
            false,
        ];
    }
}
