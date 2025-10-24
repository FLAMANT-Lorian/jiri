<?php

namespace App\Events;

use App\Models\Jiri;
use Illuminate\Foundation\Events\Dispatchable;

class JiriCreatedEvent
{
    use Dispatchable;

    public function __construct(public Jiri $jiri)
    {
    }
}
