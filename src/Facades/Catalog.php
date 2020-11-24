<?php
namespace Themex\LumenConsul\Facades;

use Themex\LumenConsul\Exceptions\ConsulException;
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

    /**
     * Selected service info
     * @param string $name
     * @return array
     * @throws ConsulException
     */
    public function getServiceByName(string $name) : array {
        $service = self::service($name);

        if (200 !== $service->getStatusCode()) {
            throw new ConsulException(ucwords($name."BadGateway"), 504);
        }

        $arr = json_decode($service->getBody(), true);

        if (count($arr) < 1) {
            throw new ConsulException("NoServicesFound", 404);
        }

        return $arr;
    }

    /**
     * Service API endpoint
     * @param $service
     * @param $endpoint
     * @param string $proto
     * @return string
     */
    public function getServiceEndpointUrl($service, $endpoint, $proto = 'http') {
        return $proto."://{$service['ServiceAddress']}:".$service['ServicePort'].$endpoint;
    }
}
