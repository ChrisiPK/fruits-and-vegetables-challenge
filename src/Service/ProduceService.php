<?php

namespace App\Service;

use App\Entity\Fruit;
use App\Entity\Vegetable;
use Doctrine\ORM\EntityManagerInterface;
use ValueError;

class ProduceService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private WeightConversionService $conversion
    ) {}

    public function loadProduceData(array $data): int
    {
        $entries = 0;

        foreach ($data as $entry) {
            $sanitized = $this->sanitizeEntry($entry);

            switch ($sanitized['type']) {
                case 'fruit':
                    $entity = new Fruit();
                    break;
                case 'vegetable':
                    $entity = new Vegetable();
                    break;
                default:
                    throw new ValueError('Invalid entry: ' . var_export($entry));
            }

            $entity
                ->setId($sanitized['id'])
                ->setName($sanitized['name'])
                ->setQuantity($this->conversion->convert($sanitized['quantity'], $sanitized['unit'], 'g'));

            $this->manager->persist($entity);
            $entries++;
        }

        $this->manager->flush();

        return $entries;
    }

    private function sanitizeEntry(array $entry): array
    {
        $template = [
            'id' => '',
            'name' => '',
            'type' => '',
            'quantity' => '',
            'unit' => ''
        ];

        $sanitizedEntry = array_intersect_key($entry, $template);

        if (count($sanitizedEntry) !== count($template)) {
            throw new ValueError('Invalid entry: ' . var_export($entry));
        }

        return $sanitizedEntry;
    }
}
