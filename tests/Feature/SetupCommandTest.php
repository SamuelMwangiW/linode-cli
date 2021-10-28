<?php

it("sets the access token", function ($token) {
    $this->artisan('setup')
        ->expectsQuestion("<fg=yellow>‣</> <options=bold>Please enter your Linode Personal Access token</>",$token)
        ->assertExitCode(0);

    $this->assertEquals($token,value(config('linode.token')));
})->with('tokens');
