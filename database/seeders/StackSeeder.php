<?php

namespace Database\Seeders;

use App\Models\Stack;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StackSeeder extends Seeder
{
    public function run(): void
    {
        $stacks = [
            ['name' => 'PHP',        'category' => 'backend',  'color' => '#7a86b8', 'order' => 1],
            ['name' => 'Laravel',    'category' => 'backend',  'color' => '#ff2d20', 'order' => 2],
            ['name' => 'React',      'category' => 'frontend', 'color' => '#61dafb', 'order' => 3],
            ['name' => 'Next.js',    'category' => 'frontend', 'color' => '#000000', 'order' => 4],
            ['name' => 'TypeScript', 'category' => 'frontend', 'color' => '#3178c6', 'order' => 5],
            ['name' => 'Tailwind',   'category' => 'frontend', 'color' => '#38bdf8', 'order' => 6],
            ['name' => 'MySQL',      'category' => 'database', 'color' => '#4479a1', 'order' => 7],
            ['name' => 'PostgreSQL', 'category' => 'database', 'color' => '#336791', 'order' => 8],
            ['name' => 'SQLite',     'category' => 'database', 'color' => '#003b57', 'order' => 9],
            ['name' => 'Docker',     'category' => 'devops',   'color' => '#2496ed', 'order' => 10],
            ['name' => 'Git',        'category' => 'devops',   'color' => '#f05032', 'order' => 11],
            ['name' => 'Node.js',    'category' => 'backend',  'color' => '#339933', 'order' => 12],
        ];

        foreach ($stacks as $stack) {
            Stack::firstOrCreate(
                ['slug' => Str::slug($stack['name'])],
                array_merge($stack, ['slug' => Str::slug($stack['name']), 'visible' => true])
            );
        }
    }
}
