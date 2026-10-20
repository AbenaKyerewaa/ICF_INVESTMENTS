<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_the_landing_page_displays_the_demo_boundary(): void
    {
        $response = $this->get(route('landing'));

        $response->assertOk();
        $response->assertSee('ICF Investment');
        $response->assertSee('DEMO / SIMULATED');
    }
}
