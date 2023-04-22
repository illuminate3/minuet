<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use App\Transformer\UserTransformer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{
    public function __construct(private UserTransformer $transformer)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$firstName, $lastName, $password, $verfied, $phone, $email, $roles]) {
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
            $user = $this->transformer->transform($user);
            $manager->persist($user);
            $this->addReference($lastName, $user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // data = [$firstName, $lastName, $password, $verfied, $phone, $email, $roles]
            ['Magna', 'Aliqua', 'admin', true, '(123)555-1234', 'admin@admin.com', ['ROLE_ADMIN', 'ROLE_USER']],
            ['Cillum', 'Dolore', 'user', true, '(456)555-1212', 'user@user.com', ['ROLE_USER']],
            ['Test1', 'User1', 'test', true, '(456)555-1212', 'test1@test.com', ['ROLE_USER']],
            ['Test2', 'User2', 'test', true, '(456)555-1212', 'test2@test.com', ['ROLE_USER']],
            ['Test3', 'User3', 'test', false, '(456)555-1212', 'test3@test.com', ['ROLE_USER']],
        ];
    }
}
