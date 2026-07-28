<?php

namespace Database\Seeders;

use App\Models\LetterTemplate;
use App\Models\LetterType;
use Illuminate\Database\Seeder;

class LetterTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LetterTemplate::create([
            'letter_type_id' => LetterType::first()->id,
            'name' => 'Default Active Study Template',
            'body_content' => '<p>This letter certifies that {{student_name}} is an active student.</p>',
            'is_active' => true,
        ]);
    }
}
