<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Cli;

use PhpParser\Error;
use timglabisch\PhpRtTrace\RtTraceRewriter;

class RtRewrite
{
    private array $arguments = [];

    public function __construct(
        private array $args
    )
    {
        $this->arguments = array_slice($this->args, 1);
    }

    public function run(): int {

        /** @var \SplFileInfo[] $files */
        $files = [];

        foreach ($this->arguments as $argument) {

            if (is_file($argument)) {
                $files[] = new \SplFileInfo($argument);
                continue;
            }

            if (is_dir($argument)) {
                foreach ( new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($argument, \FilesystemIterator::FOLLOW_SYMLINKS)) as $item) {
                    /** @var \SplFileInfo $item */
                    if ($item->isDir()) {
                        continue;
                    }

                    if ($item->getExtension() !== "php") {
                        continue;
                    }

                    if (str_ends_with($item->getBasename(), 'Test.php')) {
                        continue;
                    }

                    $files[] = $item;
                }
                continue;
            }

            throw new \LogicException('invalid argument ' . $argument);
        }

        $this->rewriteFiles($files);

        return 0;
    }

    /** @param \SplFileInfo[] $files */
    private function rewriteFiles(array $files) {

        $rewriter = new RtTraceRewriter();

        foreach ($files as $file) {
            echo "rewrite " . $file->getPathname();

            try {
                $rewrittenContent = $rewriter->rewriteFile($file->getPathname());
            } catch (Error $error) {
                echo "Parse error: {$error->getMessage()}\n";
                continue;
            }


            file_put_contents($file->getPathname(), $rewrittenContent);

            $out = '';
            $code = '';
            exec('php -l ' . escapeshellarg($file->getPathname()), $out, $code);

            if ((int)$code !== 0) {
                echo 'linting failed' . "\n";
                die();
            }

            echo " - done\n";

        }

        echo 'done'. "\n";
    }
}