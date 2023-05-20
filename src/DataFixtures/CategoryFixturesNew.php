<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

// class CategoryFixtures extends Fixture implements DependentFixtureInterface
class CategoryFixturesNew extends Fixture
{
    private int $counter = 1;

    public function __construct(private ParameterBagInterface $params)
    {
        $this->params = $params;
    }

//    public function getDependencies(): array
//    {
//        return [
//            ProductFixtures::class,
//        ];
//    }

    public function load(ObjectManager $manager): void
    {
//        $csv = $this->getData();
//        dd($csv);

//        foreach ($this->getData() as [$parent, $name, $slug]) {
//            print_r($name);
//            $category = new Category();
//            $category->setParent($parent);
//            $category->setName($name);
//            $category->setSlug($slug);
//
//            $manager->persist($category);
//
//            $this->addReference('category-'.$this->counter, $category);
//            ++$this->counter;
//            if ('NULL' === $parent) {
//                $this->createCategory($name, $slug, $manager, null);
//            }
//        }

//        $this->createCategory('Computers', 'category', $manager, null);
//        $manager->flush();

//        dd('here');

        // data = [$parent, $name, $slug]
    }

    private function createCategory(string $name, $slug, $manager, Category $parent = null): Category
    {
        $category = new Category();
        $category->setParent($parent);
        $category->setName($name);
        $category->setSlug($slug);
//        $this->createCategory('mouse', $manager, $parent);

        $this->addReference('category-' . $this->counter, $category);
        ++$this->counter;

        $manager->persist($category);

        return $category;
    }

    private function getData(): array
    {
        $path = $this->params->get('kernel.project_dir');
        $file_category = $path . '/data/category.csv';

//        $csv = str_getcsv(file_get_contents($file_category));

        $csv = [];
        $file = fopen($file_category, 'rb');

        while (($result = fgetcsv($file)) !== false) {
            $csv[] = $result;
        }

        fclose($file);

//        echo '<pre>';
//        print_r($csv);
//        echo '</pre>';

//        return [
//            [1, 'Account One - Primary User 2', 2],
//            [1, 'Account Two - Primary User 3', 3],
//        ];

        return $csv;
    }
}
