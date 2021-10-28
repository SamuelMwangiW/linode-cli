<?php

namespace App\Commands\Plans;

use App\Commands\LinodeCommand;
use SamuelMwangiW\Linode\DTO\PlanDTO;
use SamuelMwangiW\Linode\Linode;

class ListCommand extends LinodeCommand
{
    protected $signature = 'plans:list';

    protected $description = 'View available Linode plans';

    public function handle(): int
    {
        $plans = $this->request(fn() => Linode::billing()->plans());

        $this->table(
            ['id', 'label', 'monthly price', 'class'],
            $plans->map(
                fn(PlanDTO $plan) => [
                    $plan->id, $plan->label, '$' . number_format($plan->monthly_price), $plan->class
                ]
            )
        );

        return self::SUCCESS;
    }
}
