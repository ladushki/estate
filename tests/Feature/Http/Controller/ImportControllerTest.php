<?php

namespace Tests\Feature\Http\Controller;

use Tests\TestCase;

class ImportControllerTest extends TestCase
{


    /** @test */
    public function can_call_index()
    {
        $response = $this->call('get', '/import');
        $response->assertViewIs('import');
        $response->assertViewHas('result');
    }


    public function can_call_run()
    {
        //takes too long!
        $response = $this->call('get', '/import');
        $response->assertViewIs('import');
        $response->assertViewHas('result');
    }

}
