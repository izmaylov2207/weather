<?php

namespace App\exporter;

use App\dto\WeatherDataDto;

class JsonWeatherDataExporter extends AbstractWeatherDataExporter implements WeatherDataExporterInterface
{
    /**
     * @inheritDoc
     */
    public function export(WeatherDataDto $weatherDataDto): string
    {
        $mappedData = $this->map($weatherDataDto);
        return $this->exportFile(json_encode($mappedData), 'json');
    }
}