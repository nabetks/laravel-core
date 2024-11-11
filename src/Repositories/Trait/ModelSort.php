<?php

namespace Aijoh\Core\Repositories\Traits;

use Illuminate\Support\Facades\DB;

trait ModelSort
{
    public function sortIdList(array $ids, string $primaryKey = 'id'): string
    {
        $sql = 'CASE ';
        foreach ($ids as $key => $id) {
            $id = DB::escape($id);
            $sql .= 'WHEN `'.$primaryKey."` = $id THEN $key ";
        }
        $sql .= 'END';

        return $sql;
    }
}
