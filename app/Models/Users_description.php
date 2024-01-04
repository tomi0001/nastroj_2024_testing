<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_description extends Model
{
    use HasFactory;
    public static function showDescriptions(int $id) {
        return self::join("descriptions","descriptions.id","users_descriptions.id_descriptions")
                ->selectRaw("descriptions.date as date")
                ->selectRaw("descriptions.description as description")
                ->where("users_descriptions.id_usees",$id)
                ->get();
    }
}
