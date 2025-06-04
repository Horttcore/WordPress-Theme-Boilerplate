<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withRootFiles()
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withImportNames(removeUnusedImports: true)
    ->withTypeCoverageLevel(10)
    ->withDeadCodeLevel(10)
    ->withCodeQualityLevel(10);
