<?php

namespace App\dto;

class WeatherDataDto
{
    /** @var string current date */
    public string $date;

    /** @var string current temperature */
    public string $temperature;

    /** @var string current wind speed */
    public string $windSpeed;

    /** @var string current wind direction */
    public string $windDirection;

    public function __construct(string $date, string $temperature, string $windSpeed, string $windDirection)
    {
        $this->date = $date;
        $this->temperature = $temperature;
        $this->windSpeed = $windSpeed;
        $this->windDirection = $windDirection;
    }
}