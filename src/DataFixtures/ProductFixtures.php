<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('en_US');

        for ($prod = 1; $prod <= 10; ++$prod) {
            $product = new Product();
            $product->setTitle($faker->text(15));
            $product->setDescription($faker->text());
//            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $name = mb_strtolower($product->getTitle());
            $product->setSlug(Slugger::slugify($name));
            $product->setPrice($faker->numberBetween(900, 150000));
//            $product->setStock($faker->numberBetween(0, 10));

            // On va chercher une référence de catégorie
            $category = $this->getReference('cat-'.random_int(1, 8));
            $product->setCategory($category);

            $this->setReference('prod-'.$prod, $product);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
