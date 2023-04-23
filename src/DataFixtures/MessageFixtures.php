<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\Thread;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
//        user_id
//        thread_id
//        updated_by
//        content
//        created_at

        foreach ($this->getData() as [$user_id, $thread_id, $updated_by, $content]) {
            $user = $manager->getRepository(User::class)->findOneBy(['id' => $user_id]);
            $thread = $manager->getRepository(Thread::class)->findOneBy(['id' => $thread_id]);

            $message = new Message();
            $message->setUser($user);
            $message->setThread($thread);
            $message->setUpdatedBy($updated_by);
            $message->setContent($content);
            $message->setCreatedAt(new \DateTimeImmutable('now'));

            $manager->persist($message);
        }

        $manager->flush();
    }

//        user_id
//        thread_id
//        updated_by
//        content
//        created_at

    private function getData(): array
    {
        return [
            // data = [$user_id, $thread_id, $updated_by, $content]
            [4, 1, null, 'Duis aute irure dolor in reprehenderit'],
            [4, 1, null, 'quis nostrud exercitation ullamco laboris nisi ut aliquip'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            ThreadFixtures::class,
            UserFixtures::class,
        ];
    }
}