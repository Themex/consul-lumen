<?php

namespace Themex\LumenConsul\Facades;

use Illuminate\Support\Facades\Facade;
use SensioLabs\Consul\Services\AgentInterface;

/**
 * Class Agent
 *
 * @see AgentInterface
 *
 * @method static checks()
 * @method static services()
 * @method static members(array $options = array())
 * @method static self()
 * @method static join($address, array $options = array())
 * @method static forceLeave($node)
 * @method static registerCheck($check)
 * @method static deregisterCheck($checkId)
 * @method static passCheck($checkId, array $options = array())
 * @method static warnCheck($checkId, array $options = array())
 * @method static failCheck($checkId, array $options = array())
 * @method static registerService($service)
 * @method static deregisterService($serviceId)
 *
 * @package Themex\LumenConsul\Facades
 */
class Agent extends Facade {
    /**
     * Registered name of component
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return "consul.service.agent";
    }
}
