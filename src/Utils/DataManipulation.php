<?php


namespace App\Utils;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DataManipulation extends AbstractController
{
    /**
     * @param $classDTO
     * @param $array
     * @return array
     */
    public static function arrayMap($classDTO,$array)
    {
        return array_map(function ($groupe) use ($classDTO) {
            return new $classDTO($groupe);
        },$array);
    }

}
