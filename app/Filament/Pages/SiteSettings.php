<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?string $navigationLabel = 'Configurações';
    protected static ?string $title           = 'Configurações do Site';
    protected static string $view             = 'filament.pages.site-settings';
    protected static ?int $navigationSort     = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            // Site / Hero
            'site_logo_text'        => Setting::get('site.logo_text', '<MatheusQuirino />'),
            'site_hero_name'        => Setting::get('site.hero_name', 'Hello World_'),
            'site_hero_title'       => Setting::get('site.hero_title'),
            'site_hero_description' => Setting::get('site.hero_description'),
            'site_profile_photo'    => Setting::get('site.profile_photo') ? [Setting::get('site.profile_photo')] : null,

            // Contato
            'contact_email'    => Setting::get('contact.email'),
            'contact_phone'    => Setting::get('contact.phone'),
            'contact_location' => Setting::get('contact.location'),

            // Redes sociais
            'social_github'   => Setting::get('social.github'),
            'social_linkedin' => Setting::get('social.linkedin'),
            'social_email'    => Setting::get('social.email'),

            // SMTP
            'smtp_host'       => Setting::get('smtp.host'),
            'smtp_port'       => Setting::get('smtp.port'),
            'smtp_username'   => Setting::get('smtp.username'),
            'smtp_password'   => Setting::get('smtp.password'),
            'smtp_from_name'  => Setting::get('smtp.from_name'),
            'smtp_encryption' => Setting::get('smtp.encryption'),

            // Cores
            'color_primary'    => Setting::get('colors.primary', '#6366f1'),
            'color_secondary'  => Setting::get('colors.secondary', '#1e1b4b'),
            'color_accent'     => Setting::get('colors.accent', '#a5b4fc'),
            'color_background' => Setting::get('colors.background', '#09090b'),
            'color_surface'    => Setting::get('colors.surface', '#18181b'),
            'color_text'       => Setting::get('colors.text', '#fafafa'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Identidade Visual — Textos e Foto')
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    TextInput::make('site_logo_text')
                        ->label('Texto da logomarca')
                        ->placeholder('<MatheusQuirino />')
                        ->columnSpanFull(),

                    TextInput::make('site_hero_name')
                        ->label('Nome / Título principal')
                        ->placeholder('Hello World_'),

                    TextInput::make('site_hero_title')
                        ->label('Subtítulo (função)')
                        ->placeholder("Desenvolvedor\nFullstack Junior"),

                    Textarea::make('site_hero_description')
                        ->label('Descrição do hero')
                        ->rows(4)
                        ->columnSpanFull(),

                    FileUpload::make('site_profile_photo')
                        ->label('Foto de perfil (exibida no hero)')
                        ->image()
                        ->disk('public')
                        ->directory('profile')
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeTargetWidth('400')
                        ->imageResizeTargetHeight('400')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048)
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Cores do Site')
                ->icon('heroicon-o-swatch')
                ->description('As cores são aplicadas dinamicamente via CSS variables.')
                ->schema([
                    ColorPicker::make('color_primary')
                        ->label('Cor primária (destaques, botões)'),
                    ColorPicker::make('color_secondary')
                        ->label('Cor secundária'),
                    ColorPicker::make('color_accent')
                        ->label('Cor de acento'),
                    ColorPicker::make('color_background')
                        ->label('Cor de fundo'),
                    ColorPicker::make('color_surface')
                        ->label('Cor de superfície (cards)'),
                    ColorPicker::make('color_text')
                        ->label('Cor do texto'),
                ])->columns(3),

            Section::make('Informações de Contato')
                ->icon('heroicon-o-envelope')
                ->schema([
                    TextInput::make('contact_email')
                        ->label('E-mail')
                        ->email(),
                    TextInput::make('contact_phone')
                        ->label('Telefone / WhatsApp'),
                    TextInput::make('contact_location')
                        ->label('Localização')
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Redes Sociais')
                ->icon('heroicon-o-share')
                ->schema([
                    TextInput::make('social_github')
                        ->label('GitHub URL')
                        ->url()
                        ->prefix('🐙'),
                    TextInput::make('social_linkedin')
                        ->label('LinkedIn URL')
                        ->url()
                        ->prefix('💼'),
                    TextInput::make('social_email')
                        ->label('E-mail público')
                        ->email()
                        ->prefix('✉️'),
                ])->columns(3),

            Section::make('Configuração SMTP (Formulário de Contato)')
                ->icon('heroicon-o-paper-airplane')
                ->description('Configure o servidor de e-mail para o formulário de contato do site.')
                ->schema([
                    TextInput::make('smtp_host')
                        ->label('Host SMTP')
                        ->placeholder('smtp.gmail.com'),
                    TextInput::make('smtp_port')
                        ->label('Porta')
                        ->numeric()
                        ->placeholder('587'),
                    TextInput::make('smtp_username')
                        ->label('Usuário')
                        ->email(),
                    TextInput::make('smtp_password')
                        ->label('Senha')
                        ->password()
                        ->revealable(),
                    TextInput::make('smtp_from_name')
                        ->label('Nome de envio'),
                    TextInput::make('smtp_encryption')
                        ->label('Criptografia')
                        ->placeholder('tls'),
                ])->columns(3),
        ])->statePath('data');
    }

    public function save(): void
    {
        $d = $this->form->getState();

        // Tratar upload da foto de perfil separadamente
        $profileFiles = $d['site_profile_photo'] ?? [];
        $profilePath  = is_array($profileFiles) ? (reset($profileFiles) ?: '') : ($profileFiles ?? '');
        if ($profilePath) {
            Setting::set('site.profile_photo', $profilePath, 'general');
        }

        $map = [
            'site.logo_text'        => ['site_logo_text',        'general'],
            'site.hero_name'        => ['site_hero_name',         'general'],
            'site.hero_title'       => ['site_hero_title',        'general'],
            'site.hero_description' => ['site_hero_description',  'general'],
            'contact.email'        => ['contact_email',         'contact'],
            'contact.phone'        => ['contact_phone',         'contact'],
            'contact.location'     => ['contact_location',      'contact'],
            'social.github'        => ['social_github',         'social'],
            'social.linkedin'      => ['social_linkedin',       'social'],
            'social.email'         => ['social_email',          'social'],
            'smtp.host'            => ['smtp_host',             'smtp'],
            'smtp.port'            => ['smtp_port',             'smtp'],
            'smtp.username'        => ['smtp_username',         'smtp'],
            'smtp.password'        => ['smtp_password',         'smtp'],
            'smtp.from_name'       => ['smtp_from_name',        'smtp'],
            'smtp.encryption'      => ['smtp_encryption',       'smtp'],
            'colors.primary'       => ['color_primary',         'colors'],
            'colors.secondary'     => ['color_secondary',       'colors'],
            'colors.accent'        => ['color_accent',          'colors'],
            'colors.background'    => ['color_background',      'colors'],
            'colors.surface'       => ['color_surface',         'colors'],
            'colors.text'          => ['color_text',            'colors'],
        ];

        foreach ($map as $key => [$field, $group]) {
            Setting::set($key, $d[$field] ?? '', $group);
        }

        Notification::make()
            ->title('Configurações salvas com sucesso!')
            ->success()
            ->send();
    }
}
