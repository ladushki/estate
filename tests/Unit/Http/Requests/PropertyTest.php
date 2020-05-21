<?php

namespace Tests\Unit\Http\Requests;

use Tests\BaseTestCase;
use App\Http\Requests\Property;


class PropertyTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->validator = $this->app->get('validator');
        $this->rules = (new Property())->rules();
    }

    /** @test */
    public function valid_address()
    {
        $this->assertTrue($this->validateField('address', 'jon'));
        $this->assertFalse($this->validateField('address', ''));
        $this->assertFalse($this->validateField('address', 'jo'));
        $this->assertFalse($this->validateField('address', 'j'));
        $this->assertFalse($this->validateField('address', 1));
        $this->assertTrue($this->validateField('address', 'jon1'));
    }

    /** @test */
    public function valid_town()
    {
        $this->assertTrue($this->validateField('town', 'jon'));
        $this->assertFalse($this->validateField('town', ''));
        $this->assertFalse($this->validateField('town', 1111));
        $this->assertTrue($this->validateField('town', 'jon1'));
    }

    protected function getFieldValidator($field, $value)
    {
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        );
    }

    protected function validateField($field, $value)
    {
        return $this->getFieldValidator($field, $value)->passes();
    }
}
