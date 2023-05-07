<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    private int $counter = 1;
    private SluggerInterface $slugger;

    public function __construct(private ParameterBagInterface $params)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // This will load generic categories
        // uncomment and comment out the lines below to use these.
        // Change needs to be made in the ProductFixtures too
//        $parent = $this->createCategory('Computers', $manager, null);
//
//        $this->createCategory('laptop', $manager, $parent);
//        $this->createCategory('monitor', $manager, $parent);
//        $this->createCategory('mouse', $manager, $parent);
//
//        $parent = $this->createCategory('Fashion', $manager, null);
//
//        $this->createCategory('men', $manager, $parent);
//        $this->createCategory('women', $manager, $parent);
//        $this->createCategory('child', $manager, $parent);
//
//        $manager->flush();

        // This imports the categories from a sql file
        // comment out these lines and uncomment the lines above to use the generic ones
        // Change needs to be made in the ProductFixtures too
        $path = $this->params->get('kernel.project_dir');
        $file_make = $path.'/data/make.sql';

        $sql = file_get_contents($file_make);
        $manager->getConnection()->exec($sql);
        $manager->flush();

        $file_category = $path.'/data/category.sql';

        $sql = file_get_contents($file_category);
        $manager->getConnection()->exec($sql);

        $this->setCategoryReference($manager);
    }

    private function createCategory(string $name, $manager, Category $parent = null)
    {
        $category = new Category();
        $category->setName($name);
        $category->setCategoryOrder($this->counter);
//        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $name = mb_strtolower($category->getName());
        $category->setSlug(Slugger::slugify($name));
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('category-'.$this->counter, $category);
        ++$this->counter;

        return $category;
    }

    private function setCategoryReference($manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();
        foreach ($categories as $category) {
            $this->addReference('category-'.$category->getID(), $category);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
