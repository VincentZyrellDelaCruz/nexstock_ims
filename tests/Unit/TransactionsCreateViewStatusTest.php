<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TransactionsCreateViewStatusTest extends TestCase
{
    public function test_create_view_contains_admin_only_completed_option()
    {
        $file = __DIR__ . '/../../resources/views/transactions/create.blade.php';
        $content = file_get_contents($file);

        // Ensure the completed option is wrapped in an admin check so it's not visible to non-admins
        $this->assertStringContainsString("@if (Auth::check() && Auth::user()->role === 'admin')", $content);
        $this->assertStringContainsString("option value=\"completed\"", $content);
    }
}
