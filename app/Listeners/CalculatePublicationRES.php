<?php

namespace LoremPublishing\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LoremPublishing\Events\PublicationUpdated;
use Walrider\Readability\Pattern;
use Walrider\Readability\Readability;

class CalculatePublicationRES
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PublicationCreated  $event
     * @return void
     */
    public function handle(PublicationUpdated $event)
    {
        $publication = $event->publication;

        $readability = new Readability(new Pattern());

        $publication->RES = $readability->easeScore($publication->text);
        $publication->save();
    }
}
