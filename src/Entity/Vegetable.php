<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produce as Produce;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Vegetable extends Produce
{

}
