<?php

namespace App\exporter;

use App\dto\WeatherDataDto;

interface WeatherDataExporterInterface
{

    /**
     * Creates file and saves it
     *
     * @param WeatherDataDto $weatherDataDto
     * @return string - path to created file
     * @throws
     */
    public function export(WeatherDataDto $weatherDataDto): string;

}