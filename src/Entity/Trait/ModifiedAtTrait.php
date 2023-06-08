<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait ModifiedAtTrait
{   
    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?DateTimeImmutable $modified_at;

    public function getModifiedAt(): ?DateTimeImmutable
    {
        return $this->modified_at;
    }

    public function setModifiedAt(DateTimeImmutable $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }
}
