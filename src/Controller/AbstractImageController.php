<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;

abstract class AbstractImageController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(
        protected ManagerRegistry $doctrine,
        EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
    }


    /**
     * @param  Product       $product
     * @param  Request       $request
     * @param  FileUploader  $fileUploader
     *
     * @return JsonResponse
     * @throws Exception
     */
    protected function uploadImage(Product $product, Request $request, FileUploader $fileUploader): JsonResponse
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');
        $violations = $fileUploader->validate($uploadedFile);

        if ($violations->count() > 0) {
            /** @var ConstraintViolation $violation */
            $violation = $violations[0];
            $this->addFlash('danger', $violation->getMessage());

            return new JsonResponse(['status' => 'fail'], 422);
        }

        $fileName = $fileUploader->upload($uploadedFile);

        $image = new Image();
        $image->setProduct($product)
            ->setSortOrder(0)
            ->setFile($fileName);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($image);
        $entityManager->flush();

        return new JsonResponse(['status' => 'ok']);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    protected function sortImages(
        Request $request,
    ): JsonResponse {
        $ids = $request->request->all('ids');
        $imageRepository = $this->doctrine->getRepository(Image::class);

        $i = 1;
        foreach ($ids as $id) {
            $image = $imageRepository->findOneBy(['id' => $id]);
            $image->setSortOrder($i);
            $this->entityManager->persist($image);
            ++$i;
        }

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'ok']);
    }
}
