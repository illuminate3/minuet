<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:delete-users',
    description: 'Lists all the existing users',
)]
final class DeleteUsersCommand extends Command
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        parent::__construct();
        $this->users = $users;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $all_users = $this->users->findAll();
        foreach ($all_users as $user) {
            $this->users->remove($user, true);
        }

        return Command::SUCCESS;
    }
}
