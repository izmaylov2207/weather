<?php

namespace App\factory;

use App\exception\InvalidExtensionParamException;
use App\exporter\JsonWeatherDataExporter;
use App\exporter\WeatherDataExporterInterface;
use App\exporter\XmlWeatherDataExporter;
use App\value_object\ExtensionValueObject;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WeatherDataExporterFactory
{
    /** @var ContainerInterface */
    private ContainerInterface $container;

    /**
     * WeatherDataExporterFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns exporter class
     *
     * @param ExtensionValueObject $extensionVo
     * @return WeatherDataExporterInterface
     */
    public function create(ExtensionValueObject $extensionVo): WeatherDataExporterInterface
    {
        $directory = ROOT_DIR . DIRECTORY_SEPARATOR . $this->container->getParameter('files_directory');

        if ($extensionVo->isJson()) {
            $template = $this->container->getParameter('json_template');
            return new JsonWeatherDataExporter($template, $directory);
        }

        if ($extensionVo->isXml()) {
            $template = $this->container->getParameter('xml_template');
            return new XmlWeatherDataExporter($template, $directory);
        }

        throw new InvalidExtensionParamException();
    }
}