<?php

namespace Tests\timglabisch\PhpRtTrace;

use PHPUnit\Framework\TestCase;

class PhpRtTraceRunTestsuitesTest extends TestCase
{
    private static function execute(string $dir, array $cmds): void
    {
        $originalDir = getcwd();
        chdir($dir);
        try {
            foreach ($cmds as $cmd) {
                $ret = null;
                passthru($cmd, $ret);
                if ($ret !== 0) {
                    throw new \RuntimeException('cmd ' . $cmd . ' was not successfull, ret code: ' . $ret);
                }
            }
        } finally {
            chdir($originalDir);
        }
    }

    public function testSymfonyTestsuit()
    {
        $dir = __DIR__ . '/../integration_tests/symfony';
        $rewrite = __DIR__ . '/../rewrite.php';


        self::execute(getcwd(), [
            'rm -rf ' . escapeshellarg($dir) . ' || true',
            'mkdir -p ' . escapeshellarg($dir),
        ]);

        self::execute($dir, [
            'git clone https://github.com/symfony/symfony.git .',
            'composer install --no-scripts --no-interaction',
            'rm src/Symfony/Bridge/Monolog/Tests/Handler/ServerLogHandlerTest.php',
            'rm src/Symfony/Component/HttpKernel/Tests/HttpCache/HttpCacheTest.php',
            'rm src/Symfony/Component/VarDumper/Tests/Server/ConnectionTest.php',
            // 'rm -rf src/Symfony/Component/DependencyInjection/Tests/Dumper',
        ]);

        $rewrites = [];
        foreach (glob(__DIR__ . '/../integration_tests/symfony/src/Symfony/Component/*') as $item) {
            if (
                str_contains($item, 'Workflow')
                || str_contains($item, 'DependencyInjection')
                || str_contains($item, 'VarDumper')
                || str_contains($item, 'VarExporter')
                || str_contains($item, 'Routing')
                || str_contains($item, 'Translation')
            ) {
                continue;
            }
            if (str_starts_with($item, '.')) {
                continue;
            }

            $rewrites[] = $item;
        }

        $autoload = __DIR__ . '/../integration_tests/symfony/vendor/autoload.php';
        file_put_contents($autoload, str_replace('<?php', '<?php require "' . (__DIR__ . '/../vendor/autoload.php') . '";', file_get_contents($autoload)));

        self::execute($dir, [
            'php -n ' . $rewrite . ' ' . join(' ', $rewrites),
            'php -n ./vendor/bin/simple-phpunit -c .',
        ]);

    }
}