<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FrameworkCommand extends Command
{
    protected $signature   = 'samego:framework {help?}';
    protected $description = 'samego:framework';

    const FOLDER_LIST = [
        'lib',
        'sbin',
        'etc',
        'app/Constant',
        'app/Enum',
        'app/Helper',
        'app/Service',
        'app/Repository',
        'app/Http/Transform',
        'app/Facades',
        'app/Contracts',
    ];

    public function handle()
    {
        foreach (self::FOLDER_LIST as $folder) {
            if (false === File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
                File::put($folder . DIRECTORY_SEPARATOR . '.gitkeep', '');
                echo "\033[33m make {$folder} successful \033[0m\n";
            }
        }
    }
}
