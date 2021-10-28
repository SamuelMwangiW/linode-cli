<?php

namespace App\Commands;

use App\Repositories\ConfigRepository;
use Closure;
use JustSteveKing\StatusCode\Http;
use LaravelZero\Framework\Commands\Command;
use SamuelMwangiW\Linode\Exceptions\CredentialsMissing;

abstract class LinodeCommand extends Command
{
    public function __construct(
        protected ConfigRepository $config,
    )
    {
        parent::__construct();
    }

    protected function request(Closure $handler)
    {
        try {
            return $handler();
        }
        catch (CredentialsMissing $exception)
        {
            return $this->fail("Linode Personal Access token has not been set. Run `./linode-cli setup` to set");
        }
        catch (\Illuminate\Http\Client\RequestException $exception)
        {
            if($exception->response->status() === Http::UNAUTHORIZED){
                return $this->fail("The Access token is invalid/unauthorized. Run `./linode-cli setup` to set");
            }
            return $this->fail($exception->getMessage());
        }
        catch (\Exception $exception)
        {
            return $this->fail($exception->getMessage());
        }
    }

    protected function fail(string $message)
    {
        $this->error($message);

        exit(self::FAILURE);
    }
}
