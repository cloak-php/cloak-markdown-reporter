<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reporter;

use cloak\reporter\Reportable;
use cloak\Result;
use cloak\result\File;
use cloak\writer\FileWriter;
use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;


/**
 * Class MarkdownReporter
 * @package cloak\reporter
 */
class MarkdownReporter implements ReporterInterface
{

    use Reportable;

    /**
     * @var \cloak\writer\FileWriter
     */
    private $reportWriter;

    /**
     * @param string $outputFilePath
     */
    public function __construct($outputFilePath)
    {
        $this->reportWriter = new FileWriter($outputFilePath);
    }

    /**
     * @param StartEventInterface $event
     */
    public function onStart(StartEventInterface $event)
    {
    }

    /**
     * @param StopEventInterface $event
     */
    public function onStop(StopEventInterface $event)
    {
        $this->writeMarkdownReport($event->getResult());
    }

    /**
     * @param Result $result
     */
    private function writeMarkdownReport(Result $result)
    {
        $this->writeTitle();
        $this->writeDescription();
        $this->writeResult($result);
    }

    private function writeTitle()
    {
        $this->reportWriter->writeLine('# Code Coverage Report');
        $this->reportWriter->writeLine('');
    }

    private function writeDescription()
    {
        $this->reportWriter->writeLine('Generator: cloak  ');
        $this->reportWriter->writeLine('Generated at: 2014-07-10 00:00:00  ');
        $this->reportWriter->writeLine('');
    }

    private function writeResultHeader()
    {
        $this->reportWriter->writeLine('## Result');
        $this->reportWriter->writeLine('');

        $this->reportWriter->writeLine('| No. | File | Line | Coverage |');
        $this->reportWriter->writeLine('|:-|:-|-:|-:|');
    }

    private function writeResult(Result $result)
    {
        $this->writeResultHeader();

        $files = $result->getFiles();

        foreach ($files as $key => $file) {
            $orderNumber = $key + 1;
            $this->writeFileResult($orderNumber, $file);
        }
    }

    private function writeFileResult($orderNumber, File $file)
    {

        $lineResult = sprintf("%2d/%2d",
            $file->getExecutedLineCount(),
            $file->getExecutableLineCount()
        );

        $coverageResult = sprintf('%6.2f%%', $file->getCodeCoverage()->value());

        $parts = [
            $orderNumber,
            $file->getRelativePath(getcwd()),
            $lineResult,
            $coverageResult
        ];

        $record = '|' . implode('|', $parts) . '|';

        $this->reportWriter->writeLine($record);
    }

}
