<?php

namespace Tests\Feature;

use Tests\TestCase;

class RoomManagementPageTest extends TestCase
{
    public function test_room_list_page_is_available(): void
    {
        $response = $this->get(route('rooms.index'));

        $response
            ->assertOk()
            ->assertSee('Room Management', false)
            ->assertSee('Room Directory', false)
            ->assertSee('Add New Room', false);
    }

    public function test_add_room_page_is_available(): void
    {
        $response = $this->get(route('rooms.create'));

        $response
            ->assertOk()
            ->assertSee('Add Room', false)
            ->assertSee('Room Specification', false)
            ->assertSee('Save Room', false);
    }

    public function test_edit_room_page_is_available(): void
    {
        $response = $this->get(route('rooms.edit', ['room' => 'RM-301']));

        $response
            ->assertOk()
            ->assertSee('Edit Room', false)
            ->assertSee('Update Room', false)
            ->assertSee('301-A', false);
    }
}
