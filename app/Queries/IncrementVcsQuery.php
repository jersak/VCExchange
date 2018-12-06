<?php

namespace App\Queries;

use DB;

class IncrementVcsQuery
{
    public function __invoke()
    {
        DB::update("UPDATE users set virtual_currency = virtual_currency + 0.25");
    }
}
