<?php

namespace App\service;

use App\dto\WeatherDataDto;

interface ForecastWeatherServiceInterface
{

    /**
     * Returns weather data by city coordinates
     *
     * @param string $lat - latitude
     * @param string $log - longitude
     * @return WeatherDataDto
     * @throws
     */
    public function getWeatherData(string $lat, string $log): WeatherDataDto;
}