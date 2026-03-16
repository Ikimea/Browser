<?php

namespace Ikimea\Browser;

final class BrowserDetector
{
    public function detect(string $userAgent): array
    {
        return $this->checkYandex($userAgent)
            ?? $this->checkEdge($userAgent)
            ?? $this->checkIE($userAgent)
            ?? $this->checkOperaMini($userAgent)
            ?? $this->checkOpera($userAgent)
            ?? $this->checkOPR($userAgent)
            ?? $this->checkNetscapeNavigator($userAgent)
            ?? $this->checkFirefox($userAgent)
            ?? $this->checkChrome($userAgent)
            ?? $this->checkOmniWeb($userAgent)
            ?? $this->checkFacebook($userAgent)
            ?? $this->checkAndroid($userAgent)
            ?? $this->checkiPad($userAgent)
            ?? $this->checkiPod($userAgent)
            ?? $this->checkiPhone($userAgent)
            ?? $this->checkBlackBerry($userAgent)
            ?? $this->checkNokia($userAgent)
            ?? $this->checkGoogleBot($userAgent)
            ?? $this->checkMSNBot($userAgent)
            ?? $this->checkSlurp($userAgent)
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
            ?? [BrowserType::Unknown, 'unknown', false];
    }

    /** @return array{BrowserType, string, bool}|null — [type, version, isRobot] */
    private function checkYandex(string $ua): ?array
    {
        if (stripos($ua, 'YaBrowser') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'YaBrowser'));
        $version = explode(' ', $parts[1])[0];

