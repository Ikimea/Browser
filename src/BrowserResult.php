<?php

namespace Ikimea\Browser;

final readonly class BrowserResult
{
    public function __construct(
        public string $userAgent,
        public BrowserType $browser,
        public string $version,
        public PlatformType $platform,
        public bool $isMobile,
        public bool $isRobot,
    ) {}

    public function majorVersion(): string|int
    {
        $floor = floor((float) $this->version);

        return $floor > 0 ? (int) $floor : $this->version;
    }

    public function isBrowser(BrowserType $type): bool
    {
        return $this->browser === $type;
    }
}
