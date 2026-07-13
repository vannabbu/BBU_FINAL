<?php

namespace Tests\Feature;

use App\Http\Controllers\AppointmentBookingController;
use Tests\TestCase;

class AppointmentBookingViewTest extends TestCase
{
    public function test_appointment_booking_page_can_render(): void
    {
        $html = app(AppointmentBookingController::class)->__invoke()->render();

        $this->assertStringContainsString('Appointment Booking', $html);
        $this->assertStringContainsString('Patient Information', $html);
        $this->assertStringContainsString('Available Time Slots', $html);
        $this->assertStringContainsString('Appointment Summary', $html);
        $this->assertStringContainsString('Confirm Appointment', $html);
    }

    public function test_appointments_route_uses_booking_page(): void
    {
        $this->get(route('appointments.index'))
            ->assertOk()
            ->assertSee('Appointment Booking', false)
            ->assertSee('Reception workflow', false);
    }
}
