<?php


namespace App\Utils;


use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Configuration\AutoMapperConfig;

class MapperAuto
{
    /**
     * @param $source
     * @param $destination
     * @return AutoMapperInterface
     */
    public function mapper($source,$destination)
    {
        return $mapper = AutoMapper::initialize(function (AutoMapperConfig $config) use ($source, $destination){
            $config->registerMapping($source,$destination);
        });
    }
}
