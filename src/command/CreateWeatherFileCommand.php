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

    /**
     * CreateWeatherFileCommand constructor.
     * @param ContainerInterface $container
     * @param WeatherDataExporterFactory $weatherDataExporterFactory
     * @param ForecastWeatherServiceInterface $forecastWeatherService
     */
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
     * @return string
     */
    public function execute(string $extension): string
    {
        $extensionVo = new ExtensionValueObject($extension);

        if (!$extensionVo->isValid()) {
            throw new InvalidExtensionParamException();
        }

        $weatherData = $this->forecastWeatherService->getWeatherData(
            $this->container->getParameter('current_city_lat'),
            $this->container->getParameter('current_city_log')
        );

        $exporter = $this->weatherDataExporterFactory->create($extensionVo);

        return $exporter->export($weatherData);
    }
}