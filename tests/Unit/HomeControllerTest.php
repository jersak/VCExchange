<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    public function testFunctionsExistence()
    {
        $this->assertTrue(method_exists(\App\Http\Controllers\HomeController::class, '__construct'));
        $this->assertTrue(method_exists(\App\Http\Controllers\HomeController::class, 'index'));
        $this->assertFalse(method_exists(\App\Http\Controllers\HomeController::class, 'myFunction'));
    }
}
