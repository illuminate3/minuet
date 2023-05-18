<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
 use League\Csv\Reader;

#[AsCommand(
    name: 'app:load-category',
    description: 'Add a short description for your command',
)]
class LoadProductCategoryCommand extends Command
{
    // protected function configure(): void
    // {
    //     $this
    //         ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
    //         ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
    //     ;
    // }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

       

        // ...

        // $filePath = 'http://localhost:8000/us-car-models-data-master/1992.csv';

        // $csv = Reader::createFromPath($filePath, 'r');
        // $csv->setHeaderOffset(0);

        // foreach ($csv as $row) {
        //     // $row is an associative array that represents a row in the CSV file
        //     $column1Value = $row['column1'];
        //     $column2Value = $row['column2'];
        //     // ...
        // }
            
        function csvToArray($csvFile){
            $file_to_read = fopen($csvFile, 'r');
            while (!feof($file_to_read) ) {
                $lines[] = fgetcsv($file_to_read, 1000, ',');
            }
            fclose($file_to_read);
            return $lines;
        }
        //read the csv file into an array 
        $csvFile = 'http://localhost:8000/us-car-models-data-master/1992.csv';
        $csv = csvToArray($csvFile);
        //render the array with print_r 
        echo '<pre>';
        print_r($csv);


        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
