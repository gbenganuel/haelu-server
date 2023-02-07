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
    public function handleRiskNotifications($event) {
        // if there are risks, send corresponding alerts
        
        //$event->user->notify(new UserPinCreated($event->user));
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
            [MNAEventSubscriber::class, 'handleRiskNotifications']
        );
    }
}