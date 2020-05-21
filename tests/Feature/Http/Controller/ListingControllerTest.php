<?php

namespace Tests\Feature\Http\Controller;

use App\Property;
use Tests\TestCase;
use App\PropertyType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListingControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_call_rent_listing()
    {
        $response = $this->call('GET', '/listing/rent');
        $response->assertViewIs('listing');
        $response->assertViewHas('properties');
    }

    /** @test */
    public function can_call_sale_listing()
    {
        $response = $this->call('GET', '/listing/sale');
        $response->assertViewIs('listing');
        $response->assertViewHas('properties');
    }

    /** @test */
    public function can_call_admin_show_no_id()
    {
        //takes too long!
        $response = $this->call('get', '/admin/show');
        $this->assertEquals(404, $response->getStatusCode());
    }

    /** @test */
    public function can_call_admin_edit()
    {
        $type = factory(PropertyType::class)->make();
        $type->save();
        $property = factory(Property::class)->make(['property_type_id' => $type->id]);
        $property->save();
        $response = $this->call('get', '/admin/edit/'.$property->uuid);
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewIs('admin.edit');
        $response->assertViewHas('item');
        $response->assertViewHas('form');
    }

    /** @test */
    public function can_call_admin_show()
    {
        $type = factory(PropertyType::class)->make();
        $type->save();
        $property = factory(Property::class)->make(['property_type_id' => $type->id]);
        $property->save();
        $response = $this->call('get', '/admin/show/'.$property->uuid);
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewIs('admin.show');
        $response->assertViewHas('item');
        $response->assertSeeText('Bedrooms');
    }


}
