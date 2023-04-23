<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Thread;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ThreadFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
//        product_id
//        user_id
//        is_closed
//        is_pin
//        total_messages

        foreach ($this->getData() as [$user_id, $product_id]) {
            $user = $manager->getRepository(User::class)->findOneBy(['id' => $user_id]);
            $product = $manager->getRepository(Product::class)->findOneBy(['id' => $product_id]);

            $thread = new Thread();
            $thread->setUser($user);
            $thread->setProduct($product);
            $thread->setCreatedAt(new \DateTimeImmutable('now'));

            $manager->persist($thread);
        }

        $manager->flush();
    }

//        product_id
//        user_id
//        is_closed
//        is_pin
//        total_messages

    private function getData(): array
    {
        return [
            // data = [$user_id, $product_id]
            [4, 4],
//            [4, 5],
//            [4, 6],
        ];
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            UserFixtures::class,
        ];
    }
}
