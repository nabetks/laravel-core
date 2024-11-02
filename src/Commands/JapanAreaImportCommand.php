<?php

namespace Aijoh\Core\Commands;

use Aijoh\Core\Models\JapanArea;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class JapanAreaImportCommand extends Command
{
    public $signature = 'japan_area_import';

    public $description = '日本の地域や都道府県をインポートします';

    public function handle(): int
    {
        $this->info('日本の地域や都道府県をインポートします');
        $areas = Config::get('aijoh-core.japan_areas');
        foreach ($areas as $area) {
            $this->info('地域: '.$area['name']);
            $area = new JapanArea;
            $area->fill($area);
            $area->save();
        }

        $this->info('日本の地域をインポートしました');

        $this->info('日本の都道府県をインポートします');
        $prefectures = Config::get('aijoh-core.japan_prefectures');
        foreach ($prefectures as $prefecture) {
            $this->info('都道府県: '.$prefecture['name']);
            $prefecture = new JapanArea;
            $prefecture->fill($prefecture);
            $prefecture->save();
        }
        $this->info('日本の都道府県をインポートしました');

        return self::SUCCESS;
    }
}
