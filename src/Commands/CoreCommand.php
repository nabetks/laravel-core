<?php

namespace Aijoh\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CoreCommand extends Command
{
    public $signature = 'core';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');
        $this->createValidationFile();

        return self::SUCCESS;
    }

    private function createValidationFile(): void
    {
        $localPath = realpath(__DIR__.'/../../lang/ja/aijoh-validation.php');
        $path = base_path('lang/ja/aijoh-validation.php');
        if (File::exists($path)) {
            return;
        }
        File::copy($localPath, $path);
    }
}
