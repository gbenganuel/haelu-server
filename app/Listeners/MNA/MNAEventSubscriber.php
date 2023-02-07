<?php
 
namespace App\Listeners\MNA;
 
use App\Repositories\MNARepository;
use App\Events\MNA\NewMNACreatedEvent;
use App\Listeners\MNA\MNAEventSubscriber;
use Illuminate\Support\Facades\Log;
use App\Notifications\MNAPinCreated;
 
class MNAEventSubscriber
{
    /**
     * Public declaration of variables.
     *
     * @var MNARepository $mnaRepository
     */
    public $mnaRepository;

    /**
     * Dependency Injection of variables
     *
     * @param mnaRepository $mnaRepository
     * @return void
     */
    public function __construct(MNARepository $mnaRepository)
    {
        $this->mnaRepository = $mnaRepository;
    }

    /**
     * handle notifications.
     */
    public function handleNotifications($event) {

        // if there are risks, send corresponding alerts
        /* 
        if ($event->mna->screening_score_verdict == 'malnourished') {
            // notify loved ones
            $event->mna->user->next_of_kin->notify(new PatientIsMalnourished($event->user));
            // notify physician
            $event->mna->user->physician->notify(new PatientIsMalnourished($event->user));
        }*/
    }
 
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            NewMNACreatedEvent::class,
            [MNAEventSubscriber::class, 'handleNotifications']
        );
    }
}