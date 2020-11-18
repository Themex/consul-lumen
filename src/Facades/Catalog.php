<?php


namespace Themex\LumenConsul\Facades;


use Illuminate\Support\Facades\Facade;
use SensioLabs\Consul\Services\CatalogInterface;

/**
 * Class Catalog
 *
 * @see CatalogInterface
 *
 * @method static register($node)
 * @method static deregister($node)
 * @method static datacenters()
 * @method static nodes(array $options = [])
 * @method static node($node, array $options = array())
 * @method static services(array $options = array())
 * @method static service($service, array $options = array())
 *
 * @package Themex\LumenConsul\Facades
 */
class Catalog extends Facade
{
    /**
     * Registered name of component
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return "consul.service.catalog";
    }
}
