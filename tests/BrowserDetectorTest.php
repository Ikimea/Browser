<?php

namespace Ikimea\Browser\Tests;

use Ikimea\Browser\Browser;
use Ikimea\Browser\BrowserType;
use Ikimea\Browser\PlatformType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class BrowserDetectorTest extends TestCase
{
    #[DataProvider('browserProvider')]
    public function testDetectBrowser(string $userAgent, BrowserType $expectedBrowser, string $expectedVersionPrefix): void
    {
        $browser = new Browser($userAgent);

        $this->assertSame($expectedBrowser, $browser->getBrowser(), "Browser detection failed for: {$userAgent}");
        if ($expectedVersionPrefix !== '') {
            $this->assertStringStartsWith($expectedVersionPrefix, $browser->getVersion(), "Version detection failed for: {$userAgent}");
        }
    }

    public static function browserProvider(): iterable
    {
        yield 'Chrome' => [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.6099.130 Safari/537.36',
            BrowserType::Chrome,
            '120.',
        ];

        yield 'Firefox' => [
            'Mozilla/5.0 (X11; Linux x86_64; rv:120.0) Gecko/20100101 Firefox/120.0',
            BrowserType::Firefox,
            '120.',
        ];

        yield 'Safari' => [
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Safari/605.1.15',
            BrowserType::Safari,
            '17.',
        ];

        yield 'Edge (Chromium)' => [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.2210.91',
            BrowserType::Edge,
            '120.',
        ];

        yield 'Opera Chromium' => [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 OPR/106.0.0.0',
            BrowserType::OperaChromium,
            '106.',
        ];

        yield 'Yandex' => [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 YaBrowser/24.1.0.0 Safari/537.36',
            BrowserType::Yandex,
            '24.',
        ];

        yield 'IE 11' => [
            'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
            BrowserType::IE,
            '11.',
        ];

        yield 'GoogleBot' => [
            'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
            BrowserType::GoogleBot,
            '2.1',
        ];

        yield 'MSN Bot' => [
            'msnbot/2.0b (+http://search.msn.com/msnbot.htm)',
            BrowserType::MSNBot,
            '2.',
        ];

        yield 'iPhone Safari' => [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            BrowserType::iPhone,
            '17.',
        ];

        yield 'iPad Safari' => [
            'Mozilla/5.0 (iPad; CPU OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            BrowserType::iPad,
            '17.',
        ];

        yield 'iPhone Chrome (CriOS)' => [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/120.0.6099.119 Mobile/15E148 Safari/604.1',
            BrowserType::iPhone,
            '120.',
        ];

        yield 'iPhone Firefox (FxiOS)' => [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/120.0 Mobile/15E148 Safari/604.1',
            BrowserType::iPhone,
            '120.',
        ];

        yield 'Facebook in-app' => [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 [FBAN/FBIOS;FBAV/438.0.0.0;FBBV/1;FBDV/iPhone15,2;FBMD/iPhone;FBSN/iOS;FBSV/17.0;FBSS/3;FBID/phone;FBLC/en_US;FBOP/5]',
            BrowserType::Facebook,
            '438.',
        ];

        yield 'Android browser' => [
            'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
            BrowserType::Chrome,
            '120.',
        ];

        yield 'Unknown' => [
            'SomeCompletelyUnknownAgent/1.0',
            BrowserType::Unknown,
            '',
        ];

        yield 'Empty UA' => [
            '',
            BrowserType::Unknown,
            '',
        ];

        yield 'Opera classic' => [
            'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.18',
            BrowserType::Opera,
            '12.',
        ];

        yield 'Opera Mini' => [
            'Opera/9.80 (J2ME/MIDP; Opera Mini/5.0/28.3590; U; en) Presto/2.8.119 Version/11.10',
            BrowserType::OperaMini,
            '5.',
        ];

        yield 'Edge legacy' => [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/18.17763',
            BrowserType::Edge,
            '18.',
        ];

        yield 'iPod Safari' => [
            'Mozilla/5.0 (iPod; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            BrowserType::iPod,
            '14.',
        ];

        yield 'BlackBerry' => [
            'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 Mobile Safari/534.11+',
            BrowserType::BlackBerry,
            '',
        ];

        yield 'Yahoo Slurp' => [
            'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)',
            BrowserType::Slurp,
            '',
        ];

        yield 'Lynx' => [
            'Lynx/2.8.9rel.1 libwww-FM/2.14 SSL-MM/1.4.1 GNUTLS/3.6.5',
            BrowserType::Lynx,
            '2.',
        ];

        yield 'Facebook FBAN only' => [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 [FBAN/FBIOS]',
            BrowserType::Facebook,
            '',
        ];

        yield 'Truncated UA' => [
            'Mozilla/5.0',
            BrowserType::Mozilla,
            '',
        ];

        yield 'Brave' => [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Brave/120.0.0.0',
            BrowserType::Brave,
            '120.',
        ];

        yield 'Vivaldi' => [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Vivaldi/6.5.3206.63',
            BrowserType::Vivaldi,
            '6.',
        ];

        yield 'Samsung Internet' => [
            'Mozilla/5.0 (Linux; Android 13; SM-G991B) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/23.0 Chrome/115.0.0.0 Mobile Safari/537.36',
            BrowserType::SamsungInternet,
            '23.',
        ];

        yield 'DuckDuckGo' => [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) DuckDuckGo/7 Safari/605.1.15',
            BrowserType::DuckDuckGo,
            '7',
        ];

        yield 'UC Browser' => [
            'Mozilla/5.0 (Linux; U; Android 13; en-US; Pixel 7 Build/TP1A) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.0.0 UCBrowser/16.0.2.4 Mobile Safari/537.36',
            BrowserType::UCBrowser,
            '16.',
        ];

        yield 'Mi Browser' => [
            'Mozilla/5.0 (Linux; U; Android 12; en-US; M2101K6G Build/SKQ1.211006.001) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.0.0 MiuiBrowser/17.0.2 Mobile Safari/537.36',
            BrowserType::MiBrowser,
            '17.',
        ];

        yield 'BingBot' => [
            'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)',
            BrowserType::BingBot,
            '2.0',
        ];

        yield 'YandexBot' => [
            'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)',
            BrowserType::YandexBot,
            '3.0',
        ];

        yield 'Applebot' => [
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)',
            BrowserType::Applebot,
            '0.1',
        ];

        yield 'DuckDuckBot' => [
            'DuckDuckBot/1.1; (+http://duckduckgo.com/duckduckbot.html)',
            BrowserType::DuckDuckBot,
            '1.1',
        ];

        yield 'FacebookBot (facebookexternalhit)' => [
            'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)',
            BrowserType::FacebookBot,
            '1.1',
        ];

        yield 'TwitterBot' => [
            'Twitterbot/1.0',
            BrowserType::TwitterBot,
            '1.',
        ];

        yield 'LinkedInBot' => [
            'LinkedInBot/1.0 (compatible; Mozilla/5.0; Apache-HttpClient +http://www.linkedin.com)',
            BrowserType::LinkedInBot,
            '1.',
        ];

        yield 'WhatsApp' => [
            'WhatsApp/2.23.20.0 A',
            BrowserType::WhatsApp,
            '2.',
        ];

        yield 'TelegramBot' => [
            'TelegramBot (like TwitterBot)',
            BrowserType::Telegram,
            '',
        ];

        yield 'DiscordBot' => [
            'Mozilla/5.0 (compatible; Discordbot/2.0; +https://discordapp.com)',
            BrowserType::Discord,
            '2.',
        ];
    }

    public function testIsRobot(): void
    {
        $bot = new Browser('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        $this->assertTrue($bot->isRobot());

        $chrome = new Browser('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36');
        $this->assertFalse($chrome->isRobot());
    }

    public function testIsMobile(): void
    {
        $iphone = new Browser('Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Version/17.0 Mobile/15E148 Safari/604.1');
        $this->assertTrue($iphone->isMobile());

        $desktop = new Browser('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36');
        $this->assertFalse($desktop->isMobile());
    }

    public function testMajorVersion(): void
    {
        $browser = new Browser('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.6099.130 Safari/537.36');
        $this->assertSame(120, $browser->getMajorVersion());
    }

    public function testIsBrowser(): void
    {
        $browser = new Browser('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36');
        $this->assertTrue($browser->isBrowser(BrowserType::Chrome));
        $this->assertFalse($browser->isBrowser(BrowserType::Firefox));
    }

    public function testGetUserAgent(): void
    {
        $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36';
        $browser = new Browser($ua);
        $this->assertSame($ua, $browser->getUserAgent());
    }

    public function testGetPlatform(): void
    {
        $browser = new Browser('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Version/17.0 Safari/605.1.15');
        $this->assertSame(PlatformType::Mac, $browser->getPlatform());
    }
}
