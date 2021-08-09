<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class ApiManager
{
    private $urlApi = 'https://api.punkapi.com/v2/beers';
    const NO_RESULTS = 0;

    /**
     * Function for search by field in punkapi
     * @param string $field
     * @param string $value
     * @param array $returnFields
     * @return type
     */
    public function searchByField(
        string $field,
        string $value,
        array $returnFields
    ) {
        $httpClient = HttpClient::create();
        $response = $httpClient->request(
            'GET',
            $this->urlApi . '?' . $field . '=' . $value
        );
        return $this->checkResults(
            $response->toArray(),
            $returnFields,
            'Data \'' . $value . '\' not found.'
        );
    }

    /**
     * Function that get by id beer
     * @param int $id
     * @param array $returnFields
     */
    public function getById(int $id, array $returnFields)
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $this->urlApi . '/' . $id);
        return $this->checkResults(
            $response->toArray(),
            $returnFields,
            'Beer with id: \'' . $id . '\' not found.'
        );
    }

    /**
     * Check results
     * @param array $returnFields
     * @param string $errorMsg
     * @return type
     */
    private function checkResults(
        array $data,
        array $returnFields,
        string $errorMsg
    ) : array {
        if (count($data) === self::NO_RESULTS) {
            $res['data'] = $errorMsg;
        } else {
            $res = $this->getFields($data, $returnFields);
        }

        return $res;
    }

    /**
     * Function return fields requested
     * @param array $array
     * @param array $fields
     * @return array
     */
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
