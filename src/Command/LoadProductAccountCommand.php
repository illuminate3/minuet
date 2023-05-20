<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\AccountRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:load-product-account',
    description: 'load product account',
)]
final class LoadProductAccountCommand extends Command
{
    private ProductRepository $products;
    private AccountRepository $accounts;
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $entityManager,
        AccountRepository $accounts,
        ProductRepository $products,
) {
        parent::__construct();
        $this->em = $entityManager;
        $this->accounts = $accounts;
        $this->products = $products;
    }

    /**
     * @param  InputInterface   $input
     * @param  OutputInterface  $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $account1 = $this->accounts->find(1);
        $account2 = $this->accounts->find(2);
        $products = $this->products->findAll();

        foreach ($products as $product) {
            if ($product->getId() > 7) {
                $product->setAccount($account1);
            } else {
                $product->setAccount($account2);
            }

            $this->em->persist($product);
        }

        $this->em->flush();

        return Command::SUCCESS;
    }
}
