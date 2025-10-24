<?php

namespace App\Observers;

use App\Events\JiriCreatedEvent;
use App\Models\Jiri;

class JiriObserver
{
    public function created(Jiri $jiri): void
    {
        event(new JiriCreatedEvent($jiri));
    }

    public function updated(Jiri $jiri): void
    {
    }

    public function deleted(Jiri $jiri): void
    {
    }

    public function restored(Jiri $jiri): void
    {
    }
}
