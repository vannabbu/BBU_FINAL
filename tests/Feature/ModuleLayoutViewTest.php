<?php

namespace Tests\Feature;

use Tests\TestCase;

class ModuleLayoutViewTest extends TestCase
{
    public function test_generic_module_index_uses_modern_layout(): void
    {
        $this->get(route('diagnosis-reports.index'))
            ->assertOk()
            ->assertSee('Hospital Management', false)
            ->assertSee('data-lucide="database"', false);
    }

    public function test_generic_module_create_uses_modern_layout(): void
    {
        $this->get(route('modules.create', ['module' => 'diagnosis-reports']))
            ->assertOk()
            ->assertSee('Hospital Management', false)
            ->assertSee('data-lucide="clipboard-plus"', false);
    }
}
