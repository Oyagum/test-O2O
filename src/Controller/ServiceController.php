<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiManager;


/**
 * Class ServiceController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class ServiceController
{
    /**
     * @Route("search/{food}", name="search_food", methods={"GET"})
     */
    public function search(string $food): JsonResponse
    {
        $apiManager = new ApiManager();
        $res = $apiManager->searchByField(
            'food',
            $food,
            ['id', 'name', 'description']
        );
        return new JsonResponse($res, Response::HTTP_OK);
   }

    /**
     * @Route("get/{id}", name="get_one_pet", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $pet = $this->petRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $pet->getId(),
            'name' => $pet->getName(),
            'type' => $pet->getType(),
            'photoUrls' => $pet->getPhotoUrls(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
