<?php

namespace App\controller;

use App\command\CreateWeatherFileCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{
    /**
     * @param string $extension
     * @param CreateWeatherFileCommand $createWeatherFileCommand
     * @return Response
     */
    public function getWeatherAction(string $extension, CreateWeatherFileCommand $createWeatherFileCommand)
    {
        $createWeatherFileCommand->execute($extension);
        return new Response($createWeatherFileCommand->execute($extension));
    }
}