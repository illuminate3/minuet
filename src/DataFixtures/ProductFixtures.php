<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductDetails;
use App\Utils\Slugger;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private int $counter = 1;

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('en_US');

        $account1 = $this->getReference('account-1');
        $account2 = $this->getReference('account-2');

        for ($prod = 1; $prod <= 10; ++$prod) {
            $product = new Product();
//            $product->setTitle($faker->text(15));
            $product->setTitle('Product ' . $prod);
            $product->setDescription($faker->text());
//            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $title = mb_strtolower($product->getTitle());
            $product->setSlug(Slugger::slugify($title));
            $product->setPrice($faker->numberBetween(900, 150000));
//            $product->setStock($faker->numberBetween(0, 10));
            $product->setCreatedAt(new DateTimeImmutable('now'));


//            // ProductDetails
//            $productDetail = new ProductDetails($product);


            // Category
            $category = $this->getReference('category-' . random_int(1, 8));
            $product->setCategory($category);


            // Account
            if ($this->counter <= 7) {
                $product->setAccount($account1);
            } else {
                $product->setAccount($account2);
            }

            $this->setReference('product-' . $prod, $product);
            $manager->persist($product);
            ++$this->counter;
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
            AccountUserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
