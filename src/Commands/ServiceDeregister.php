<?php

namespace Themex\LumenConsul\Commands;

use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\AgentInterface;
use Illuminate\Console\Command;

/**
 * Class ServiceDeregister
 * @package Themex\LumenConsul\Commands
 */
class ServiceDeregister extends Command {
    /**
     * Name and signature of the console command
     *
     * @var string
     */
    protected $signature = "consul:service:deregister {service_id}";

    /**
     * Console command description
     *
     * @var string
     */
    protected $description = "Deregister consul service";

    /**
     * Command execution
     *
     * @return mixed
     */
    public function handle() {
        try {
            $consulUrls = explode(',', config('consul.base_uris'));

            foreach ($consulUrls as $url) {
                $this->comment("Consul HTTP Service:");
                $this->line(sprintf(" - <info>%s</info>", $url));
                $serviceFactory = new ServiceFactory(['base_uri' => $url]);

                /** @var AgentInterface $agent */
                $agent = $serviceFactory->get(AgentInterface::class);

                $serviceId = $this->argument('service_id');

                $this->comment("Service:");
                $this->line(sprintf(" - ID: <info>%s</info>", $serviceId));

                /** @var ConsulResponse $response */
                $response = $agent->deregisterService($serviceId);

                $this->line(sprintf(" - Unregistered: <info>%s</info>", json_encode($response->getBody())));
                $this->output->newLine();
            }
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
        return 0;
    }
}
