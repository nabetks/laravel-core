<?php

namespace Aijoh\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JapanArea extends Model {

    protected $table = 'japan_areas';

    protected $fillable = [
        'code',
        'name',
        'name_kana',
        'name_en',

    ];

    public function prefectures() : HasMany {
        return $this->hasMany(JapanPrefecture::class, 'japan_area_id', 'id');
    }
}
