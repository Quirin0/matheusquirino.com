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
            // ── Frontend ──────────────────────────────────────────
            ['name' => 'React',       'category' => 'frontend', 'color' => '#61DAFB', 'order' =>  1],
            ['name' => 'Next.js',     'category' => 'frontend', 'color' => '#ffffff', 'order' =>  2],
            ['name' => 'TypeScript',  'category' => 'frontend', 'color' => '#3178C6', 'order' =>  3],
            ['name' => 'JavaScript',  'category' => 'frontend', 'color' => '#F7DF1E', 'order' =>  4],
            ['name' => 'HTML5',       'category' => 'frontend', 'color' => '#E34F26', 'order' =>  5],
            ['name' => 'CSS3',        'category' => 'frontend', 'color' => '#1572B6', 'order' =>  6],
            ['name' => 'Tailwind',    'category' => 'frontend', 'color' => '#06B6D4', 'order' =>  7],

            // ── Backend ───────────────────────────────────────────
            ['name' => 'PHP',         'category' => 'backend',  'color' => '#777BB4', 'order' =>  8],
            ['name' => 'Laravel',     'category' => 'backend',  'color' => '#FF2D20', 'order' =>  9],
            ['name' => 'Node.js',     'category' => 'backend',  'color' => '#339933', 'order' => 10],
            ['name' => 'Python',      'category' => 'backend',  'color' => '#3776AB', 'order' => 11],

            // ── Banco de Dados ────────────────────────────────────
            ['name' => 'MySQL',       'category' => 'database', 'color' => '#4479A1', 'order' => 12],
            ['name' => 'PostgreSQL',  'category' => 'database', 'color' => '#336791', 'order' => 13],
            ['name' => 'SQLite',      'category' => 'database', 'color' => '#003B57', 'order' => 14],

            // ── DevOps ────────────────────────────────────────────
            ['name' => 'Docker',      'category' => 'devops',   'color' => '#2496ED', 'order' => 15],
            ['name' => 'Git',         'category' => 'devops',   'color' => '#F05032', 'order' => 16],
            ['name' => 'GitLab',      'category' => 'devops',   'color' => '#FC6D26', 'order' => 17],
            ['name' => 'CI/CD',       'category' => 'devops',   'color' => '#2088FF', 'order' => 18],
            ['name' => 'Linux',       'category' => 'devops',   'color' => '#FCC624', 'order' => 19],
            ['name' => 'Scrum',       'category' => 'devops',   'color' => '#6DB33F', 'order' => 20],

            // ── Banco de Dados (extra) ────────────────────────────
            ['name' => 'Redis',       'category' => 'database', 'color' => '#DC382D', 'order' => 21],

            // ── Frontend (extra) ──────────────────────────────────
            ['name' => 'Angular',     'category' => 'frontend', 'color' => '#DD0031', 'order' => 22],

            // ── Cloud / Outros ────────────────────────────────────
            ['name' => 'AWS',         'category' => 'other',    'color' => '#FF9900', 'order' => 23],
            ['name' => 'Azure',       'category' => 'other',    'color' => '#0078D4', 'order' => 24],
            ['name' => 'OpenAI',      'category' => 'other',    'color' => '#10a37f', 'order' => 25],
            ['name' => 'N8N',         'category' => 'other',    'color' => '#EA4B71', 'order' => 26],
            ['name' => 'VPS',         'category' => 'other',    'color' => '#6366f1', 'order' => 27],
        ];

        foreach ($stacks as $stack) {
            Stack::firstOrCreate(
                ['slug' => Str::slug($stack['name'])],
                array_merge($stack, [
                    'slug'    => Str::slug($stack['name']),
                    'visible' => true,
                ])
            );
        }
    }
}
