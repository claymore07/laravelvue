<?php

namespace App\Imports;

use App\Models\BlackList;
use Maatwebsite\Excel\Concerns\ToModel;

class BlackListImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return BlackList
    */
    public function model(array $row)
    {
        return new BlackList([
            //
            'title' => $row[0],
            'issn' => $row[1],
            'indexing' => $row[2],
            'url' => $row[3],
            'fake_url' => $row[4]
        ]);
    }
}
