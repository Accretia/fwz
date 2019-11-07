<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //

    public function country(){
        return $this->hasOne("App\Models\Country", "id", "country_id");
    }

    public static function getRegionIdByName($name)
    {
        $regionList = array();
        $regions = Region::where("name" , $name)->get();
        foreach ( $regions as $region )
        {
            $regionList[] = $region->id;
        }
        return $regionList;
    }
}
