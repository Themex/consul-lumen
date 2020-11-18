<?php

namespace Themex\LumenConsul\Commands;

use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\AgentInterface;
use Illuminate\Console\Command;

/**
 * Class ServiceRegister
 * @package Themex\LumenConsul\Commands
 */
class ServiceRegister extends Command {
    /**
     * The name and signature of the console command
     *
     * @var string
     */
    protected $signature = "consul:service:register";

    /**
     * The console command description
     *
     * @var string
     */
    protected $description = "Register consul service";

    /**
     * Command execution
     *
     * @return int
     */
    public function handle() {
        try {
            $consulUrls = explode(",", config());
            $services = config('consul.services');

            foreach ($consulUrls as $url) {
                $this->comment("Consul HTTP Service:");
                $this->line(sprintf(" - <info>%s</info>", $url));

                $serviceFactory = new ServiceFactory(['base_uri' => $url]);
                /** @var AgentInterface $agent */
                $agent = $serviceFactory->get(AgentInterface::class);

                foreach ($services as $service) {
                    $this->comment("Service:");
                    $this->line(sprintf(" - Name: <info>%s</info>", $service['Name']));
                    $this->line(sprintf(" - ID: <info>%s</info>", $service['ID']));
                    $this->line(sprintf(" - Address: <info>%s</info>", $service["Address"]));
                    $this->line(sprintf(" - Port: <info>%s</info>", $service["Port"]));

                    /** @var ConsulResponse $response */
                    $response = $agent->registerService($service);

                    if (200 !== $response->getStatusCode()) {
                        throw new \Exception("Error:");
                    }

                    $this->info(" Successful");
                    $this->output->newLine();
                }
            }
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }

        return 0;
    }
}
