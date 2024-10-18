<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class EventRepository
{
    protected Event $model;

    /**
     * @param Event $model
     */
    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getAllEvents(): Collection
    {
        return $this->model::all();  // Uses Eloquent's all() method on the injected model
    }

    /**
     * @param int $id
     * @return Event|false
     */
    public function getEventById(int $id): Event | false
    {
        // Find the event by ID
        $event = $this->model->query()->find($id);

        // Return false if the event is not found
        if (!$event) {
            return false;
        }

        // Return the event if found
        return $event;
    }


    /**
     * @param array<string, string> $data
     * @return event
     */
    public function createEvent(array $data): Event
    {
        return $this->model->query()->create($data);
    }


    /**
     * @param int $id
     * @param array<string, string> $data
     * @return Event|false
     */
    public function updateEvent(int $id, array $data): Event | false
    {
        $event = $this->model->query()->find($id);  // Find the event by ID
        if (!$event) {
            return false;  // Return false if the event is not found
        }

        // Update the event with the provided data
        if ($event->update($data)) {
            return $event;
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteEvent(int $id): bool
    {
        $event = $this->model->query()->find($id);  // Find the event by ID
        if ($event) {
            return (bool) $event->delete();
        }
        return false;  // Return false if the event is not found
    }
}
