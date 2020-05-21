<?php

namespace Tests\Unit;

use App\Property;
use Carbon\Carbon;
use Tests\BaseTestCase;

class PropertyTest extends BaseTestCase
{

    public function testGetImageAttribute()
    {
        $model = new Property;
        $model->image_full = 'test.jpg';
        $image = '/images/test.jpg';
        $this->assertEquals($image, $model->image);
    }

    public function testGetMapLinkAttribute()
    {
        $model = new Property;
        $model->longitude = 1;
        $model->latitude = 2;
        $this->app['config']['estate.map_link'] = 'http://test.com/';
        $this->assertEquals('http://test.com/2,1', $model->mapLink);
    }

    public function testGetNameAttribute()
    {
        $model = new Property;
        $model->town = 'Moscow';
        $this->assertEquals('Moscow', $model->name);
    }

    public function testGetFullAddressAttribute()
    {
        $model = new Property;
        $model->town = 'London';
        $model->address = '11 str';
        $model->country = 'Uk';
        $model->postcode = '123';
        $this->assertEquals('11 str, London 123 Uk', $model->full_address);
    }

    public function testHasExpired()
    {
        $model = new Property;
        $model->last_modified = null;
        $data['last_modified'] = Carbon::tomorrow()->toDateTimeString();
        $this->assertTrue($model->hasExpired($data));
    }

    public function testGetThumbnailAttribute()
    {
        $model = new Property;
        $model->image_thumbnail = 'test.jpg';
        $image = '/images/test.jpg';
        $this->assertEquals($image, $model->thumbnail);
    }

    public function testNeedsUpdate()
    {
        $model = new Property;
        $model->is_locked = 0;
        $model->last_modified = null;
        $data['last_modified'] = Carbon::tomorrow()->toDateTimeString();
        $this->assertTrue($model->needsUpdate($data));
        $model->is_locked = 1;
        $this->assertNotTrue($model->needsUpdate($data));
    }
}
