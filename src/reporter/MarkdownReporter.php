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
    }

}
