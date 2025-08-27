<?php

namespace App\Events;

use App\Models\SalaryAdvance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SalaryAdvanceStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $salaryAdvance;
    public $previousStatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SalaryAdvance $salaryAdvance, $previousStatus)
    {
        $this->salaryAdvance = $salaryAdvance;
        $this->previousStatus = $previousStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}