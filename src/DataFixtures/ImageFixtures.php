<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getPhotoData() as [$product, $order, $file]) {
            $photo = new Image();
            $photo->setProduct($product);
            $photo->setSortOrder($order);
            $photo->setFile($file);
            $manager->persist($photo);
        }
        $manager->flush();
    }

    private function getPhotoData(): array
    {
        return [
            [$this->getReference('product-1'), 1, 'demo/1.jpeg'],
            [$this->getReference('product-2'), 1, 'demo/2.jpeg'],
            [$this->getReference('product-3'), 1, 'demo/3.jpeg'],
            [$this->getReference('product-4'), 1, 'demo/4.jpeg'],
            [$this->getReference('product-5'), 1, 'demo/5.jpeg'],
            [$this->getReference('product-6'), 1, 'demo/6.jpeg'],
            [$this->getReference('product-7'), 1, 'demo/7.jpeg'],
            [$this->getReference('product-8'), 1, 'demo/8.jpeg'],
            [$this->getReference('product-9'), 1, 'demo/9.jpeg'],
            [$this->getReference('product-10'), 1, 'demo/10.jpeg'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }
}
