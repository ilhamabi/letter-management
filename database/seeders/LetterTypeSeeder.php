<?php

namespace Database\Seeders;

use App\Models\ApprovalFlow;
use App\Models\LetterType;
use Illuminate\Database\Seeder;

class LetterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LetterType::create([
            'approval_flow_id' => ApprovalFlow::first()->id,
            'name' => 'Certificate of Active Study',
            'code' => 'SKA',
            'description' => 'Certificate of Active Study',
            'minimum_gpa' => null,
            'minimum_credits' => null,
            'requires_attachment' => false,
            'is_active' => true,
        ]);
    }
}
