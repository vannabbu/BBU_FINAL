<?php

namespace Tests\Feature;

use Tests\TestCase;

class MedicineStockPageTest extends TestCase
{
    public function test_medicine_stock_page_is_available(): void
    {
        $response = $this->get(route('medicines.index'));

        $response
            ->assertOk()
            ->assertSee('គ្រប់គ្រងស្តុកឱសថ', false)
            ->assertSee('តារាងឃ្លាំងឱសថ', false)
            ->assertSee('AI Reorder Recommendation', false);
    }
}
