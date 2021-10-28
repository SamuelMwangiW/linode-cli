<?php

namespace App\Commands\Account;

use App\Commands\LinodeCommand;
use SamuelMwangiW\Linode\DTO\AccountDTO;
use SamuelMwangiW\Linode\Linode;

class ViewCommand extends LinodeCommand
{
    protected $signature = 'account:view';

    protected $description = 'View account details';

    public function handle(): int
    {
        /** @var AccountDTO $account*/
        $account = $this->request(fn() => Linode::account());

        $this->table(
            ['company','email','name','balance','uninvoiced','created'],
            [
                [
                    $account->company,
                    $account->email,
                    $account->fullName(),
                    $account->balance,
                    $account->uninvoiced,
                    $account->active_since->diffForHumans()
                ]
            ]
        );

        return self::SUCCESS;
    }
}
