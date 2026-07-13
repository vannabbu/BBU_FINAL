<?php

namespace Tests\Feature;

use Tests\TestCase;

class DoctorConsultationPageTest extends TestCase
{
    public function test_doctor_consultation_page_can_be_rendered(): void
    {
        $this->get('/doctors/consultation')
            ->assertOk()
            ->assertSee('ផ្ទាំងពិគ្រោះជំងឺ');
    }
}
