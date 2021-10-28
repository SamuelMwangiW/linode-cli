<?php

namespace App\Commands\Regions;

use App\Commands\LinodeCommand;
use SamuelMwangiW\Linode\DTO\RegionDTO;
use SamuelMwangiW\Linode\Linode;

class ListCommand extends LinodeCommand
{
    protected $signature = 'region:list';

    protected $description = 'View a list of available regions';

    public function handle(): int
    {
        $regions = $this->request(fn() => Linode::region()->list());

        $this->table(
            ['id', 'country', 'status', 'capabilities'],
            collect($regions)
                ->map(
                    fn(RegionDTO $region) => [
                        $region->id,
                        $region->country,
                        $region->status,
                        $region->capabilities->implode(', ')
                    ])
        );

        return self::SUCCESS;
    }
}
