<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as [$plan, $price, $stripe_price_Id, $valid_until, $availability, $support]) {
            $subscription = new Subscription();
            $subscription->setPlan($plan);
            $subscription->setPrice($price);
            $subscription->setStripePriceId($stripe_price_Id);
            $subscription->setValidUntil($valid_until);
            $subscription->setAvailability($availability);
            $subscription->setSupport($support);

//            $user = $manager->getRepository(User::class)->find($user_id);
//            $subscription->setUser($user);

            $manager->persist($subscription);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            // data = [$plan, $price, $stripe_price_Id, $valid_until, $availability, $support]
            ['basic', 0, 'price_1Jr7rNChbjQY7PCSCR1Ofm7E', '7 days', 'limited', 'limited support'],
            ['premium', 24.99, 'price_1Jr7rNChbjQY7PCSCR1Ofm7E', '1 month', 'lifetime', '24/7 Support'],
            ['cinematic', 39.99, 'price_1Jr7sLChbjQY7PCSFwBO3q9Z', '2 months', 'lifetime', '24/7 Support'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
