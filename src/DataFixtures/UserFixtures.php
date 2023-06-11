<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use App\Transformer\UserTransformer;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{
    public function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [
            $firstName, $lastName, $password, $verified, $is_account, $is_subscription_active, $phone, $email, $roles
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
// set verified, account, subscription_active(stripe), createdAt
            $user->setIsVerified($verified);
            $user->setIsAccount($is_account);
            $user->setIsSubscriptionActive($is_subscription_active);
            $user->setCreatedAt(new DateTimeImmutable('now'));
// set email
            $user->setEmail($email);
            $user->setEmailVerifiedAt(new DateTimeImmutable('now'));
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
#       ROLE_SUPER, ROLE_ADMIN, ROLE_USER, ROLE_DEALER, ROLE_STAFF
        return [
            // data = [$firstName, $lastName, $password, $verified, $is_account, $is_subscription_active, $phone, $email, $roles]
            ['Admin', 'Admin', 'admin', true, false, false, '(123)555-1111', 'admin@admin.com', ['ROLE_ADMIN']],
            ['Dealer2', 'Dealer2', 'test', true, true, false, '(456)555-2222', 'dealer2@test.com', ['ROLE_DEALER']],
            ['Dealer3', 'Dealer3', 'test', true, true, false, '(456)555-3333', 'dealer3@test.com', ['ROLE_DEALER']],
            ['Staff4', 'Staff4', 'test', true, true, false, '(456)555-4444', 'staff4@test.com', ['ROLE_STAFF']],
            ['Staff5', 'Staff5', 'test', true, true, false, '(456)555-5555', 'staff5@test.com', ['ROLE_STAFF']],
            ['Seller5', 'Seller5', 'test', true, true, false, '(456)555-6666', 'seller5@test.com', ['ROLE_USER']], // ROLE_SELLER - ROLE_BUYER
            ['Seller6', 'Seller6', 'test', true, false, false, '(456)555-7777', 'seller6@test.com', ['ROLE_USER']], // ROLE_SELLER - ROLE_BUYER
            ['Admin', 'Super', 'admin', true, false, false, '(123)555-1111', 'super@admin.com', ['ROLE_SUPER']],
            ['User1', 'User1', 'test', true, false, false, '(456)555-6666', 'user1@test.com', ['ROLE_USER']],
            ['User2', 'User2', 'test', true, false, false, '(456)555-7777', 'user2@test.com', ['ROLE_USER']],
        ];
    }

}
