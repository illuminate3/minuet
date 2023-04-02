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
            ['name', 'Minuet Site Name'],
            ['title', 'Minuet Branding'],
            ['meta_title', 'Minuet Site Title'],
            ['meta_description', 'Minuet Site Description'],
            ['analytics_code', ''],
            ['allow_register', '0'],
        ];
    }
}
