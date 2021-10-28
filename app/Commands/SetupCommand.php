<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Throwable;

class SetupCommand extends LinodeCommand
{
    protected $signature = 'setup';

    protected $description = 'Setup Linode Access token';

    public function handle(): int
    {
        $token = $this->ask(
            question: '<fg=yellow>‣</> <options=bold>Please enter your Personal Access token</>',
        );

        $this->request(fn() => $this->config->set('token', $token));

        $this->info(
            string: 'API Token stored successfully',
        );

        return self::SUCCESS;
    }
}
