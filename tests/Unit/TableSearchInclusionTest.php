<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TableSearchInclusionTest extends TestCase
{
    public function filesProvider()
    {
        return [
            [__DIR__ . '/../../resources/views/products/index.blade.php', 'Search products...'],
            [__DIR__ . '/../../resources/views/transactions/index.blade.php', 'Search transactions...'],
            [__DIR__ . '/../../resources/views/inventory/index.blade.php', 'Search inventory...'],
            [__DIR__ . '/../../resources/views/suppliers/index.blade.php', 'Search suppliers...'],
            [__DIR__ . '/../../resources/views/categories/index.blade.php', 'Search categories...'],
            [__DIR__ . '/../../resources/views/admin/index.blade.php', 'Search users...'],
            [__DIR__ . '/../../resources/views/dashboard.blade.php', 'Search recent orders...'],
        ];
    }

    /**
     * @dataProvider filesProvider
     */
    public function test_view_contains_search_partial($file, $placeholder)
    {
        $this->assertFileExists($file);
        $content = file_get_contents($file);
        $this->assertStringContainsString("@include('components._table_search'", $content);
        $this->assertStringContainsString($placeholder, $content);
    }
}
