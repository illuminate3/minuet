<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    private int $counter = 1;

    public function load(ObjectManager $manager): void
    {
//        $subscription_id
//        $name
//        $primary_user

        foreach ($this->getData() as [$subscription_id, $name, $primary_user]) {
            $subscription = $manager->getRepository(Subscription::class)->findOneBy(['id' => $subscription_id]);

            $account = new Account();
            $account->setSubscription($subscription);
            $account->setName($name);
            $account->setPrimaryUser($primary_user);

            $this->addReference('account-'.$this->counter, $account);
            ++$this->counter;

            $manager->persist($account);
        }

        $manager->flush();
    }

//        $subscription_id
//        $name
//        $primary_user

    private function getData(): array
    {
        return [
            // data = [$subscription_id, $name, $primary_user]
            [1, 'Account One - Primary User 2', 2],
            [1, 'Account Two - Primary User 3', 3],
        ];
    }

    public function getDependencies(): array
    {
        return [
            SubscriptionFixtures::class,
        ];
    }
}
