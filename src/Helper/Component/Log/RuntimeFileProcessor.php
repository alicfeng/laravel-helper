<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Component\Log;

use Monolog\Processor\ProcessorInterface;

class RuntimeFileProcessor implements ProcessorInterface
{
    public function __invoke($record)
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        $trace = array_filter($trace, function ($item) {
            if (!array_key_exists('file', $item)) {
                return true;
            }

            if (false !== strpos($item['file'], 'vendor')) {
                return false;
            }

            return true;
        });
        $trace = array_values($trace);

        try {
            $record['extra']['runtime_file'] = [
                'file'     => $trace[1]['file'] . ':' . $trace[1]['line'],
                'function' => $trace[2]['class'] . $trace[2]['type'] . $trace[2]['function'],
            ];
        } catch (\Exception $exception) {
        }

        return $record;
    }
}
