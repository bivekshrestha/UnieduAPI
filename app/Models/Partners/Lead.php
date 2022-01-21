<?php

namespace App\Models\Partners;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lead extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public static function selectData()
    {
        return Lead::select(DB::raw("CONCAT(first_name, ' ', last_name, '(', country, ')') AS text"), 'id as value')->get();
    }
}
