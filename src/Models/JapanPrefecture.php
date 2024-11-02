<?php

namespace Aijoh\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JapanPrefecture extends Model {

    protected $table = 'japan_prefectures';

    protected $fillable = [
        'code',
        'name',
        'name_kana',
        'name_en',
        'japan_area_id',
        'order',
    ];

    public function area() : BelongsTo {
        return $this->belongsTo(JapanArea::class);
    }

}