        return [BrowserType::Yandex, $version, false];
    }

    private function checkEdge(string $ua): ?array
    {
        if (stripos($ua, 'Edge') === false && stripos($ua, 'Edg/') === false) {
            return null;
        }
        if (stripos($ua, 'Edge') !== false) {
            $parts = explode('/', stristr($ua, 'Edge'));
        } else {
            $parts = explode('/', stristr($ua, 'Edg'));
        }
        $version = explode(' ', $parts[1] ?? '')[0];

        return [BrowserType::Edge, $version, false];
    }

    private function checkIE(string $ua): ?array
    {
        if (stripos($ua, 'Trident/7.0') !== false && stripos($ua, 'rv:11.0') !== false) {
            return [BrowserType::IE, '11.0', false];
        }
        if (stripos($ua, 'msie') !== false && stripos($ua, 'opera') === false) {
            if (stripos($ua, 'msnb') !== false) {
                $parts = explode(' ', stristr(str_replace(';', '; ', $ua), 'MSN'));
                $version = str_replace(['(', ')', ';'], '', $parts[1]);

                return [BrowserType::MSN, $version, false];
            }
            $parts = explode(' ', stristr(str_replace(';', '; ', $ua), 'msie'));
            $version = str_replace(['(', ')', ';'], '', $parts[1]);

            return [BrowserType::IE, $version, false];
        }
        if (stripos($ua, 'mspie') !== false || stripos($ua, 'pocket') !== false) {
            if (stripos($ua, 'mspie') !== false) {
                $parts = explode(' ', stristr($ua, 'mspie'));
                $version = $parts[1] ?? 'unknown';
            } else {
                $parts = explode('/', $ua);
                $version = $parts[1] ?? 'unknown';
            }

            return [BrowserType::PocketIE, $version, false];
        }

        return null;
    }

    private function checkOperaMini(string $ua): ?array
    {
        if (stripos($ua, 'opera mini') === false) {
            return null;
        }
        $resultant = stristr($ua, 'opera mini');
        if (preg_match('/\//', $resultant)) {
            $parts = explode('/', $resultant);
            $version = explode(' ', $parts[1])[0];
        } else {
            $parts = explode(' ', stristr($resultant, 'opera mini'));
            $version = $parts[1] ?? 'unknown';
        }

        return [BrowserType::OperaMini, $version, false];
    }

    private function checkOpera(string $ua): ?array
    {
        if (stripos($ua, 'opera') === false) {
            return null;
        }
        $resultant = stristr($ua, 'opera');
        if (preg_match('/Version\/([0-9]*\.[0-9]*)$/', $resultant, $matches)) {
            $version = $matches[1];
        } elseif (preg_match('/\//', $resultant)) {
            $parts = explode('/', str_replace('(', ' ', $resultant));
            $version = explode(' ', $parts[1])[0];
        } else {
            $parts = explode(' ', stristr($resultant, 'opera'));
            $version = $parts[1] ?? '';
        }

        return [BrowserType::Opera, $version, false];
    }

    private function checkOPR(string $ua): ?array
    {
        if (stripos($ua, 'OPR') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'OPR'));
        if (empty($parts[1])) {
            return null;
        }
        $version = explode(' ', $parts[1])[0];

        return [BrowserType::OperaChromium, $version, false];
    }

    private function checkNetscapeNavigator(string $ua): ?array
    {
        if (stripos($ua, 'Firefox') !== false && preg_match('/Navigator\/([^ ]*)/i', $ua, $matches)) {
            return [BrowserType::NetscapeNavigator, $matches[1], false];
        }
        if (stripos($ua, 'Firefox') === false && preg_match('/Netscape6?\/([^ ]*)/i', $ua, $matches)) {
            return [BrowserType::NetscapeNavigator, $matches[1], false];
        }

        return null;
    }

    private function checkFirefox(string $ua): ?array
    {
        if (stripos($ua, 'safari') !== false) {
            return null;
        }
        if (preg_match('/Firefox[\/ \(]([^ ;\)]+)/i', $ua, $matches)) {
            return [BrowserType::Firefox, $matches[1], false];
        }
        if (preg_match('/Firefox$/i', $ua)) {
            return [BrowserType::Firefox, '', false];
        }

        return null;
    }

    private function checkChrome(string $ua): ?array
    {
        if (stripos($ua, 'Chrome') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'Chrome'));
        $version = explode(' ', $parts[1])[0];

        return [BrowserType::Chrome, $version, false];
    }

    private function checkOmniWeb(string $ua): ?array
    {
        if (stripos($ua, 'omniweb') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'omniweb'));
        $version = explode(' ', $parts[1] ?? '')[0];

        return [BrowserType::OmniWeb, $version, false];
    }

    private function checkFacebook(string $ua): ?array
    {
        if (stripos($ua, 'FBAN') === false && stripos($ua, 'FBAV') === false) {
            return null;
        }
        $version = preg_match('/FBAV\/([^ ;)]+)/i', $ua, $matches) ? $matches[1] : 'unknown';

        return [BrowserType::Facebook, $version, false];
    }

    private function checkAndroid(string $ua): ?array
    {
        if (stripos($ua, 'Android') === false) {
            return null;
        }
        $parts = explode(' ', stristr($ua, 'Android'));
        $version = isset($parts[1]) ? explode(' ', $parts[1])[0] : 'unknown';

        return [BrowserType::Android, $version, false];
    }

    private function checkiPad(string $ua): ?array
    {
        if (stripos($ua, 'iPad') === false) {
            return null;
        }

        return [BrowserType::iPad, $this->getIOSBrowserVersion($ua), false];
    }

    private function checkiPod(string $ua): ?array
    {
        if (stripos($ua, 'iPod') === false) {
            return null;
        }

        return [BrowserType::iPod, $this->getIOSBrowserVersion($ua), false];
    }

    private function checkiPhone(string $ua): ?array
    {
        if (stripos($ua, 'iPhone') === false) {
            return null;
        }

        return [BrowserType::iPhone, $this->getIOSBrowserVersion($ua), false];
    }

    private function checkBlackBerry(string $ua): ?array
    {
        if (stripos($ua, 'blackberry') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'BlackBerry'));
        $version = explode(' ', $parts[1] ?? 'unknown')[0];

        return [BrowserType::BlackBerry, $version, false];
    }

    private function checkNokia(string $ua): ?array
    {
        if (!preg_match('/Nokia([^\/]+)\/([^ SP]+)/i', $ua, $matches)) {
            return null;
        }
        $type = (stripos($ua, 'Series60') !== false || str_contains($ua, 'S60'))
            ? BrowserType::NokiaS60
            : BrowserType::Nokia;

        return [$type, $matches[2], false];
    }

    private function checkGoogleBot(string $ua): ?array
    {
        if (stripos($ua, 'googlebot') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'googlebot'));
        $version = str_replace(';', '', explode(' ', $parts[1])[0]);

        return [BrowserType::GoogleBot, $version, true];
    }

    private function checkMSNBot(string $ua): ?array
    {
        if (stripos($ua, 'msnbot') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'msnbot'));
        $version = str_replace(';', '', explode(' ', $parts[1])[0]);

        return [BrowserType::MSNBot, $version, true];
    }

    private function checkSlurp(string $ua): ?array
    {
        if (stripos($ua, 'slurp') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'Slurp'));
        $version = explode(' ', $parts[1] ?? '')[0];

        return [BrowserType::Slurp, $version, true];
    }

    private function checkSafari(string $ua): ?array
    {
        if (stripos($ua, 'Safari') === false || stripos($ua, 'iPhone') !== false || stripos($ua, 'iPod') !== false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'Version'));
        $version = isset($parts[1]) ? explode(' ', $parts[1])[0] : 'unknown';

        return [BrowserType::Safari, $version, false];
    }

    private function checkKonqueror(string $ua): ?array
    {
        if (stripos($ua, 'Konqueror') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'Konqueror'));
        $version = explode(' ', $parts[0])[0];
        $versionParts = explode('/', $parts[0]);
        $version = $versionParts[1] ?? 'unknown';

        return [BrowserType::Konqueror, $version, false];
    }

    private function checkICab(string $ua): ?array
    {
        if (stripos($ua, 'icab') === false) {
            return null;
        }
        $parts = explode(' ', stristr(str_replace('/', ' ', $ua), 'icab'));
        $version = $parts[1] ?? 'unknown';

        return [BrowserType::ICab, $version, false];
    }

    private function checkAmaya(string $ua): ?array
    {
        if (stripos($ua, 'amaya') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'Amaya'));
        $version = explode(' ', $parts[1] ?? '')[0];

        return [BrowserType::Amaya, $version, false];
    }

    private function checkLynx(string $ua): ?array
    {
        if (stripos($ua, 'lynx') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'Lynx'));
        $version = explode(' ', $parts[1] ?? '')[0];

        return [BrowserType::Lynx, $version, false];
    }

    private function checkShiretoko(string $ua): ?array
    {
        if (stripos($ua, 'Mozilla') === false || !preg_match('/Shiretoko\/([^ ]*)/i', $ua, $matches)) {
            return null;
        }

        return [BrowserType::Shiretoko, $matches[1], false];
    }

    private function checkIceCat(string $ua): ?array
    {
        if (stripos($ua, 'Mozilla') === false || !preg_match('/IceCat\/([^ ]*)/i', $ua, $matches)) {
            return null;
        }

        return [BrowserType::IceCat, $matches[1], false];
    }

    private function checkIceweasel(string $ua): ?array
    {
        if (stripos($ua, 'Iceweasel') === false) {
            return null;
        }
        $parts = explode('/', stristr($ua, 'Iceweasel'));
        $version = explode(' ', $parts[1] ?? '')[0];

        return [BrowserType::Iceweasel, $version, false];
    }

    private function checkW3CValidator(string $ua): ?array
    {
        if (stripos($ua, 'W3C-checklink') !== false) {
            $parts = explode('/', stristr($ua, 'W3C-checklink'));
            $version = explode(' ', $parts[1] ?? '')[0];

            return [BrowserType::W3CValidator, $version, false];
        }
        if (stripos($ua, 'W3C_Validator') !== false) {
            $fixed = str_replace('W3C_Validator ', 'W3C_Validator/', $ua);
            $parts = explode('/', stristr($fixed, 'W3C_Validator'));
            $version = explode(' ', $parts[1] ?? '')[0];

            return [BrowserType::W3CValidator, $version, false];
        }

        return null;
    }

    private function checkMozilla(string $ua): ?array
    {
        if (stripos($ua, 'mozilla') === false || stripos($ua, 'netscape') !== false) {
            return null;
        }
        if (preg_match('/rv:([0-9]+\.[0-9]+[a-b]?)/i', $ua, $matches)) {
            return [BrowserType::Mozilla, $matches[1], false];
        }
        if (preg_match('/mozilla\/([^ ]*)/i', $ua, $matches)) {
            return [BrowserType::Mozilla, $matches[1], false];
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
        $parts = explode('/', stristr($ua, 'Version'));
        if (isset($parts[1])) {
            return explode(' ', $parts[1])[0];
        }

        return 'unknown';
    }
}
