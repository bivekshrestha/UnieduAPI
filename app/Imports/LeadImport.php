<?php

namespace App\Imports;

use App\Models\Partners\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadImport implements ToModel,  WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Lead
     */
    public function model(array $row)
    {
        return new Lead([
            //
        ]);
    }
}
