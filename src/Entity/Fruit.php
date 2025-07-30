<?php

namespace App\Entity;

use App\Entity\Produce as EntityProduce;
use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit extends EntityProduce
{

}
