<?php

namespace Tests\Unit\Repositories;

use App\Property;
use App\PropertyType;
use App\Repositories\PropertyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyRepositoryTest extends \Tests\TestCase
{

    use RefreshDatabase;

    public function testCreate()
    {
        $type = factory(PropertyType::class)->make();
        $type->save();
        $data = factory(Property::class)->make(
            ['property_type_id' => $type->id]
        );

        $repository = new PropertyRepository(new Property);
        $repository->create($data->toArray());
        $array = $data->toArray();
        unset($array['last_modified']);

        $this->assertDatabaseHas('properties',$array);
    }

    public function testAll()
    {
        $this->saveProperties();
        $repository = new PropertyRepository(new Property);
        $result = $repository->all();
        $this->assertDatabaseCount('properties', 12);
        $this->assertEquals(12, count($result));
    }

    public function testUpdate()
    {
        $type = factory(PropertyType::class)->make();
        $type->save();
        $data = factory(Property::class)->make(
            ['property_type_id' => $type->id]
        );
        $data->save();
        $repository = new PropertyRepository(new Property);
        $repository->update(['town'=>'Tomsk'], $data->uuid);

        $this->assertDatabaseHas('properties', ['town'=>'Tomsk']);
    }

    public function testShow()
    {
        $type = factory(PropertyType::class)->make(['title'=>'Flat']);
        $type->save();
        $data = factory(Property::class)->make(
            ['property_type_id' => $type->id, 'town'=>'Tomsk']
        );
        $data->save();
        $repository = new PropertyRepository(new Property);
        $result = $repository->show($data->uuid);
        $this->assertEquals('Tomsk', $result->town);
        $this->assertEquals('Flat', $result->propertyType->title);

    }

    /**
     * @return \App\Property[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function saveProperties()
    {
        factory(PropertyType::class, 6)->create()->each(function ($type) {
            $type->properties()->save(factory(Property::class)->make());
            $type->properties()->save(factory(Property::class)->make());
        });

    }
}
