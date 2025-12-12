<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Food & Refreshments', 'description' => 'Sunday tea, bread, milk for pastoral team'],
            ['name' => 'Utilities', 'description' => 'Water, electricity, internet bills'],
            ['name' => 'Salaries', 'description' => 'Watch lady, watch man, staff salaries'],
            ['name' => 'Cleaning Supplies', 'description' => 'Detergents, brooms, cleaning materials'],
            ['name' => 'Maintenance', 'description' => 'Church building repairs and maintenance'],
            ['name' => 'Transport', 'description' => 'Pastor travel, fuel, transport costs'],
            ['name' => 'Hospitality', 'description' => 'Guest accommodation, meals'],
            ['name' => 'Equipment', 'description' => 'Sound system, musical instruments'],
            ['name' => 'Office Supplies', 'description' => 'Stationery, printing, office materials'],
            ['name' => 'Loan Repayment', 'description' => 'Church loan repayments'],
            ['name' => 'Pastor Appreciation', 'description' => 'Tokens of appreciation for pastor'],
            ['name' => 'Outreach', 'description' => 'Community outreach programs'],
            ['name' => 'Conference & Seminars', 'description' => 'Church conferences and seminars'],
            ['name' => 'Insurance', 'description' => 'Church property insurance'],
            ['name' => 'Miscellaneous', 'description' => 'Other unclassified expenses'],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }
    }
}
