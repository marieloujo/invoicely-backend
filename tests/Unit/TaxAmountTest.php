<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TaxAmountTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_that_the_tax_is_correct(): void
    {
        $amount = 50;
        $this->assertEquals(calculate_taxe_amount($amount), 9);
    }

    public function test_that_total_amount_incl_is_correct(): void
    {
        $amount = 50;
        $this->assertEquals(get_include_taxe_amount($amount), 59);
    }

}
