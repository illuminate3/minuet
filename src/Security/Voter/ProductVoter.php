<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Product;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{
    public const EDIT = 'PRODUCT_EDIT';
    public const DELETE = 'PRODUCT_DELETE';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param  string  $attribute
     * @param          $product
     *
     * @return bool
     */
    protected function supports(string $attribute, $product): bool
    {
        if (!\in_array($attribute, [self::EDIT, self::DELETE], true)) {
            return false;
        }
        if (!$product instanceof Product) {
            return false;
        }

        return true;

        // return in_array($attribute, [self::EDIT, self::DELETE]) && $product instanceof Product;
    }

    /**
     * @param                  $attribute
     * @param                  $product
     * @param  TokenInterface  $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $product, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit();
            case self::DELETE:
                return $this->canDelete();
        }
    }

    /**
     * @return bool
     */
    private function canEdit(): bool
    {
        return $this->security->isGranted('ROLE_PRODUCT_ADMIN');
    }

    private function canDelete(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

}
