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
        foreach ($this->getUserData() as [$firstName, $lastName, $username, $phone, $email, $roles]) {
            $user = new User();
            $user->setPassword($username);
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setProfile(
                (new Profile())
                    ->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setPhone($phone)
            );
            $user->setEmailVerifiedAt(new \DateTime('now'));
            $user = $this->transformer->transform($user);
            $manager->persist($user);
            $this->addReference($username, $user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['Magna', 'Aliqua', 'admin', '(123)555-1234', 'admin@admin.com', ['ROLE_ADMIN', 'ROLE_USER']],
            ['Cillum', 'Dolore', 'user', '(456)555-1212', 'user@user.com', ['ROLE_USER']],
        ];
    }
}
