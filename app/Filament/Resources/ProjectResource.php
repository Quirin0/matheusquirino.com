<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-code-bracket-square';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?string $navigationLabel = 'Projetos';
    protected static ?string $modelLabel = 'Projeto';
    protected static ?string $pluralModelLabel = 'Projetos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informações Básicas')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug (URL)')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\Textarea::make('description')
                        ->label('Descrição curta')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Descrição Completa')
                ->schema([
                    Forms\Components\RichEditor::make('full_description')
                        ->label('')
                        ->toolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'heading',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('projects/attachments')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Mídia e Links')
                ->schema([
                    Forms\Components\FileUpload::make('image_url')
                        ->label('Imagem do projeto')
                        ->image()
                        ->disk('public')
                        ->directory('projects/images')
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('675')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('live_url')
                        ->label('URL ao vivo')
                        ->url()
                        ->placeholder('https://seusite.com')
                        ->prefix('🔗'),

                    Forms\Components\TextInput::make('github_url')
                        ->label('GitHub')
                        ->url()
                        ->placeholder('https://github.com/...')
                        ->prefix('🐙'),
                ])->columns(2),

            Forms\Components\Section::make('Tags e Configurações')
                ->schema([
                    Forms\Components\TagsInput::make('tags')
                        ->label('Tags / Tecnologias')
                        ->placeholder('Adicionar tag...')
                        ->columnSpanFull(),

                    Forms\Components\Toggle::make('featured')
                        ->label('Projeto destaque')
                        ->default(false),

                    Forms\Components\TextInput::make('order')
                        ->label('Ordem de exibição')
                        ->numeric()
                        ->default(0),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Imagem')
                    ->disk('public')
                    ->height(50)
                    ->width(80),

                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tags')
                    ->label('Tags')
                    ->badge()
                    ->color('primary')
                    ->separator(','),

                Tables\Columns\IconColumn::make('featured')
                    ->label('Destaque')
                    ->boolean(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Ordem')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Destaque'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Apagar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
