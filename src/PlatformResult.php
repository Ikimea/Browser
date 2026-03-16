<?php

namespace Ikimea\Browser;

final readonly class PlatformResult
{
    public function __construct(
        public PlatformType $platform,
        public bool $isMobile,
    ) {}
}
