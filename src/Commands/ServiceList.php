<?php


namespace Themex\LumenConsul\Commands;

use Illuminate\Console\Command;
use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\CatalogInterface;

/**
 * Class ServiceList
 * @package Themex\LumenConsul\Commands
 */
class ServiceList extends Command
{
    /**
     * Name and signature of the console command
     *
     * @var string
     */
    protected $signature = "consul:service:list";

    /**
     * Console command description
     *
     * @var string
     */
    protected $description = "Consul services list";

    /**
     * Command execution
     *
     * @return mixed
     */
    public function handle() {
        try {
            $this->comment("Consul HTTP Services:");
            $consulUrls = explode(",", config('consul.base_uris'));
            foreach ($consulUrls as $url) {
                $this->line(sprintf(" - <info>%s</info>", $url));
                $this->output->newLine();

                $this->comment("Services:");

                $serviceFactory = new ServiceFactory(['base_uri' => $url]);

                /** @var CatalogInterface $serviceFactory */
                $catalog = $serviceFactory->get(CatalogInterface::class);

                /** @var ConsulResponse $catalog */
                $response = $catalog->services();
                if (200 !== $response->getStatusCode()) {
                    throw new \Exception("Error");
                }

                $services = json_decode($response->getBody(), true);

                if (empty($services)) {
                    $this->error("No services found");

                    foreach ($services as $service) {
                        $this->line(sprintf("- %s", json_encode($service)));
                        $this->output->newLine();
                    }
                }
            }
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
        return 0;
    }
}
