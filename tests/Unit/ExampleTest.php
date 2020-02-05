<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    public function testGeneratesAnchorTag()
    {
        $actual = link_to('dogs/1', 'Show Dog');
        $expect = "<a href='http://drive/dogs/1'>Show Dog</a>";

        $this->assertEquals($expect, $actual);
    }

    public function testAppliesAttributesUsingArray()
    {
        $actual = link_to('/dogs/1', 'Show Dog', ['class' => 'button']);
        $expect = "<a href='http://drive/dogs/1' class='button'>Show Dog</a>";

        $this->assertEquals($expect, $actual);
    }
}
