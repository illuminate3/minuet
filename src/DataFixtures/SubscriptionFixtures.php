<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{

    /**
     * @param  ObjectManager  $manager
     *
     * @return void
     */
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

    /**
     * @return array[]
     */
    private function getData(): array
    {
        return [
            // data = [$plan, $price, $stripe_price_Id, $valid_until, $availability, $support]
            ['basic', 0, 'price_1N1LrhHxcL7TQhSHcRcfL89i', '7 days', 'limited', 'limited support'],
            ['premium', 24.99, 'price_1N1LtDHxcL7TQhSHA7lHKgjk', '1 month', 'lifetime', '24/7 Support'],
            ['cinematic', 39.99, 'price_1N1LtuHxcL7TQhSHhp6oIzuQ', '2 months', 'lifetime', '24/7 Support'],
        ];
    }

}
