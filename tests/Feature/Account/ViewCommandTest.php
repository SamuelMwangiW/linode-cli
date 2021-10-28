<?php

it("gets account details", function () {
    $this->artisan('account:view')
       ->assertExitCode(0);
})->only();
