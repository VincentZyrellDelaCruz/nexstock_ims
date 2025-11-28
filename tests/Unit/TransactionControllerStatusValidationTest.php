<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TransactionControllerStatusValidationTest extends TestCase
{
    public function test_controller_contains_role_based_status_validation()
    {
        $file = __DIR__ . '/../../app/Http/Controllers/TransactionController.php';
        $content = file_get_contents($file);

        $this->assertStringContainsString("required|in:completed,pending,cancelled", $content);
        $this->assertStringContainsString("required|in:pending,cancelled", $content);
    }
}
