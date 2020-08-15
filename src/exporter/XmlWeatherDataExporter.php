<?php

namespace App\exporter;

use App\dto\WeatherDataDto;
use SimpleXMLElement;

class XmlWeatherDataExporter extends AbstractWeatherDataExporter implements WeatherDataExporterInterface
{
    /**
     * @inheritDoc
     */
    public function export(WeatherDataDto $weatherDataDto): string
    {
        $mappedData = $this->map($weatherDataDto);
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><values/>');

        foreach ($mappedData as $key => $value) {
            $xml->addChild($key, $value);
        }

        return $this->exportFile($xml->asXML(), 'xml');
    }
}