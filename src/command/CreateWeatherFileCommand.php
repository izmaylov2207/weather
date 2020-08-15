<?php

namespace App\command;

use App\exception\InvalidExtensionParamException;
use App\factory\WeatherDataExporterFactory;
use App\service\ForecastWeatherServiceInterface;
use App\value_object\ExtensionValueObject;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateWeatherFileCommand
{
    /** @var ContainerInterface */
    private ContainerInterface $container;

    /** @var WeatherDataExporterFactory */
    private WeatherDataExporterFactory $weatherDataExporterFactory;

    /** @var ForecastWeatherServiceInterface */
    private ForecastWeatherServiceInterface $forecastWeatherService;

    public function __construct(
        ContainerInterface $container,
        WeatherDataExporterFactory $weatherDataExporterFactory,
        ForecastWeatherServiceInterface $forecastWeatherService
    ) {
        $this->container = $container;
        $this->weatherDataExporterFactory = $weatherDataExporterFactory;
        $this->forecastWeatherService = $forecastWeatherService;
    }

    /**
     * @param string $extension
     */
    public function execute(string $extension)
    {
        $extensionVo = new ExtensionValueObject($extension);

        if (!$extensionVo->isValid()) {
            throw new InvalidExtensionParamException();
        }

        $weatherData = $this->forecastWeatherService->getWeatherData(
            $this->container->hasParameter('current_city_lat'),
            $this->container->hasParameter('current_city_lag')
        );

        $exporter = $this->weatherDataExporterFactory->create($extensionVo);

        return $exporter->export($weatherData);
    }
}