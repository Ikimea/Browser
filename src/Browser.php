<?php

namespace Ikimea\Browser;

final class Browser
{
    public readonly BrowserResult $result;

    public function __construct(?string $userAgent = null)
    {
        $ua = $userAgent ?? ($_SERVER['HTTP_USER_AGENT'] ?? '');
        $platformDetector = new PlatformDetector();
        $browserDetector = new BrowserDetector();

        $platformResult = $platformDetector->detect($ua);
        [$browser, $version, $isRobot] = $browserDetector->detect($ua);

        $version = preg_replace('/[^0-9.,a-zA-Z-]/', '', $version);

        $this->result = new BrowserResult(
            userAgent: $ua,
            browser: $browser,
            version: $version,
            platform: $platformResult->platform,
            isMobile: $platformResult->isMobile,
            isRobot: $isRobot,
        );
    }

    public function getBrowser(): BrowserType
    {
        return $this->result->browser;
    }

    public function getVersion(): string
    {
        return $this->result->version;
    }

    public function getMajorVersion(): string|int
    {
        return $this->result->majorVersion();
    }

    public function getPlatform(): PlatformType
    {
        return $this->result->platform;
    }

    public function isMobile(): bool
    {
        return $this->result->isMobile;
    }

    public function isRobot(): bool
    {
        return $this->result->isRobot;
    }

    public function isBrowser(BrowserType $type): bool
    {
        return $this->result->isBrowser($type);
    }

    public function getUserAgent(): string
    {
        return $this->result->userAgent;
    }
}
