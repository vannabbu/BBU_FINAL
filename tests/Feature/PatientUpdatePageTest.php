<?php

namespace Tests\Feature;

use Tests\TestCase;

class PatientUpdatePageTest extends TestCase
{
    public function test_patient_update_page_is_available(): void
    {
        $response = $this->get(route('patients.update'));

        $response
            ->assertOk()
            ->assertSee('កែប្រែកំណត់ត្រាអ្នកជំងឺ', false)
            ->assertSee('ជួររង់ចាំផ្ទាល់', false)
            ->assertSee('រក្សាទុកការកែប្រែអ្នកជំងឺ', false);
    }
}
