<?php

namespace App\Commands\Firewall;

use App\Commands\LinodeCommand;
use SamuelMwangiW\Linode\DTO\FirewallDTO;
use SamuelMwangiW\Linode\Linode;

class ListCommand extends LinodeCommand
{
    protected $signature = 'firewall:list';

    protected $description = 'List Firewall';

    public function handle(): int
    {
        $list = $this->request(fn()=>Linode::firewall()->list());

        if ($list->count() === 0) {
            $this->info("No Firewalls on your account");
            return self::SUCCESS;
        }

        $this->table(
            ['id','label','inbound policy','outbound policy','status','created'],
            $list->map(fn(FirewallDTO $firewall) => [
                $firewall->id,
                $firewall->label,
                $firewall->rules->inbound_policy,
                $firewall->rules->outbound_policy,
                $firewall->status,
                $firewall->created->diffForHumans(),
            ])
        );

        return self::SUCCESS;
    }
}
