<?php

namespace App\service;

use App\dto\WeatherDataDto;
use App\exception\ApiFailedRequestException;
use App\exception\InvalidApiParamsException;
use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\Response;

class ForecastWeatherService implements ForecastWeatherServiceInterface
{
    /** @var string endpoint for requests */
    private const URL = 'https://api.weather.yandex.ru/v2/forecast';

    /** @var string key for requests */
    private string $apiKey;

    /** @var string language of response */
    private string $lang;

    /** @var Client http request client */
    private Client $client;

    public function __construct(string $apiKey, string $lang, Client $client)
    {
        if (empty($apiKey) || empty($lang)) {
            throw new InvalidApiParamsException();
        }

        $this->apiKey = $apiKey;
        $this->lang = $lang;
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function getWeatherData(string $lat, string $log): WeatherDataDto
    {
        $response = $this->getResponseBody(['lat' => $lat, 'log' => $log]);
        return new WeatherDataDto(
            $response['now_dt'],
            $response['fact']['temp'],
            $response['fact']['wind_speed'],
            $response['fact']['wind_dir']
        );
    }

    /**
     * Returns response body
     *
     * @param array $queryParams
     * @return StreamInterface
     * @throws
     */
    private function getResponseBody(array $queryParams)
    {
        $queryParams = array_merge($this->getDefaultParams(), $queryParams);
        $requestUrl = self::URL . '?' . http_build_query($queryParams);
        $requestOptions = $this->getDefaultRequestOptions();

        $response = $this->client->get($requestUrl, $requestOptions);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new ApiFailedRequestException($response->getBody());
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Returns default query params
     *
     * @return string[]
     */
    private function getDefaultParams(): array
    {
        return [
            'lamg' => $this->lang,
            'limit' => 1,
            'hours' => false,
            'extra' => false,
        ];
    }

    /**
     * Returns default request options
     *
     * @return string[][]
     */
    private function getDefaultRequestOptions(): array
    {
        return [
            'headers' => [
                'X-Yandex-API-Key' => $this->apiKey,
            ],
        ];
    }
}