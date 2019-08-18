<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Component\Log;

use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\WebProcessor;

class LogEnhancer
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(new PsrLogMessageProcessor());
            if (config('helper.log.extra_field.runtime_file_record')) {
                $handler->pushProcessor(new RuntimeFileProcessor());
            }
            if (config('helper.log.extra_field.memory_message')) {
                $handler->pushProcessor(new MemoryUsageProcessor());
                $handler->pushProcessor(new MemoryPeakUsageProcessor());
            }
            if (config('helper.log.extra_field.web_message')) {
                $handler->pushProcessor(new MemoryUsageProcessor());
            }
            if (config('helper.log.extra_field.process_id')) {
                $handler->pushProcessor(new WebProcessor());
            }
        }
    }
}
