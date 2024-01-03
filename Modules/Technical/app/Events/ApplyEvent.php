<?php

namespace Modules\Technical\app\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class ApplyEvent
{
    use SerializesModels;

    public Model $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('notifications');
    }
}
