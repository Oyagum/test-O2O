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
     * @Route("get/{id}", name="get_by_id", methods={"GET"})
     */
    public function getById(int $id): JsonResponse
    {
        $apiManager = new ApiManager();
        $res = $apiManager->getById(
            $id,
            ['id', 'name', 'description', 'tagline', 'first_brewed', 'image_url']
        );

        return new JsonResponse($res, Response::HTTP_OK);
    }

}
