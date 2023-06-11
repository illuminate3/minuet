<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Throwable;

class CategoryFixtures extends Fixture
{

    public function __construct(private ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {

        $finder = new Finder();
        $finder->in( $this->params->get('kernel.project_dir') . '/data');
        $finder->name('*.sql');
        $finder->files();
        $finder->sortByName();

        /* @var EntityManagerInterface $manager */
        $connection = $manager->getConnection();

        foreach ($finder as $file) {
            echo "      Importing: {$file->getBasename()} " . PHP_EOL;

            $sql = $file->getContents();

            try {
                $connection->beginTransaction();
                $connection->executeQuery($sql);  // Execute native SQL
                $manager->flush();
            } catch (Throwable $e) {
                $connection->rollBack();
            }

        }

        $this->setCategoryReference($manager);
    }

    private function setCategoryReference($manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();
        foreach ($categories as $category) {
            $this->addReference('category-' . $category->getID(), $category);
        }

        $manager->flush();
    }

}

