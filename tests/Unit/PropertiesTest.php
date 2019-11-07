<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PropertiesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

    }

    public function testConditionOne()
    {
        $countProject = Project::all()->count();
        $this->assertSame(10000 , $countProject);
    }

    public function testConditionTwo()
    {
        $countProperty = Property::all()->count();
        $this->assertSame(100000 , $countProperty);
    }

    public function testConditionThree()
    {
        $projects = Project::all();
        $actual = 0;
        foreach ($projects as $project){
            $countProperty = Property::where("project_id" , $project->id)->count();
            if($countProperty === 2001){
                $actual = $countProperty;
                break;
            }
        }
        $this->assertSame(2001 , $actual);

    }

    public function testConditionFour()
    {
        $countProperty = Property::getConditionFour();
        $this->assertSame(3000 , $countProperty);
    }

    public function testConditionFive()
    {
        $countProperty = Property::getConditionFive();
        $this->assertSame(0 , $countProperty);
    }


}
