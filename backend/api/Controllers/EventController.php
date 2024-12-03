<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AbstractController;
use App\Repositories\EventRepository;

class EventController extends AbstractController
{
    public function __construct(EventRepository $eventRepository)
    {
        parent::__construct($eventRepository);
    }
}
