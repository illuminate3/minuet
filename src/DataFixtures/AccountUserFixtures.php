<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\AccountUser;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountUserFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @param  ObjectManager  $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
//        $account_id
//        $user_id

        foreach ($this->getData() as [$account_id, $user_id]) {
            $account = $manager->getRepository(Account::class)->findOneBy(['id' => $account_id]);
            $user = $manager->getRepository(User::class)->findOneBy(['id' => $user_id]);

            $account_user = new AccountUser();
            $account_user->setAccount($account);
            $account_user->setUser($user);

            $manager->persist($account_user);
        }

        $manager->flush();
    }

//        $account_id
//        $user_id

    /**
     * @return array[]
     */
    private function getData(): array
    {
        return [
            // data = [$account_id, $user_id]
            [1, 2],
            [2, 3],
            [2, 4],
            [2, 5],
        ];
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
            UserFixtures::class,
        ];
    }

}
