<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    public static function getStatusIdByName($name){
        $status = Status::where("name" , $name)->first();
        if($status) return $status->id;
        else return false;
    }
}
