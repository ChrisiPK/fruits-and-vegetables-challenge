<?php

namespace App\Tests\App\Service;

use App\Service\WeightConversionService;
use PHPUnit\Framework\TestCase;
use ValueError;

class WeightConversionServiceTest extends TestCase
{
    private WeightConversionService $subject;

    public function setUp(): void {
        $this->subject = new WeightConversionService();
    }

    /**
     * @dataProvider dataProviderValidConversion
     */
    public function testConvertGramsToKilograms($testValue, $unitFrom, $unitTo, $expected): void
    {
        $this->assertSame($expected, $this->subject->convert($testValue, $unitFrom, $unitTo));
    }

    public function dataProviderValidConversion()
    {
        return [
            [0, "kg", "kg", 0],
            [0, "g", "g", 0],
            [1, "kg", "g", 1000],
            [1, "g", "kg", 0],
            [1234567, "g", "kg", 1234],
            [1234, "kg", "g", 1234000],
            [PHP_INT_MAX, "g", "kg", intdiv(PHP_INT_MAX, 1000)],
            [PHP_INT_MIN, "g", "kg", intdiv(PHP_INT_MIN, 1000)]
        ];
    }

    /**
     * @dataProvider dataProviderInvalidConversion
     */
    public function testInvalidConversion($testValue, $unitFrom, $unitTo): void
    {
        $this->expectException(ValueError::class);
        $this->subject->convert($testValue, $unitFrom, $unitTo);
    }

    public function dataProviderInvalidConversion() {
        return [
            [0, "mi", "km"],
            [PHP_INT_MAX, "kg", "g"],
            [PHP_INT_MIN, "kg", "g"]
        ];
    }
}
