<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    private array $stacks = [
        // ── Frontend (extra) ──────────────────────────────────────────
        ['name' => 'Angular',  'category' => 'frontend', 'color' => '#DD0031', 'order' => 22],

        // ── DevOps ────────────────────────────────────────────────────
        ['name' => 'Linux',    'category' => 'devops',   'color' => '#FCC624', 'order' => 19],
        ['name' => 'Scrum',    'category' => 'devops',   'color' => '#6DB33F', 'order' => 20],

        // ── Banco de Dados (extra) ────────────────────────────────────
        ['name' => 'Redis',    'category' => 'database', 'color' => '#DC382D', 'order' => 21],

        // ── Cloud / Outros ────────────────────────────────────────────
        ['name' => 'Azure',    'category' => 'other',    'color' => '#0078D4', 'order' => 24],
        ['name' => 'OpenAI',   'category' => 'other',    'color' => '#10a37f', 'order' => 25],
        ['name' => 'N8N',      'category' => 'other',    'color' => '#EA4B71', 'order' => 26],
        ['name' => 'VPS',      'category' => 'other',    'color' => '#6366f1', 'order' => 27],
    ];

    public function up(): void
    {
        $now = now();

        foreach ($this->stacks as $stack) {
            $slug = Str::slug($stack['name']);

            $exists = DB::table('stacks')->where('slug', $slug)->exists();

            if (! $exists) {
                DB::table('stacks')->insert([
                    'name'       => $stack['name'],
                    'slug'       => $slug,
                    'category'   => $stack['category'],
                    'color'      => $stack['color'],
                    'order'      => $stack['order'],
                    'visible'    => true,
                    'icon_url'   => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        $slugs = array_map(fn ($s) => Str::slug($s['name']), $this->stacks);
        DB::table('stacks')->whereIn('slug', $slugs)->delete();
    }
};
