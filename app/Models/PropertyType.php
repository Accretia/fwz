<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    //
    public static function getPropertyTypeIdByName($name){
        $propertyType = PropertyType::where("name" , $name)->first();
        if($propertyType) return $propertyType->id;
        else return false;
    }
}
