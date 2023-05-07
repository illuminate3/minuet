<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\MakeModelRepository;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:category',
    description: 'load categories',
)]
final class CreateCategoryCommand extends Command
{
    private MakeModelRepository $data;
    private CategoryRepository $category;
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $entityManager,
        MakeModelRepository $dataRepository,
        CategoryRepository $categoryRepository,
) {
        parent::__construct();
        $this->em = $entityManager;
        $this->data = $dataRepository;
        $this->category = $categoryRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $makes = $this->data->findAllUniqueMake();

        foreach ($makes as $parent_data) {
            $name = $parent_data['make'];

            $parent_data = new Category();
            $parent_data->setName($name);
            $parent_data->setParent(null);
            $parent_data->setSlug(Slugger::slugify($name));

            $this->em->persist($parent_data);
            $this->em->flush();

            $this->loadModels($name);
        }

        return Command::SUCCESS;
    }

    private function loadModels($name): void
    {
        $models = $this->data->findAllUniqueModel($name);
        foreach ($models as $child_data) {
            $child_name = $child_data['model'];
            $set_parent = $this->category->findOneBy(['name' => $name]);

            $child_data = new Category();
            $child_data->setName($child_name);
            $child_data->setParent($set_parent);
            $slug = $name.'-'.$child_name;
            $child_data->setSlug(Slugger::slugify($slug));

            $this->em->persist($child_data);
        }
        $this->em->flush();
    }
}
