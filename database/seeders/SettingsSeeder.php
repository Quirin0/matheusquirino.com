<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // General / Site
            ['group' => 'general', 'key' => 'site.logo_text',        'value' => '<MatheusQuirino />'],
            ['group' => 'general', 'key' => 'site.hero_name',        'value' => "Hello World_"],
            ['group' => 'general', 'key' => 'site.hero_title',       'value' => "Desenvolvedor\nFullstack Junior"],
            ['group' => 'general', 'key' => 'site.hero_description', 'value' => 'Apaixonado por criar soluções web modernas e eficientes. Especializado em PHP, Laravel, React e tecnologias que transformam ideias em realidade digital.'],
            ['group' => 'general', 'key' => 'site.profile_photo',    'value' => ''],

            // Contact
            ['group' => 'contact', 'key' => 'contact.email',    'value' => 'matheus@exemplo.com'],
            ['group' => 'contact', 'key' => 'contact.phone',    'value' => '+55 11 99999-9999'],
            ['group' => 'contact', 'key' => 'contact.location', 'value' => 'São Paulo, SP — Brasil'],

            // Social
            ['group' => 'social', 'key' => 'social.github',   'value' => 'https://github.com/matheusquirino'],
            ['group' => 'social', 'key' => 'social.linkedin',  'value' => 'https://linkedin.com/in/matheusquirino'],
            ['group' => 'social', 'key' => 'social.email',    'value' => 'matheus@exemplo.com'],

            // Colors (CSS variables)
            ['group' => 'colors', 'key' => 'colors.primary',    'value' => '#6366f1'],
            ['group' => 'colors', 'key' => 'colors.secondary',  'value' => '#1e1b4b'],
            ['group' => 'colors', 'key' => 'colors.accent',     'value' => '#a5b4fc'],
            ['group' => 'colors', 'key' => 'colors.background', 'value' => '#09090b'],
            ['group' => 'colors', 'key' => 'colors.surface',    'value' => '#18181b'],
            ['group' => 'colors', 'key' => 'colors.text',       'value' => '#fafafa'],

            // SEO
            ['group' => 'seo', 'key' => 'seo.home_title',       'value' => 'Matheus Quirino — Desenvolvedor Fullstack'],
            ['group' => 'seo', 'key' => 'seo.home_description', 'value' => 'Portfólio de Matheus Quirino, desenvolvedor fullstack especializado em PHP, Laravel e React.'],
            ['group' => 'seo', 'key' => 'seo.home_keywords',    'value' => 'desenvolvedor, fullstack, PHP, Laravel, React, portfólio'],
            ['group' => 'seo', 'key' => 'seo.og_image',         'value' => '/frontend/icon.svg'],
            ['group' => 'seo', 'key' => 'seo.robots',           'value' => 'index, follow'],

            // SMTP
            ['group' => 'smtp', 'key' => 'smtp.host',       'value' => 'smtp.gmail.com'],
            ['group' => 'smtp', 'key' => 'smtp.port',       'value' => '587'],
            ['group' => 'smtp', 'key' => 'smtp.username',   'value' => ''],
            ['group' => 'smtp', 'key' => 'smtp.password',   'value' => ''],
            ['group' => 'smtp', 'key' => 'smtp.from_name',  'value' => 'Matheus Quirino'],
            ['group' => 'smtp', 'key' => 'smtp.encryption', 'value' => 'tls'],
        ];

        foreach ($defaults as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
