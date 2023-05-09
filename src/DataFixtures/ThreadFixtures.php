<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Account;
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

        foreach ($this->getData() as [$user_id, $product_id, $account_id]) {
            $user = $manager->getRepository(User::class)->findOneBy(['id' => $user_id]);
            $product = $manager->getRepository(Product::class)->findOneBy(['id' => $product_id]);
            $account = $manager->getRepository(Account::class)->findOneBy(['id' => $account_id]);

            $thread = new Thread();
            $thread->setUser($user);
            $thread->setProduct($product);
            $thread->setAccount($account);
            $thread->setIsPin(true);
            $thread->setIsClosed(false);
            $thread->setTotalMessages(2);
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
            // data = [$user_id, $product_id, $account_id]
            [1, 1, 1],
            [6, 8, 2],
            [7, 8, 2],
            [6, 9, 2],
            [7, 10, 2],
        ];
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AccountFixtures::class,
            ProductFixtures::class,
        ];
    }
}
