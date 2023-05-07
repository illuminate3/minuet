<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use App\Transformer\UserTransformer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserTransformer $transformer)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$firstName, $lastName, $password, $verfied, $is_accocunt, $phone, $email, $roles]) {
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
            $user->setEmailVerifiedAt(new \DateTime('now'));
            $user->setIsVerified($verfied);
            $user->setIsAccount($is_accocunt);
            $user = $this->transformer->transform($user);
            $manager->persist($user);
            $this->addReference($lastName, $user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // data = [$firstName, $lastName, $password, $verfied, $is_accocunt, $phone, $email, $roles]
            ['Magna', 'Aliqua', 'admin', true, true, '(123)555-1234', 'admin@admin.com', ['ROLE_ADMIN', 'ROLE_USER']],
            ['Cillum', 'Dolore', 'user', true, true, '(456)555-1212', 'user@user.com', ['ROLE_USER']],
            ['Test1', 'User1', 'test', true, true, '(456)555-1212', 'test1@test.com', ['ROLE_USER']],
            ['Test2', 'User2', 'test', true, true, '(456)555-1212', 'test2@test.com', ['ROLE_USER']],
            ['Test3', 'User3', 'test', true, true, '(456)555-1212', 'test3@test.com', ['ROLE_USER']],
            ['Test4', 'User4', 'test', true, true, '(456)555-1212', 'test4@test.com', ['ROLE_USER']],
            ['Test5', 'User5', 'test', true, true, '(456)555-1212', 'test5@test.com', ['ROLE_USER']],
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
