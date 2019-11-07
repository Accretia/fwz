<?php


namespace App\Services;


use App\Models\Country;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Region;
use App\Models\Status;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class DummyDataService
{
    /**
     * Generates Dummy data to database
     *
     * @return void
     */
    public static function generateDummyData()
    {
        DB::disableQueryLog();
        $faker = Factory::create();
        $countries = Country::all();
        $regions = Region::all();
        $fourthRegionArray = self::getRegion4Id($regions);
        $status = Status::all();
        $activeStatusId = self::getActiveStatusId($status);
        $inactiveStatusId = self::getInactiveStatusId($status);
        $propertyTypes = PropertyType::all();

        if(Property::all()->count() !== 100000){
            Property::query()->truncate();
            echo "Properties Truncated\n";
        }

        if(Project::all()->count() !== 10000){
            Project::query()->delete();
            echo "Project Delete\n";
            for($i = 0; $i < 10000; $i++){
                $project = new Project();
                $project->name = $faker->name;
                $project->save();
            }
            echo "Project Created\n";
        }


        $projects = Project::all();
        $projectsCount = count($projects);
        $condoPropertyTypeId = self::getPropertyTypeCondoId($propertyTypes);
        $housePropertyTypeId = self::getPropertyTypeHouseId($propertyTypes);
        $projectCount = 0;
        $countConditionFour = 0;
        for($y = 0; $y < 100000 ; $y++){
            if($projectCount < 2001){
                $randProject = $projects[0];
                $projectCount++;
            }
            else{
                $randProject = $projects[rand(1, $projectsCount - 1)];
            }

            if($countConditionFour < 3000){
                $statusId = $activeStatusId;
                $propertyType = $condoPropertyTypeId;
                $bedroom = 2;
                $forSale = 1;
                $countConditionFour++;
            }

            else{
                $statusRand = $faker->numberBetween(0, count($status) - 1);
                $statusId = $status[$statusRand]->id;
                $randomPropertyType = $faker->numberBetween(0, count($propertyTypes) - 1);
                $propertyType = $propertyTypes[$randomPropertyType]->id;
                $bedroom = self::notTwoBedroom();
                $forSale = $faker->numberBetween(0, 1);;
            }

            $forRent = $faker->numberBetween(0, 1);
            $randomRegion = $faker->numberBetween(0, count($regions) - 1) ;

            $property = [
                "title" =>  $faker->name,
                "description" => $faker->text(50),
                "bedroom" => $bedroom,
                "bathroom" => $faker->numberBetween(0, 10),
                "status_id" => $statusId,
                "for_sale" => $forSale,
                "for_rent" => $forRent,
                "region_id" => $regions[$randomRegion]->id,
                "property_type" => $propertyType,
                "project_id" => $randProject->id,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];
            //echo $y."\n";
            DB::table("properties")->insert($property);
        }
        echo "Properties Created\n";

        $countConditionFour = Property::where("status_id" , $activeStatusId)
                                ->where("property_type" , $condoPropertyTypeId)
                                ->where("bedroom" , 2)
                                ->where("for_sale" , 1)
                                ->count();

        $conditionFive = Property::where("status_id" , $inactiveStatusId)
            ->where("property_type" , $housePropertyTypeId)
            ->where("for_rent" , 1)
            ->whereIn("region_id" , $fourthRegionArray)
            ->get();


        if(sizeof($conditionFive) > 0){
            foreach ($conditionFive as $five){
                DB::table('properties')
                    ->where('id', $five->id)
                    ->update(['for_rent' => 0]);
            }
        }

        $countConditionFive = Property::where("status_id" , $inactiveStatusId)
            ->where("property_type" , $housePropertyTypeId)
            ->where("for_rent" , 1)
            ->whereIn("region_id" , $fourthRegionArray)
            ->count();

        echo $countConditionFour."\n";
        echo $countConditionFive."\n";


    }/*end of function generateDummyData*/

    /**
     * @param array [id => integer, name => string, created_at => datetime|null, updated_at => datetime|null] $statuses
     * @return integer
     */
    public static function getActiveStatusId( $statuses )
    {
        foreach ( $statuses as $number => $status ) {
            if( $status->name === "Active" ){
                return $status->id;
            }
        }
    }

    /**
     * @param array [id => integer, name => string, created_at => datetime|null, updated_at => datetime|null] $propertyTypes
     * @return string
     */
    public static function getPropertyTypeCondoId( $propertyTypes )
    {
        foreach ($propertyTypes as $propertyType){
            if($propertyType->name === "Condo"){
                return $propertyType->id;
            }
        }
    }

    /**
     * @param array [id => integer, name => string, created_at => datetime|null, updated_at => datetime|null][] $propertyTypes
     * @return string
     */
    public static function getPropertyTypeHouseId( $propertyTypes )
    {
        foreach ( $propertyTypes as $propertyType )
        {
            if( $propertyType->name === "House" ){
                return $propertyType->id;
            }
        }
    }

    /**
     * @param array [id => integer, name => string, country => obj, created_at => datetime|null, updated_at => datetime|null] $regions
     * @param integer $countryId
     * @return array
     */
    public static function getRegion4Id($regions)
    {
        $regionList = array();
        foreach ( $regions as $region )
        {
            if( $region->name === "Region 4")
            {
               $regionList[] = $region->id;
            }
        }
        return $regionList;
    }

    /**
     * @param array [id => integer, name => string, created_at => datetime|null, updated_at => datetime|null] $statuses
     * @return integer
     */
    public static function getInactiveStatusId( $statuses )
    {
        foreach ( $statuses as $number => $status )
        {
            if( $status->name === "Inactive" )
            {
                return $status->id;
            }
        }
    }


    /**
     * @param array [id => integer, name => string, created_at => datetime|null, updated_at => datetime|null] $propertyTypes
     * @return array
     */
    public static function getNotPropertyCondo ($propertyTypes)
    {
        $result = array();
        foreach($propertyTypes as $propertyType){
            if($propertyType->name !== "Condo") $result[] = $propertyType->id;
        }
        return $result;
    }

    /**
     * @return integer
     */
    public static function notTwoBedroom(){

        do{
            $number = rand(1 , 10);
        }while($number == 2);

        return $number;
    }
}
