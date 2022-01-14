<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Cli;

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
            $rewrittenContent = $rewriter->rewriteFile($file->getPathname());

            file_put_contents($file->getPathname(), $rewrittenContent);

            echo "rewritten " . $file->getPathname() . "\n";

            $out = '';
            $code = '';
            exec('php -l ' . escapeshellarg($file->getPathname()), $out, $code);

            if ((int)$code !== 0) {
                echo 'linting failed' . "\n";
                die();
            }

        }

        echo 'done'. "\n";
    }
}