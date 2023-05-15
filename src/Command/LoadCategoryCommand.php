<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:load-categories',
    description: 'load categories',
)]
final class LoadCategoryCommand extends Command
{
    private ParameterBagInterface $params;
    private EntityManagerInterface $em;

    public function __construct(
        ParameterBagInterface $params,
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
        $this->params = $params;
        $this->em = $entityManager;
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $this->params->get('kernel.project_dir');
        $file_category = $path . '/data/category.sql';

        $sql = file_get_contents($file_category);
        $this->em->getConnection()->executeQuery($sql);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
