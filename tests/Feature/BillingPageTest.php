<?php

namespace Tests\Feature;

use Tests\TestCase;

class BillingPageTest extends TestCase
{
    public function test_billing_page_is_available(): void
    {
        $response = $this->get(route('invoices.index'));

        $response
            ->assertOk()
            ->assertSee('Billing Management', false)
            ->assertSee('តារាងថ្លៃឱសថ', false)
            ->assertSee('សង្ខេបការទូទាត់', false)
            ->assertSee('វិក្កយបត្រថ្មីៗ', false);
    }
}
