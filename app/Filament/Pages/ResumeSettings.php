<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ResumeSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?string $navigationLabel = 'Currículo / Sobre';
    protected static ?string $title           = 'Currículo & Sobre Mim';
    protected static string $view             = 'filament.pages.resume-settings';
    protected static ?int $navigationSort     = 3;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'personal_statement' => Setting::get('resume.personal_statement',
                'Atuo com desenvolvimento de software desde 2018, participando da criação e manutenção de aplicações web que recebem centenas de acessos diariamente. Possuo experiência em ambientes colaborativos, desenvolvimento fullstack e backend, com foco em código limpo, performance e boas práticas.'
            ),
            'cv_file' => Setting::get('resume.cv_file') ? [Setting::get('resume.cv_file')] : null,
            'differentials' => json_decode(Setting::get('resume.differentials', '[]'), true) ?: [
                ['text' => 'Construção de projetos completos (frontend + backend + deploy)'],
                ['text' => 'Integração com APIs externas e automações (ex: pagamentos, scraping, IA)'],
                ['text' => 'Noções de infraestrutura (VPS, Docker, CI/CD)'],
            ],
            'experiences' => json_decode(Setting::get('resume.experiences', '[]'), true) ?: [
                [
                    'role'       => 'Programador Fullstack Júnior',
                    'company'    => 'Virtua Brasil',
                    'type'       => 'Presencial',
                    'period'     => 'Outubro 2020 – Janeiro 2021',
                    'color'      => '#a78bfa',
                    'highlights' => [
                        ['text' => 'Atuei em conjunto com uma equipe de desenvolvedores no desenvolvimento de websites e sistemas web, utilizando HTML, CSS, PHP, JavaScript e MySQL.'],
                        ['text' => 'Desenvolvi sistemas administrativos voltados ao gerenciamento e manipulação de dados em banco de dados.'],
                        ['text' => 'Criei soluções de design responsivo, garantindo melhor experiência do usuário (UX) em diferentes dispositivos.'],
                    ],
                    'tags' => 'HTML, CSS, PHP, JavaScript, MySQL',
                ],
                [
                    'role'       => 'Programador Backend Júnior',
                    'company'    => 'Uappi',
                    'type'       => 'Remoto',
                    'period'     => 'Março 2022 – Junho 2024',
                    'color'      => '#61DAFB',
                    'highlights' => [
                        ['text' => 'Atuei no desenvolvimento e manutenção de sites de grandes empresas, como Growth Supplements, Daikin, Desinchá, Leveros, entre outras.'],
                        ['text' => 'Trabalhei com tecnologias e frameworks modernos, incluindo Docker, Laravel, React, Angular, HeidiSQL, Git e GitHub.'],
                        ['text' => 'Desenvolvi habilidades de trabalho em equipe, seguindo metodologias ágeis como Scrum, além de práticas de CI/CD para integração e entrega contínua.'],
                    ],
                    'tags' => 'Docker, Laravel, React, Angular, Git, CI/CD, Scrum',
                ],
            ],
            'education' => json_decode(Setting::get('resume.education', '[]'), true) ?: [
                [
                    'degree'      => 'Técnico em Informática para Internet',
                    'institution' => 'ETEC Dr. Geraldo José Rodrigues Alckmin',
                    'period'      => '2018 – 2019',
                    'status'      => 'Concluído',
                    'color'       => '#a78bfa',
                    'description' => 'Formação técnica com foco em desenvolvimento web, lógica de programação, banco de dados e infraestrutura de redes. Base que impulsionou minha entrada no mercado de tecnologia.',
                ],
                [
                    'degree'      => 'Engenharia de Software',
                    'institution' => 'UniCesumar',
                    'period'      => '2026 – 2030',
                    'status'      => 'Em andamento · EAD',
                    'color'       => '#61DAFB',
                    'description' => 'Graduação em Engenharia de Software com foco em fundamentos de engenharia, arquitetura de sistemas, qualidade de software e gestão de projetos tecnológicos.',
                ],
            ],
            'stats' => json_decode(Setting::get('resume.stats', '[]'), true) ?: [
                ['value' => '7+',   'label' => 'Anos de experiência'],
                ['value' => '2',    'label' => 'Empresas atuadas'],
                ['value' => '50+',  'label' => 'Projetos entregues'],
                ['value' => '2018', 'label' => 'Início na área'],
            ],
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([

            Section::make('Afirmação Pessoal')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    Textarea::make('personal_statement')
                        ->label('Texto da afirmação pessoal')
                        ->rows(5)
                        ->columnSpanFull(),
                ]),

            Section::make('Currículo (PDF)')
                ->icon('heroicon-o-arrow-down-tray')
                ->description('O botão "Ver Currículo" na seção de experiência aponta para este arquivo.')
                ->schema([
                    FileUpload::make('cv_file')
                        ->label('Arquivo PDF do currículo')
                        ->disk('public')
                        ->directory('cv')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(5120)
                        ->columnSpanFull(),
                ]),

            Section::make('Diferenciais')
                ->icon('heroicon-o-star')
                ->schema([
                    Repeater::make('differentials')
                        ->label('Lista de diferenciais')
                        ->schema([
                            TextInput::make('text')
                                ->label('Diferencial')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Adicionar diferencial')
                        ->collapsible()
                        ->columnSpanFull(),
                ]),

            Section::make('Experiências Profissionais')
                ->icon('heroicon-o-briefcase')
                ->schema([
                    Repeater::make('experiences')
                        ->label('Entradas de experiência')
                        ->schema([
                            TextInput::make('role')
                                ->label('Cargo')
                                ->required(),

                            TextInput::make('company')
                                ->label('Empresa')
                                ->required(),

                            TextInput::make('type')
                                ->label('Modalidade (ex: Presencial, Remoto)')
                                ->required(),

                            TextInput::make('period')
                                ->label('Período (ex: Jan 2022 – Jun 2024)')
                                ->required(),

                            ColorPicker::make('color')
                                ->label('Cor de destaque')
                                ->default('#6366f1'),

                            TextInput::make('tags')
                                ->label('Tags (separadas por vírgula)')
                                ->placeholder('Laravel, Docker, React')
                                ->columnSpanFull(),

                            Repeater::make('highlights')
                                ->label('Pontos de destaque')
                                ->schema([
                                    Textarea::make('text')
                                        ->label('Ponto')
                                        ->rows(2)
                                        ->required()
                                        ->columnSpanFull(),
                                ])
                                ->addActionLabel('Adicionar ponto')
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Adicionar experiência')
                        ->collapsible()
                        ->columns(2)
                        ->columnSpanFull(),
                ]),

            Section::make('Formação Acadêmica')
                ->icon('heroicon-o-academic-cap')
                ->schema([
                    Repeater::make('education')
                        ->label('Entradas de formação')
                        ->schema([
                            TextInput::make('degree')
                                ->label('Curso / Grau')
                                ->required()
                                ->columnSpanFull(),

                            TextInput::make('institution')
                                ->label('Instituição')
                                ->required(),

                            TextInput::make('period')
                                ->label('Período (ex: 2018 – 2019)')
                                ->required(),

                            TextInput::make('status')
                                ->label('Status (ex: Concluído, Em andamento)')
                                ->required(),

                            ColorPicker::make('color')
                                ->label('Cor de destaque')
                                ->default('#6366f1'),

                            Textarea::make('description')
                                ->label('Descrição')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('Adicionar formação')
                        ->collapsible()
                        ->columns(2)
                        ->columnSpanFull(),
                ]),

            Section::make('Estatísticas')
                ->icon('heroicon-o-chart-bar')
                ->description('Números exibidos abaixo da seção de formação acadêmica.')
                ->schema([
                    Repeater::make('stats')
                        ->label('Estatísticas')
                        ->schema([
                            TextInput::make('value')
                                ->label('Valor (ex: 7+, 50+)')
                                ->required(),
                            TextInput::make('label')
                                ->label('Rótulo (ex: Anos de experiência)')
                                ->required(),
                        ])
                        ->addActionLabel('Adicionar estatística')
                        ->columns(2)
                        ->columnSpanFull(),
                ]),

        ])->statePath('data');
    }

    public function save(): void
    {
        $d = $this->form->getState();

        // CV file upload
        $cvFiles = $d['cv_file'] ?? [];
        $cvPath  = is_array($cvFiles) ? (reset($cvFiles) ?: '') : ($cvFiles ?? '');
        if ($cvPath) {
            Setting::set('resume.cv_file', $cvPath, 'resume');
        }

        Setting::set('resume.personal_statement', $d['personal_statement'] ?? '', 'resume');
        Setting::set('resume.differentials',       json_encode($d['differentials'] ?? []), 'resume');
        Setting::set('resume.experiences',         json_encode($d['experiences']   ?? []), 'resume');
        Setting::set('resume.education',           json_encode($d['education']     ?? []), 'resume');
        Setting::set('resume.stats',               json_encode($d['stats']         ?? []), 'resume');

        Notification::make()
            ->title('Configurações do currículo salvas com sucesso!')
            ->success()
            ->send();
    }
}
