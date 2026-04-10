<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SeoSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationGroup = 'Site';
    protected static ?string $navigationLabel = 'SEO';
    protected static ?string $title           = 'Configurações de SEO';
    protected static string $view             = 'filament.pages.seo-settings';
    protected static ?int $navigationSort     = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            // Meta básico
            'seo_home_title'       => Setting::get('seo.home_title'),
            'seo_home_description' => Setting::get('seo.home_description'),
            'seo_home_keywords'    => Setting::get('seo.home_keywords'),
            'seo_canonical_url'    => Setting::get('seo.canonical_url'),
            'seo_robots'           => Setting::get('seo.robots', 'index, follow'),

            // Open Graph
            'seo_og_title'       => Setting::get('seo.og_title'),
            'seo_og_description' => Setting::get('seo.og_description'),
            'seo_og_image'       => Setting::get('seo.og_image') ? [Setting::get('seo.og_image')] : null,
            'seo_og_type'        => Setting::get('seo.og_type', 'website'),
            'seo_og_locale'      => Setting::get('seo.og_locale', 'pt_BR'),

            // Twitter Card
            'seo_twitter_card'        => Setting::get('seo.twitter_card', 'summary_large_image'),
            'seo_twitter_site'        => Setting::get('seo.twitter_site'),
            'seo_twitter_creator'     => Setting::get('seo.twitter_creator'),
            'seo_twitter_title'       => Setting::get('seo.twitter_title'),
            'seo_twitter_description' => Setting::get('seo.twitter_description'),
            'seo_twitter_image'       => Setting::get('seo.twitter_image') ? [Setting::get('seo.twitter_image')] : null,

            // Analytics
            'seo_google_analytics'    => Setting::get('seo.google_analytics'),
            'seo_google_tag_manager'  => Setting::get('seo.google_tag_manager'),
            'seo_google_site_verify'  => Setting::get('seo.google_site_verify'),

            // Structured Data
            'seo_schema_name'        => Setting::get('seo.schema_name'),
            'seo_schema_job_title'   => Setting::get('seo.schema_job_title'),
            'seo_schema_description' => Setting::get('seo.schema_description'),
            'seo_schema_url'         => Setting::get('seo.schema_url'),
            'seo_schema_same_as'     => Setting::get('seo.schema_same_as'),

            // Avançado
            'seo_noindex_projetos' => Setting::get('seo.noindex_projetos', '0') === '1',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([

            // ── META BÁSICO ───────────────────────────────────────────────
            Section::make('Meta Tags — Página Inicial')
                ->icon('heroicon-o-tag')
                ->description('Tags básicas exibidas nos resultados do Google.')
                ->schema([
                    TextInput::make('seo_home_title')
                        ->label('Title (meta title)')
                        ->maxLength(60)
                        ->hint('Recomendado: 50–60 caracteres')
                        ->live(onBlur: true)
                        ->suffixAction(
                            \Filament\Forms\Components\Actions\Action::make('count_title')
                                ->icon('heroicon-o-calculator')
                                ->label(fn ($state) => strlen($state ?? '') . '/60')
                        )
                        ->columnSpanFull(),

                    Textarea::make('seo_home_description')
                        ->label('Description (meta description)')
                        ->rows(3)
                        ->maxLength(160)
                        ->hint('Recomendado: 120–160 caracteres')
                        ->columnSpanFull(),

                    TextInput::make('seo_home_keywords')
                        ->label('Keywords (separadas por vírgula)')
                        ->placeholder('desenvolvedor, fullstack, PHP, Laravel')
                        ->columnSpanFull(),

                    TextInput::make('seo_canonical_url')
                        ->label('URL canônica')
                        ->url()
                        ->placeholder('https://matheusquirino.com/frontend')
                        ->hint('Deixe vazio para usar a URL atual automaticamente'),

                    Select::make('seo_robots')
                        ->label('Diretiva robots')
                        ->options([
                            'index, follow'     => 'index, follow — Indexar e seguir links (padrão)',
                            'noindex, follow'   => 'noindex, follow — Não indexar',
                            'index, nofollow'   => 'index, nofollow — Não seguir links',
                            'noindex, nofollow' => 'noindex, nofollow — Bloquear tudo',
                        ]),
                ])->columns(2),

            // ── OPEN GRAPH ────────────────────────────────────────────────
            Section::make('Open Graph (Facebook / LinkedIn / WhatsApp)')
                ->icon('heroicon-o-share')
                ->description('Controla como o site aparece ao ser compartilhado nas redes sociais.')
                ->schema([
                    TextInput::make('seo_og_title')
                        ->label('OG Title')
                        ->placeholder('Deixe vazio para usar o meta title')
                        ->columnSpanFull(),

                    Textarea::make('seo_og_description')
                        ->label('OG Description')
                        ->rows(2)
                        ->placeholder('Deixe vazio para usar a meta description')
                        ->columnSpanFull(),

                    FileUpload::make('seo_og_image')
                        ->label('Imagem OG (1200×630 px recomendado)')
                        ->image()
                        ->disk('public')
                        ->directory('seo')
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('630')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048)
                        ->columnSpanFull(),

                    Select::make('seo_og_type')
                        ->label('OG Type')
                        ->options([
                            'website' => 'website',
                            'profile' => 'profile',
                            'article' => 'article',
                        ]),

                    TextInput::make('seo_og_locale')
                        ->label('OG Locale')
                        ->placeholder('pt_BR'),
                ])->columns(2),

            // ── TWITTER CARD ──────────────────────────────────────────────
            Section::make('Twitter / X Card')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->schema([
                    Select::make('seo_twitter_card')
                        ->label('Tipo de card')
                        ->options([
                            'summary'             => 'summary — Ícone pequeno',
                            'summary_large_image' => 'summary_large_image — Imagem grande',
                        ]),

                    TextInput::make('seo_twitter_site')
                        ->label('Twitter @site')
                        ->placeholder('@matheusquirino'),

                    TextInput::make('seo_twitter_creator')
                        ->label('Twitter @creator')
                        ->placeholder('@matheusquirino'),

                    TextInput::make('seo_twitter_title')
                        ->label('Twitter Title')
                        ->placeholder('Deixe vazio para usar o og:title'),

                    Textarea::make('seo_twitter_description')
                        ->label('Twitter Description')
                        ->rows(2)
                        ->placeholder('Deixe vazio para usar o og:description')
                        ->columnSpanFull(),

                    FileUpload::make('seo_twitter_image')
                        ->label('Imagem Twitter (800×418 px recomendado)')
                        ->image()
                        ->disk('public')
                        ->directory('seo')
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('418')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048)
                        ->columnSpanFull(),
                ])->columns(2),

            // ── ANALYTICS ────────────────────────────────────────────────
            Section::make('Analytics & Verificação')
                ->icon('heroicon-o-chart-bar')
                ->schema([
                    TextInput::make('seo_google_analytics')
                        ->label('Google Analytics ID')
                        ->placeholder('G-XXXXXXXXXX')
                        ->hint('Formato: G-XXXXXXXXXX'),

                    TextInput::make('seo_google_tag_manager')
                        ->label('Google Tag Manager ID')
                        ->placeholder('GTM-XXXXXXX')
                        ->hint('Formato: GTM-XXXXXXX'),

                    TextInput::make('seo_google_site_verify')
                        ->label('Google Search Console — meta verify')
                        ->placeholder('xxxxxxxxxxxxxxxxxxx')
                        ->hint('Somente o valor do content='),
                ])->columns(3),

            // ── STRUCTURED DATA (JSON-LD) ─────────────────────────────────
            Section::make('Dados Estruturados — JSON-LD (Schema.org)')
                ->icon('heroicon-o-code-bracket')
                ->description('Ajuda o Google a entender quem você é e exibir rich results.')
                ->schema([
                    TextInput::make('seo_schema_name')
                        ->label('Nome completo (Person)')
                        ->placeholder('Matheus Quirino'),

                    TextInput::make('seo_schema_job_title')
                        ->label('Cargo / Título profissional')
                        ->placeholder('Desenvolvedor Fullstack'),

                    TextInput::make('seo_schema_url')
                        ->label('URL do site')
                        ->url()
                        ->placeholder('https://matheusquirino.com'),

                    Textarea::make('seo_schema_description')
                        ->label('Descrição profissional')
                        ->rows(2)
                        ->columnSpanFull(),

                    Textarea::make('seo_schema_same_as')
                        ->label('sameAs — URLs dos perfis (uma por linha)')
                        ->rows(3)
                        ->placeholder("https://github.com/matheusquirino\nhttps://linkedin.com/in/matheusquirino")
                        ->hint('Lista de perfis públicos para o Google associar à sua identidade')
                        ->columnSpanFull(),
                ])->columns(2),

            // ── AVANÇADO ──────────────────────────────────────────────────
            Section::make('Configurações Avançadas')
                ->icon('heroicon-o-adjustments-horizontal')
                ->schema([
                    Toggle::make('seo_noindex_projetos')
                        ->label('Aplicar noindex nas páginas individuais de projetos')
                        ->helperText('Útil quando os projetos são apenas exemplos e você não quer que sejam indexados.'),
                ])->columns(1),

        ])->statePath('data');
    }

    public function save(): void
    {
        $d = $this->form->getState();

        $fileFields = [
            'seo.og_image'      => 'seo_og_image',
            'seo.twitter_image' => 'seo_twitter_image',
        ];

        // Salvar campos de arquivo (FileUpload retorna array)
        foreach ($fileFields as $key => $field) {
            $files = $d[$field] ?? [];
            $path  = is_array($files) ? (reset($files) ?: '') : ($files ?? '');
            Setting::set($key, $path, 'seo');
        }

        $textFields = [
            'seo.home_title'        => 'seo_home_title',
            'seo.home_description'  => 'seo_home_description',
            'seo.home_keywords'     => 'seo_home_keywords',
            'seo.canonical_url'     => 'seo_canonical_url',
            'seo.robots'            => 'seo_robots',
            'seo.og_title'          => 'seo_og_title',
            'seo.og_description'    => 'seo_og_description',
            'seo.og_type'           => 'seo_og_type',
            'seo.og_locale'         => 'seo_og_locale',
            'seo.twitter_card'      => 'seo_twitter_card',
            'seo.twitter_site'      => 'seo_twitter_site',
            'seo.twitter_creator'   => 'seo_twitter_creator',
            'seo.twitter_title'     => 'seo_twitter_title',
            'seo.twitter_description' => 'seo_twitter_description',
            'seo.google_analytics'  => 'seo_google_analytics',
            'seo.google_tag_manager'=> 'seo_google_tag_manager',
            'seo.google_site_verify'=> 'seo_google_site_verify',
            'seo.schema_name'       => 'seo_schema_name',
            'seo.schema_job_title'  => 'seo_schema_job_title',
            'seo.schema_description'=> 'seo_schema_description',
            'seo.schema_url'        => 'seo_schema_url',
            'seo.schema_same_as'    => 'seo_schema_same_as',
            'seo.noindex_projetos'  => 'seo_noindex_projetos',
        ];

        foreach ($textFields as $key => $field) {
            $value = $d[$field] ?? '';
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }
            Setting::set($key, $value, 'seo');
        }

        Notification::make()
            ->title('SEO salvo com sucesso!')
            ->success()
            ->send();
    }
}
