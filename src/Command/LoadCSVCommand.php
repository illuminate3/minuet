<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\MakeModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use function is_array;

#[AsCommand(
    name: 'app:load-csv',
    description: 'Load CSV data into Database',
)]
final class LoadCSVCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private ParameterBagInterface $params;

    public function __construct(
        ParameterBagInterface $params,
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
        $this->params = $params;
        $this->entityManager = $entityManager;
    }

    /**
     * execute
     *
     * @param  InputInterface   $input
     * @param  OutputInterface  $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $this->params->get('kernel.project_dir');
        $path .= '/data';

        $files = preg_grep('/^([^.])/', scandir($path));

        foreach ($files as $file) {
            $csv = fopen($path . '/' . $file, 'rb');

            while (!feof($csv)) {
                $line = fgetcsv($csv);

                if (is_array($line) && ($line[0] !== 'year')) {
//                year,make,model,body_styles
                    $data = new MakeModel();

                    $data->setYear($line[0]);
                    $data->setMake($line[1]);
                    $data->setModel($line[2]);
                    $data->setBodyStyle($line[3]);

                    $this->entityManager->persist($data);
                }
            }

            fclose($csv);

            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }
}
