<?php

namespace Tests\Unit;

use App\Multiplication;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;
use App\Calculator;
use App\Addition;
use App\Substract;

class CalculatorTest extends TestCase
{
    protected $calc;

    public function setUp(): void
    {
        $this->calc = new Calculator;
    }

    public function testResultDefaultsToZero()
    {
        $this->assertSame(0, $this->calc->getResult());
    }

    public function testAddsNumbers()
    {
        $mock = Mockery::mock('App\Addition');

        $mock->shouldReceive('run')
            ->once()
            ->with(5, 0)
            ->andReturn(5);

        $this->calc->setOperands(5);
        $this->calc->setOperation($mock);

        $result = $this->calc->calculate();

        $this->assertEquals(5, $result);
    }

    public function testRequiresNumericValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calc->setOperands('five');
        $this->calc->setOperation(new Addition);
        $result = $this->calc->calculate();
    }

    public function testAcceptsMultipleArgs()
    {
        $this->calc->setOperands(1, 2, 3, 4);

        $this->calc->setOperation(new Addition);

        $result = $this->calc->calculate();

        $this->assertEquals(10, $result);
    }

    public function testSubstract()
    {
        $this->calc->setOperands(4);
        $this->calc->setOperation(new Substract);
        $result = $this->calc->calculate();

        $this->assertEquals(-4, $result);
    }

    public function testMultipliesNumbers()
    {
        $this->calc->setOperands(3, 3, 3);
        $this->calc->setOperation(new Multiplication);
        $result = $this->calc->calculate();

        $this->assertEquals(27, $result);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
