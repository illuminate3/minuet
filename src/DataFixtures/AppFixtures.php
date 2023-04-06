<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Settings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (self::getData() as [$setting_name, $setting_value]) {
            $setting = new Settings();
            $setting->setSettingName($setting_name);
            $setting->setSettingValue($setting_value);
            $manager->persist($setting);
        }
        $manager->flush();
    }

    public static function getData(): array
    {
        return [
            // $data = [$setting_name, $setting_value];
            ['site_name', 'Minuet'],
            ['site_title', 'Page Title'],
            ['meta_title', 'Meta Title'],
            ['meta_description', 'Meta Description'],
            ['meta_keywords', 'Meta Keywords'],
            ['meta_author', 'Meta Author'],
            ['meta_revisit', '7'],
            ['site_branding', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.'],
            ['analytics_code', ''],
            ['allow_register', '1'],
        ];
    }
}
