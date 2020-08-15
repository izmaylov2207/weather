<?php

namespace App\exporter;

use App\dto\WeatherDataDto;
use App\exception\CreateFileErrorException;

class AbstractWeatherDataExporter
{
    /** @var array - template of file */
    protected array $template;

    /** @var string - path to directory */
    protected string $directory;

    public function __construct(array $template, string $directory)
    {
        $this->template = $template;
        $this->directory = $directory;
    }

    /**
     * Maps weather data to needed template
     *
     * @param WeatherDataDto $weatherDataDto
     * @return array
     */
    protected function map(WeatherDataDto $weatherDataDto): array
    {
        $result = [];

        foreach ($this->template as $key => $label) {
            $result[$label] = $weatherDataDto->$key;
        }

        return $result;
    }

    /**
     * Creates file
     *
     * @param string $data
     * @param string $extension
     * @return string
     * @throws CreateFileErrorException
     */
    protected function exportFile(string $data, string $extension): string
    {
        $filename = $this->directory . DIRECTORY_SEPARATOR . date("Y_m_d_H_i_s") . ".$extension";

        if (!file_put_contents($filename, $data)) {
            throw new CreateFileErrorException();
        }

        return $filename;
    }
}