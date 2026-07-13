<?php

namespace Tests\Feature;

use App\Http\Controllers\StaffManagementController;
use Tests\TestCase;

class StaffManagementViewTest extends TestCase
{
    public function test_staff_management_page_can_render(): void
    {
        $html = app(StaffManagementController::class)->index()->render();

        $this->assertStringContainsString('Staff &amp; User Management', $html);
        $this->assertStringContainsString('Employee Directory', $html);
        $this->assertStringContainsString('Add Employee', $html);
    }

    public function test_add_employee_page_can_render(): void
    {
        $html = app(StaffManagementController::class)->create()->render();

        $this->assertStringContainsString('Add Employee', $html);
        $this->assertStringContainsString('Personal Information', $html);
        $this->assertStringContainsString('Save Employee', $html);
    }

    public function test_edit_employee_page_can_render(): void
    {
        $html = app(StaffManagementController::class)->edit('EMP-1001')->render();

        $this->assertStringContainsString('Edit Employee', $html);
        $this->assertStringContainsString('Update Employee', $html);
        $this->assertStringContainsString('EMP-1001', $html);
    }
}
