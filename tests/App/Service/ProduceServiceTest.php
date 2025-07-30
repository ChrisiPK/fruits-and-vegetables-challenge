<?php

namespace App\Tests\App\Service;

use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Service\ProduceService;
use App\Service\WeightConversionService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use ValueError;

class ProduceServiceTest extends TestCase
{
    private WeightConversionService $conversion;

    public function setUp(): void
    {
        $conversionMock = $this->getMockBuilder(WeightConversionService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['convert'])
            ->getMock();
        $conversionMock->method('convert')->willReturn(0);
        $this->conversion = $conversionMock;
    }

    /**
     * @dataProvider dataProviderValidProduce
     */
    public function testValidProduce(array $input, string $expectedClass)
    {
        $manager = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->onlyMethods(['persist', 'flush'])->getMock();

        $manager->expects($this->exactly(1))
            ->method('persist')
            ->with($this->callback(fn($val): bool => get_class($val) === $expectedClass));

        $manager->expects($this->exactly(1))
            ->method('flush');

        $subject = new ProduceService($manager, $this->conversion);

        $subject->loadProduceData([$input]);
    }

    public function dataProviderValidProduce(): array
    {
        return [
            [
                [
                    "id" => 1,
                    "name" => "Carrot",
                    "type" => "vegetable",
                    "quantity" => 10922,
                    "unit" => "g"
                ],
                Vegetable::class
            ],
            [
                [
                    "id" => 2,
                    "name" => "Apples",
                    "type" => "fruit",
                    "quantity" => 20,
                    "unit" => "kg"
                ],
                Fruit::class
            ]
        ];
    }

    /**
     * @dataProvider dataProviderInvalidProduce
     */
    public function testInvalidProduce(array $input)
    {
        $manager = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->onlyMethods(['persist', 'flush'])->getMock();

        $manager->expects($this->never())->method('persist');
        $manager->expects($this->never())->method('flush');

        $this->expectException(ValueError::class);

        $subject = new ProduceService($manager, $this->conversion);

        $subject->loadProduceData([$input]);
    }

    public function dataProviderInvalidProduce()
    {
        return [
            [[]],
            [[
                // missing unit field
                "id" => 2,
                "name" => "Apples",
                "type" => "fruit",
                "quantity" => 20,
            ]]
        ];
    }
}
