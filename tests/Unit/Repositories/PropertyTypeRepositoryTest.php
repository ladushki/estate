<?php

namespace Tests\Unit\Repositories;

use App\PropertyType;
use App\Repositories\PropertyTypeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyTypeRepositoryTest extends \Tests\TestCase
{
    use RefreshDatabase;

    public function testAll(): void
    {
        $types = factory(PropertyType::class, 3)->make();
        $types->each(function ($type) {
            $type->save();
        });
        $repository = new PropertyTypeRepository((new PropertyType));
        $result = $repository->all();
        $this->assertDatabaseCount('property_types', 3);
        $this->assertEquals(3, count($result));
    }

    public function testSave()
    {
        $type = factory(PropertyType::class )->make(['id'=>1]);
        $data = $type->toArray();
        $repository = new PropertyTypeRepository((new PropertyType));
        $result = $repository->save($data);
        $this->assertDatabaseHas('property_types', $data);
    }

    public function testGetList()
    {
        $types = factory(PropertyType::class, 3)->make();
        $types->each(function ($type) {
            $type->save();
        });
        $repository = new PropertyTypeRepository((new PropertyType));
        $result = $repository->getList();
        $this->assertIsObject($result);
        $this->assertEquals(3, $result->count());
    }
}
