<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use App\Transformer\UserTransformer;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [
            $firstName, $lastName, $password, $verified, $is_account, $phone, $email, $roles
        ]) {
            $user = new User();
            $user->setPassword($password);
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setProfile(
                (new Profile())
                    ->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setPhone($phone)
            );
            $user->setEmailVerifiedAt(new DateTime('now'));
            $user->setIsVerified($verified);
            $user->setIsAccount($is_account);
            $user = $this->transformer->transform($user);
            $manager->persist($user);
            $this->addReference($lastName, $user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
#       ROLE_USER, ROLE_DEALER, ROLE_BUYER, ROLE_STAFF
        return [
            // data = [$firstName, $lastName, $password, $verified, $is_account, $phone, $email, $roles]
            ['Dealer1', 'Dealer1', 'admin', true, true, '(123)555-1111', 'dealer1test.com', ['ROLE_USER, ROLE_DEALER']],
            ['Dealer2', 'Dealer2', 'user', true, true, '(456)555-2222', 'dealer2@test.com', ['ROLE_USER, ROLE_DEALER']],
            ['Dealer3', 'Dealer3', 'test', true, true, '(456)555-3333', 'dealer3@test.com', ['ROLE_USER, ROLE_DEALER']],
            ['Staff4', 'Dealer3', 'test', true, true, '(456)555-3333', 'staff4@test.com', ['ROLE_USER, ROLE_STAFF']],
            ['Staff5', 'Dealer3', 'test', true, true, '(456)555-3333', 'staff5@test.com', ['ROLE_USER, ROLE_STAFF']],
            ['Buyer5', 'Buyer5', 'test', true, true, '(456)555-5555', 'buyer5@test.com', ['ROLE_USER, ROLE_BUYER']],
            ['Buyer6', 'Buyer6', 'test', true, false, '(456)555-6666', 'buyer6@test.com', ['ROLE_USER, ROLE_BUYER']],
        ];
    }

    public function getDependencies(): array
    {
        return [
            SettingsFixtures::class,
            PageFixtures::class,
            MenuFixtures::class,
        ];
    }
}
