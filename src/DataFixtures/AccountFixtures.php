<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Subscription;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    private int $counter = 1;

    /**
     * @param  ObjectManager  $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
//        $subscription_id
//        $name
//        $primary_user

        foreach ($this->getData() as [$subscription_id, $name, $primary_user,$stripe_customer_id]) {
            $subscription = $manager->getRepository(Subscription::class)->findOneBy(['id' => $subscription_id]);

            $account = new Account();
            $account->setSubscription($subscription);
            $account->setStripeCustomerId($stripe_customer_id);
            $account->setCreatedAt(new DateTimeImmutable('now'));
            $account->setName($name);
            $account->setPrimaryUser($primary_user);

            $this->addReference('account-' . $this->counter, $account);
            ++$this->counter;

            $manager->persist($account);
        }

        $manager->flush();
    }

//        $subscription_id
//        $name
//        $primary_user


    /**
     * @return array[]
     */
    private function getData(): array
    {
        return [
            // data = [$subscription_id, $name, $primary_user]
            [1, 'Account One - Primary User 2', 2,'dummy_customer_id_1'],
            [1, 'Account Two - Primary User 3', 3,'dummy_customer_id_2'],
        ];
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            SubscriptionFixtures::class,
        ];
    }

}
