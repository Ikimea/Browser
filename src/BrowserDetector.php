<?php

namespace Ikimea\Browser;

final class BrowserDetector
{
    public function detect(string $userAgent): BrowserMatch
    {
        return // bots first (their UA often contains browser tokens)
            $this->checkGoogleBot($userAgent)
            ?? $this->checkMSNBot($userAgent)
            ?? $this->checkBingBot($userAgent)
            ?? $this->checkYandexBot($userAgent)
            ?? $this->checkApplebot($userAgent)
            ?? $this->checkDuckDuckBot($userAgent)
            ?? $this->checkFacebookBot($userAgent)
            ?? $this->checkTelegram($userAgent)
            ?? $this->checkTwitterBot($userAgent)
            ?? $this->checkLinkedInBot($userAgent)
            ?? $this->checkWhatsApp($userAgent)
            ?? $this->checkDiscord($userAgent)
            ?? $this->checkSlurp($userAgent)
            // browsers
            ?? $this->checkYandex($userAgent)
            ?? $this->checkEdge($userAgent)
            ?? $this->checkIE($userAgent)
            ?? $this->checkOperaMini($userAgent)
            ?? $this->checkOpera($userAgent)
            ?? $this->checkOPR($userAgent)
            ?? $this->checkNetscapeNavigator($userAgent)
            ?? $this->checkFirefox($userAgent)
            ?? $this->checkBrave($userAgent)
            ?? $this->checkVivaldi($userAgent)
            ?? $this->checkSamsungInternet($userAgent)
            ?? $this->checkDuckDuckGo($userAgent)
            ?? $this->checkUCBrowser($userAgent)
            ?? $this->checkMiBrowser($userAgent)
            ?? $this->checkChrome($userAgent)
            ?? $this->checkOmniWeb($userAgent)
            ?? $this->checkFacebook($userAgent)
            ?? $this->checkAndroid($userAgent)
            ?? $this->checkiPad($userAgent)
            ?? $this->checkiPod($userAgent)
            ?? $this->checkiPhone($userAgent)
            ?? $this->checkBlackBerry($userAgent)
            ?? $this->checkNokia($userAgent)
            ?? $this->checkSafari($userAgent)
            ?? $this->checkKonqueror($userAgent)
            ?? $this->checkICab($userAgent)
            ?? $this->checkAmaya($userAgent)
            ?? $this->checkLynx($userAgent)
            ?? $this->checkShiretoko($userAgent)
            ?? $this->checkIceCat($userAgent)
            ?? $this->checkIceweasel($userAgent)
            ?? $this->checkW3CValidator($userAgent)
            ?? $this->checkMozilla($userAgent)
            ?? new BrowserMatch(BrowserType::Unknown, 'unknown');
    }

    private function versionAfter(string $ua, string $token): string
    {
        $fragment = stristr($ua, $token);
        if ($fragment === false) {
            return 'unknown';
        }
        $parts = explode('/', $fragment);

        return isset($parts[1]) ? explode(' ', $parts[1])[0] : 'unknown';
    }

