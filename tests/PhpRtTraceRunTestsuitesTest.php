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
                if ($ret !== 0 ) {
                    throw new \RuntimeException('cmd ' . $cmd . ' was not successfull, ret code: ' . $ret);
                }
            }
        } finally {
            chdir($originalDir);
        }
    }

    public function testSymfonyTestsuit()
    {
        $dir = __DIR__ .'/../integration_tests/symfony';

        self::execute(getcwd(), [
            'rm -rf ' . escapeshellarg($dir) . ' || true',
            'mkdir -p ' . escapeshellarg($dir),
        ]);

        $rewrite = __DIR__ . '/../rewrite.php';

        self::execute($dir, [
            'git clone https://github.com/symfony/symfony.git .',
            'composer install --no-scripts --no-interaction',
            'rm src/Symfony/Bridge/Monolog/Tests/Handler/ServerLogHandlerTest.php',
            'rm src/Symfony/Component/HttpKernel/Tests/HttpCache/HttpCacheTest.php',
            'rm src/Symfony/Component/VarDumper/Tests/Server/ConnectionTest.php',
            // 'php -n ./vendor/bin/simple-phpunit -c .',
            'php -n ' . $rewrite . ' src',
        ]);

    }
}