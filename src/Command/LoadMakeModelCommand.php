<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:load-make-model',
    description: 'load makes and models',
)]
final class LoadMakeModelCommand extends Command
{
    private EntityManagerInterface $em;
    private ParameterBagInterface $params;

    public function __construct(
        ParameterBagInterface $params,
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
        $this->params = $params;
        $this->em = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $this->params->get('kernel.project_dir');
        $file_makes = $path . '/data/make.sql';

        $sql = file_get_contents($file_makes);
        $this->em->getConnection()->exec($sql);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
