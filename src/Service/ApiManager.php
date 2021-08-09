<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class ApiManager
{
    private $urlApi = 'https://api.punkapi.com/v2/beers';

    public function searchByField(string $field, string $value, array $returnFields)
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request(
            'GET',
            $this->urlApi . '?' . $field . '=' . $value
        );
        if (count($response->toArray()) === 0) {
            $res['data'] = 'Data \'' . $value . '\' not found.';
        } else {
            $res = $this->getFields($response->toArray(), $returnFields);
        }
        return $res;
    }

    private function getFields(array $array, array $fields): array
    {
        return array_map(function ($item) use($fields) {
            $result = [];
            foreach($fields as $field) {
                $result[$field] = $item[$field];
            }
            return $result;
        }, $array);
    }
}