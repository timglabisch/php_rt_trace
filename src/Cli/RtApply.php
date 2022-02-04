<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Cli;

use SplFileInfo;
use timglabisch\PhpRtTrace\LogReader\Collector\RtPropertyCollector;
use timglabisch\PhpRtTrace\LogReader\RtLogReader;
use timglabisch\PhpRtTrace\RtTraceRewriter;
use timglabisch\PhpRtTrace\TypeApplyer\RtTypeApplyer;

class RtApply
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

                    if (
                        $item->getExtension() !== "php"
                        && $item->getExtension() !== "rttrace"
                    ) {
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

        $traceFiles = array_filter($files, fn(SplFileInfo $v) => $v->getExtension() === 'rttrace');

        $logReader = new RtLogReader($traceFiles);

        $phpfiles = array_filter($files, fn(SplFileInfo $v) => $v->getExtension() === 'php');

        $propertyCollectors = new \SplObjectStorage();

        foreach ($phpfiles as $file) {
            $logReader->addCollector($propertyCollectors[$file] = new RtPropertyCollector([
                $file->getPathname()
            ]));
        }

        echo "Analyzing ".count($traceFiles)." trace files\n";
        $logReader->run();
        echo "finished analyzing trace files\n";

        foreach ($phpfiles as $file) {
            $applyer = RtTypeApplyer::newFromFile($file->getPathname());
            $applyer->applyPropertyTypes($propertyCollectors[$file]->getPropertyTypeMap());
            file_put_contents($file->getPathname(), $applyer->getPretty());
            echo 'rewritten file ' . $file->getPathname() . "\n";
        }

        echo 'done'. "\n";
    }
}