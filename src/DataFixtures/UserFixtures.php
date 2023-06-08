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
// create a new user object
            $user = new User();
// set profile
            $user->setProfile(
                (new Profile())
                    ->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setPhone($phone)
            );
// set password
            $user->setPassword($password);
// set verified, account
            $user->setIsVerified($verified);
            $user->setIsAccount($is_account);
// set email
            $user->setEmail($email);
            $user->setEmailVerifiedAt(new DateTime('now'));
// set roles
            $user = $this->transformer->transform($user);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($lastName, $user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
#       ROLE_ADMIN, ROLE_USER, ROLE_DEALER, ROLE_BUYER, ROLE_STAFF
        return [
            // data = [$firstName, $lastName, $password, $verified, $is_account, $phone, $email, $roles]
            
            ['Admin', 'Admin', 'admin', true, true, '(123)555-1111', 'admin@admin.com', ['ROLE_ADMIN', 'ROLE_USER']],
            ['Dealer2', 'Dealer2', 'test', true, true, '(456)555-2222', 'dealer2@test.com', ['ROLE_DEALER']],
            ['Dealer3', 'Dealer3', 'test', true, true, '(456)555-3333', 'dealer3@test.com', ['ROLE_DEALER']],
            ['Staff4', 'Staff4', 'test', true, true, '(456)555-4444', 'staff4@test.com', ['ROLE_STAFF']],
            ['Staff5', 'Staff5', 'test', true, true, '(456)555-5555', 'staff5@test.com', ['ROLE_STAFF']],
            ['Buyer5', 'Buyer5', 'test', true, true, '(456)555-6666', 'buyer5@test.com', ['ROLE_BUYER']],
            ['Buyer6', 'Buyer6', 'test', true, false, '(456)555-7777', 'buyer6@test.com', ['ROLE_BUYER']],
            ['Admin', 'Super', 'secret', true, true, '(123)555-1234', 'superadmin@minuet.com', ['ROLE_SUPER','ROLE_ADMIN','ROLE_USER']],
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
