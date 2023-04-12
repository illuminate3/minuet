<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Account;
use App\Entity\AccountListing;
use App\Entity\AccountUser;
use App\Repository\ProductRepository;
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

    public function __construct(
        UserRepository $users,
        ProductRepository $products,
        EntityManagerInterface $entityManager
) {
        parent::__construct();
        $this->users = $users;
        $this->products = $products;
        $this->em = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->users->find(3);
        $account = new Account();
        $account->setUser($user);
        $account->setName('account demo test');
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

        foreach ($this->getAccountUserData() as [$productID]) {
            $products = $this->products->find($productID);
            $accountUser = new AccountListing();
            $accountUser->setAccount($account);
            $accountUser->setProduct($products);
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
