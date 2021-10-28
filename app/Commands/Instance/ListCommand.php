<?php

namespace App\Commands\Instance;

use App\Commands\LinodeCommand;
use SamuelMwangiW\Linode\DTO\InstanceDTO;
use SamuelMwangiW\Linode\DTO\IPAddress;
use SamuelMwangiW\Linode\Linode;

class ListCommand extends LinodeCommand
{
    protected $signature = 'instance:list';

    protected $description = 'List the Linode instances on your account';

    public function handle(): int
    {
        $instances = $this->request(fn() => Linode::instance()->list());

        if ($instances->count() === 0) {
            $this->info("No Linode instances on your account");
            return self::SUCCESS;
        }

        $this->table(
            ['id','label','status','region','type','IP(s)','tags'],
            $instances->map(fn(InstanceDTO $instance) => [
                $instance->id,
                $instance->label,
                $instance->status,
                $instance->region,
                $instance->type,
                $instance->ips->map(fn(IPAddress $ip)=>$ip->ip)->implode(', '),
                $instance->tags->implode(', ')
            ])
    );

        return self::SUCCESS;
    }
}
