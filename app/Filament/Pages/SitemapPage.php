<?php

namespace App\Filament\Pages;

use App\Models\Project;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SitemapPage extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Site';
    protected static ?string $navigationLabel = 'Sitemap';
    protected static ?string $title           = 'Gerador de Sitemap';
    protected static string $view             = 'filament.pages.sitemap';
    protected static ?int $navigationSort     = 2;

    public string $sitemapContent = '';
    public string $lastGenerated  = '';

    public function mount(): void
    {
        $sitemapPath = public_path('sitemap.xml');
        if (file_exists($sitemapPath)) {
            $this->sitemapContent = file_get_contents($sitemapPath);
            $this->lastGenerated  = date('d/m/Y H:i:s', filemtime($sitemapPath));
        }
    }

    public function generate(): void
    {
        $baseUrl  = config('app.url');
        $projects = Project::select('slug', 'updated_at')->get();
        $now      = now()->toAtomString();

        $urls = [
            ['loc' => $baseUrl . '/frontend',          'priority' => '1.0', 'freq' => 'weekly', 'updated' => $now],
            ['loc' => $baseUrl . '/frontend/projetos', 'priority' => '0.8', 'freq' => 'weekly', 'updated' => $now],
        ];

        foreach ($projects as $project) {
            $urls[] = [
                'loc'     => $baseUrl . '/frontend/projetos/' . $project->slug,
                'priority' => '0.7',
                'freq'    => 'monthly',
                'updated' => $project->updated_at->toAtomString(),
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url['loc']}</loc>\n";
            $xml .= "    <lastmod>{$url['updated']}</lastmod>\n";
            $xml .= "    <changefreq>{$url['freq']}</changefreq>\n";
            $xml .= "    <priority>{$url['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $xml);

        $this->sitemapContent = $xml;
        $this->lastGenerated  = now()->format('d/m/Y H:i:s');

        Notification::make()
            ->title('Sitemap gerado com sucesso!')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Gerar Sitemap')
                ->icon('heroicon-o-arrow-path')
                ->action('generate')
                ->color('primary'),
        ];
    }
}
