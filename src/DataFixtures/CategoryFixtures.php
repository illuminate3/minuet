<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Computers', null, $manager);

        $this->createCategory('laptop', $parent, $manager);
        $this->createCategory('monitor', $parent, $manager);
        $this->createCategory('mouse', $parent, $manager);

        $parent = $this->createCategory('Fashion', null, $manager);

        $this->createCategory('men', $parent, $manager);
        $this->createCategory('women', $parent, $manager);
        $this->createCategory('child', $parent, $manager);

        $manager->flush();
    }

    private function createCategory(string $name, Category $parent = null, ObjectManager $manager)
    {
        $category = new Category();
        $category->setName($name);
        $category->setCategoryOrder($this->counter);
//        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $name = mb_strtolower($category->getName());
        $category->setSlug(Slugger::slugify($name));
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        ++$this->counter;

        return $category;
    }
}
