<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Transaction;

class TransactionModelTest extends TestCase
{
    public function test_fillable_contains_date()
    {
        $model = new Transaction();
        $this->assertContains('date', $model->getFillable());
    }

    public function test_casts_contains_date()
    {
        $model = new Transaction();
        $casts = $model->getCasts();
        $this->assertArrayHasKey('date', $casts);
        $this->assertEquals('date', $casts['date']);
    }
}
