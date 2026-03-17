<?php

namespace Ikimea\Browser;

final readonly class BrowserMatch
{
    public function __construct(
        public BrowserType $browser,
        public string $version,
        public bool $isRobot = false,
    ) {}
}
