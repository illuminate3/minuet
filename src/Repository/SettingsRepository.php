<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Settings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Settings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Settings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Settings[]    findAll()
 * @method Settings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SettingsRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Settings::class);
    }

    public function findAllAsArray(): array
    {
        $settings = $this->findAll();

        $settingsArray = [];
        foreach ($settings as $setting) {
            $settingsArray[$setting->getSettingName()] = $setting->getSettingValue();
        }

        return $settingsArray;
    }

    public function updateSetting(string $setting_name, ?string $setting_value = ''): void
    {
        $this->createQueryBuilder('i')
            ->update('App:Settings', 's')
            ->set('s.setting_value', '?1')
            ->where('s.setting_name = ?2')
            ->setParameter(1, $setting_value)
            ->setParameter(2, $setting_name)
            ->getQuery()
            ->execute();
    }

    public function updateSettings(array $settings): void
    {
        foreach ($settings as $setting_name => $setting_value) {
            $this->updateSetting($setting_name, (string) $setting_value);
        }
    }
}