    private function checkYandex(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'YaBrowser') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Yandex, $this->versionAfter($ua, 'YaBrowser'));
    }

    private function checkEdge(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Edg') === false) {
            return null;
        }
        $token = stripos($ua, 'Edge/') !== false ? 'Edge' : 'Edg';

        return new BrowserMatch(BrowserType::Edge, $this->versionAfter($ua, $token));
    }

    private function checkIE(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Trident/7.0') !== false && stripos($ua, 'rv:11.0') !== false) {
            return new BrowserMatch(BrowserType::IE, '11.0');
        }
        if (stripos($ua, 'msie') !== false && stripos($ua, 'opera') === false) {
            if (stripos($ua, 'msnb') !== false) {
                $parts = explode(' ', stristr(str_replace(';', '; ', $ua), 'MSN'));
                $version = str_replace(['(', ')', ';'], '', $parts[1]);

                return new BrowserMatch(BrowserType::MSN, $version);
            }
            $parts = explode(' ', stristr(str_replace(';', '; ', $ua), 'msie'));
            $version = str_replace(['(', ')', ';'], '', $parts[1]);

            return new BrowserMatch(BrowserType::IE, $version);
        }
        if (stripos($ua, 'mspie') !== false || stripos($ua, 'pocket') !== false) {
            if (stripos($ua, 'mspie') !== false) {
                $parts = explode(' ', stristr($ua, 'mspie'));
                $version = $parts[1] ?? 'unknown';
            } else {
                $parts = explode('/', $ua);
                $version = $parts[1] ?? 'unknown';
            }

            return new BrowserMatch(BrowserType::PocketIE, $version);
        }

        return null;
    }

    private function checkOperaMini(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'opera mini') === false) {
            return null;
        }
        $resultant = stristr($ua, 'opera mini');
        if ($resultant !== false && str_contains($resultant, '/')) {
            $parts = explode('/', $resultant);
            $version = explode(' ', $parts[1])[0];
        } else {
            $parts = explode(' ', $resultant ?: '');
            $version = $parts[2] ?? 'unknown';
        }

        return new BrowserMatch(BrowserType::OperaMini, $version);
    }

    private function checkOpera(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'opera') === false) {
            return null;
        }
        $resultant = stristr($ua, 'opera');
        if ($resultant !== false && preg_match('/Version\/([0-9]*\.[0-9]*)$/', $resultant, $matches)) {
            $version = $matches[1];
        } elseif ($resultant !== false && str_contains($resultant, '/')) {
            $parts = explode('/', str_replace('(', ' ', $resultant));
            $version = explode(' ', $parts[1])[0];
        } else {
            $parts = explode(' ', $resultant ?: '');
            $version = $parts[1] ?? '';
        }

        return new BrowserMatch(BrowserType::Opera, $version);
    }

    private function checkOPR(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'OPR') === false) {
            return null;
        }
        $version = $this->versionAfter($ua, 'OPR');
        if ($version === 'unknown') {
            return null;
        }

        return new BrowserMatch(BrowserType::OperaChromium, $version);
    }

    private function checkNetscapeNavigator(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Firefox') !== false && preg_match('/Navigator\/([^ ]*)/i', $ua, $matches)) {
            return new BrowserMatch(BrowserType::NetscapeNavigator, $matches[1]);
        }
        if (stripos($ua, 'Firefox') === false && preg_match('/Netscape6?\/([^ ]*)/i', $ua, $matches)) {
            return new BrowserMatch(BrowserType::NetscapeNavigator, $matches[1]);
        }

        return null;
    }

    private function checkFirefox(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'safari') !== false) {
            return null;
        }
        if (preg_match('/Firefox[\/ \(]([^ ;\)]+)/i', $ua, $matches)) {
            return new BrowserMatch(BrowserType::Firefox, $matches[1]);
        }
        if (preg_match('/Firefox$/i', $ua)) {
            return new BrowserMatch(BrowserType::Firefox, '');
        }

        return null;
    }

    private function checkBrave(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Brave') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Brave, $this->versionAfter($ua, 'Brave'));
    }

    private function checkVivaldi(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Vivaldi') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Vivaldi, $this->versionAfter($ua, 'Vivaldi'));
    }

    private function checkSamsungInternet(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'SamsungBrowser') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::SamsungInternet, $this->versionAfter($ua, 'SamsungBrowser'));
    }

    private function checkDuckDuckGo(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'DuckDuckGo') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::DuckDuckGo, $this->versionAfter($ua, 'DuckDuckGo'));
    }

    private function checkUCBrowser(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'UCBrowser') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::UCBrowser, $this->versionAfter($ua, 'UCBrowser'));
    }

    private function checkMiBrowser(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'MiuiBrowser') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::MiBrowser, $this->versionAfter($ua, 'MiuiBrowser'));
    }

    private function checkChrome(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Chrome') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Chrome, $this->versionAfter($ua, 'Chrome'));
    }

    private function checkOmniWeb(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'omniweb') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::OmniWeb, $this->versionAfter($ua, 'omniweb'));
    }

    private function checkFacebook(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'FBAN') === false && stripos($ua, 'FBAV') === false) {
            return null;
        }
        $version = preg_match('/FBAV\/([^ ;)]+)/i', $ua, $matches) ? $matches[1] : 'unknown';

        return new BrowserMatch(BrowserType::Facebook, $version);
    }

    private function checkAndroid(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Android') === false) {
            return null;
        }
        $parts = explode(' ', stristr($ua, 'Android') ?: '');
        $version = isset($parts[1]) ? explode(' ', $parts[1])[0] : 'unknown';

        return new BrowserMatch(BrowserType::Android, $version);
    }

    private function checkiPad(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'iPad') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::iPad, $this->getIOSBrowserVersion($ua));
    }

    private function checkiPod(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'iPod') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::iPod, $this->getIOSBrowserVersion($ua));
    }

    private function checkiPhone(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'iPhone') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::iPhone, $this->getIOSBrowserVersion($ua));
    }

    private function checkBlackBerry(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'blackberry') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::BlackBerry, $this->versionAfter($ua, 'blackberry'));
    }

    private function checkNokia(string $ua): ?BrowserMatch
    {
        if (!preg_match('/Nokia([^\/]+)\/([^ SP]+)/i', $ua, $matches)) {
            return null;
        }
        $type = (stripos($ua, 'Series60') !== false || str_contains($ua, 'S60'))
            ? BrowserType::NokiaS60
            : BrowserType::Nokia;

        return new BrowserMatch($type, $matches[2]);
    }

    private function checkGoogleBot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'googlebot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'googlebot'));

        return new BrowserMatch(BrowserType::GoogleBot, $version, true);
    }

    private function checkMSNBot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'msnbot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'msnbot'));

        return new BrowserMatch(BrowserType::MSNBot, $version, true);
    }

    private function checkSlurp(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'slurp') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Slurp, $this->versionAfter($ua, 'Slurp'), true);
    }

    private function checkBingBot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'bingbot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'bingbot'));

        return new BrowserMatch(BrowserType::BingBot, $version, true);
    }

    private function checkYandexBot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'YandexBot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'YandexBot'));

        return new BrowserMatch(BrowserType::YandexBot, $version, true);
    }

    private function checkApplebot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Applebot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'Applebot'));

        return new BrowserMatch(BrowserType::Applebot, $version, true);
    }

    private function checkDuckDuckBot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'DuckDuckBot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'DuckDuckBot'));

        return new BrowserMatch(BrowserType::DuckDuckBot, $version, true);
    }

    private function checkFacebookBot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'facebookexternalhit') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'facebookexternalhit'));

        return new BrowserMatch(BrowserType::FacebookBot, $version, true);
    }

    private function checkTwitterBot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Twitterbot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'Twitterbot'));

        return new BrowserMatch(BrowserType::TwitterBot, $version, true);
    }

    private function checkLinkedInBot(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'LinkedInBot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'LinkedInBot'));

        return new BrowserMatch(BrowserType::LinkedInBot, $version, true);
    }

    private function checkWhatsApp(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'WhatsApp') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'WhatsApp'));

        return new BrowserMatch(BrowserType::WhatsApp, $version, true);
    }

    private function checkTelegram(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'TelegramBot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'TelegramBot'));

        return new BrowserMatch(BrowserType::Telegram, $version, true);
    }

    private function checkDiscord(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Discordbot') === false) {
            return null;
        }
        $version = str_replace(';', '', $this->versionAfter($ua, 'Discordbot'));

        return new BrowserMatch(BrowserType::Discord, $version, true);
    }

    private function checkSafari(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Safari') === false || stripos($ua, 'iPhone') !== false || stripos($ua, 'iPod') !== false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Safari, $this->versionAfter($ua, 'Version'));
    }

    private function checkKonqueror(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Konqueror') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Konqueror, $this->versionAfter($ua, 'Konqueror'));
    }

    private function checkICab(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'icab') === false) {
            return null;
        }
        $parts = explode(' ', stristr(str_replace('/', ' ', $ua), 'icab') ?: '');
        $version = $parts[1] ?? 'unknown';

        return new BrowserMatch(BrowserType::ICab, $version);
    }

    private function checkAmaya(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'amaya') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Amaya, $this->versionAfter($ua, 'Amaya'));
    }

    private function checkLynx(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'lynx') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Lynx, $this->versionAfter($ua, 'Lynx'));
    }

    private function checkShiretoko(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Mozilla') === false || !preg_match('/Shiretoko\/([^ ]*)/i', $ua, $matches)) {
            return null;
        }

        return new BrowserMatch(BrowserType::Shiretoko, $matches[1]);
    }

    private function checkIceCat(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Mozilla') === false || !preg_match('/IceCat\/([^ ]*)/i', $ua, $matches)) {
            return null;
        }

        return new BrowserMatch(BrowserType::IceCat, $matches[1]);
    }

    private function checkIceweasel(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'Iceweasel') === false) {
            return null;
        }

        return new BrowserMatch(BrowserType::Iceweasel, $this->versionAfter($ua, 'Iceweasel'));
    }

    private function checkW3CValidator(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'W3C-checklink') !== false) {
            return new BrowserMatch(BrowserType::W3CValidator, $this->versionAfter($ua, 'W3C-checklink'));
        }
        if (stripos($ua, 'W3C_Validator') !== false) {
            $fixed = str_replace('W3C_Validator ', 'W3C_Validator/', $ua);

            return new BrowserMatch(BrowserType::W3CValidator, $this->versionAfter($fixed, 'W3C_Validator'));
        }

        return null;
    }

    private function checkMozilla(string $ua): ?BrowserMatch
    {
        if (stripos($ua, 'mozilla') === false || stripos($ua, 'netscape') !== false) {
            return null;
        }
        if (preg_match('/rv:([0-9]+\.[0-9]+[a-b]?)/i', $ua, $matches)) {
            return new BrowserMatch(BrowserType::Mozilla, $matches[1]);
        }
        if (preg_match('/mozilla\/([^ ]*)/i', $ua, $matches)) {
            return new BrowserMatch(BrowserType::Mozilla, $matches[1]);
        }

        return null;
    }

    private function getIOSBrowserVersion(string $ua): string
    {
        if (preg_match('/CriOS\/([^ ]+)/i', $ua, $matches)) {
            return $matches[1];
        }
        if (preg_match('/FxiOS\/([^ ]+)/i', $ua, $matches)) {
            return $matches[1];
        }

        return $this->versionAfter($ua, 'Version');
    }
}
