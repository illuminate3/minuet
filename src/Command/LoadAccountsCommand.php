<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Account;
use App\Entity\AccountUser;
use App\Repository\ProductRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:load-accounts',
    description: 'load accounts',
)]
final class LoadAccountsCommand extends Command
{
    private UserRepository $users;
    private ProductRepository $products;
    private SubscriptionRepository $subscriptions;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $users,
        ProductRepository $products,
        SubscriptionRepository $subscriptionRepository,
) {
        parent::__construct();
        $this->em = $entityManager;
        $this->users = $users;
        $this->products = $products;
        $this->subscriptions = $subscriptionRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->users->find(3);
        $subscription = $this->subscriptions->findOneBy(['id' => 1]);

        $account = new Account();
        $account->setName('account demo Two 2 Two');
        $account->setPrimaryUser(2);
        $account->setSubscription($subscription);
        $this->em->persist($account);

        $this->em->flush();

        $account = new Account();
        $account->setName('account demo Three 3 three');
        $account->setPrimaryUser(3);
        $account->setSubscription($subscription);
        $this->em->persist($account);

        $this->em->flush();


        foreach ($this->getAccountUserData() as [$userID]) {
            $user = $this->users->find($userID);
            $accountUser = new AccountUser();
            $accountUser->setAccount($account);
            $accountUser->setUser($user);
            $this->em->persist($accountUser);
        }
        $this->em->flush();

        return Command::SUCCESS;
    }

    private function getAccountUserData(): array
    {
        return [
            [3],
            [4],
            [5],
        ];
    }
}
