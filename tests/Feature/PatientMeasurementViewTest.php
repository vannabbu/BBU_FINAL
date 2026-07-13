<?php

namespace Tests\Feature;

use App\Http\Controllers\PatientMeasurementController;
use Tests\TestCase;

class PatientMeasurementViewTest extends TestCase
{
    public function test_add_patient_measurement_page_can_render(): void
    {
        $html = app(PatientMeasurementController::class)->create()->render();

        $this->assertStringContainsString('Add Patient Measurement', $html);
        $this->assertStringContainsString('Laboratory', $html);
        $this->assertStringContainsString(route('diagnosis-reports.index'), $html);
        $this->assertStringContainsString('Patient Information', $html);
        $this->assertStringContainsString('Vital Signs', $html);
        $this->assertStringContainsString('Clinical Notes', $html);
        $this->assertStringContainsString('Measurement History', $html);
        $this->assertStringContainsString('Save Measurement', $html);
    }

    public function test_lab_measurement_route_can_render(): void
    {
        $this->get(route('diagnosis-reports.measurements.create'))
            ->assertOk()
            ->assertSee('Add Patient Measurement')
            ->assertSee('Laboratory');
    }
}
