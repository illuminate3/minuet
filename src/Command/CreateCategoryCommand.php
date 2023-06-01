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
        $makes = $this->data->findAllUniqueMake();

        foreach ($makes as $parentData) {
            $name = $parentData['make'];

            $parentData = new Category();
            $parentData->setName($name);
            $parentData->setParent(null);
            $parentData->setSlug(Slugger::slugify($name));

            $this->em->persist($parentData);
            $this->em->flush();

            $this->loadModels($name);
        }

        return Command::SUCCESS;
    }

    /**
     * loadModules
     *
     * @param $name
     *
     * @return void
     */
    private function loadModels($name): void
    {
        $models = $this->data->findAllUniqueModel($name);
        foreach ($models as $childData) {
            $childName = $childData['model'];
            $setParent = $this->category->findOneBy(['name' => $name]);

            $childData = new Category();
            $childData->setName($childName);
            $childData->setParent($setParent);
            $slug = $name . '-' . $childName;
            $childData->setSlug(Slugger::slugify($slug));

            $this->em->persist($childData);
        }
        $this->em->flush();
    }
}
