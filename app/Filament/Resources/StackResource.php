<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StackResource\Pages;
use App\Models\Stack;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StackResource extends Resource
{
    protected static ?string $model = Stack::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?string $navigationLabel = 'Stacks';
    protected static ?string $modelLabel = 'Stack';
    protected static ?string $pluralModelLabel = 'Stacks';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('category')
                    ->label('Categoria')
                    ->options(Stack::categories())
                    ->required(),

                Forms\Components\ColorPicker::make('color')
                    ->label('Cor')
                    ->default('#6366f1'),

                Forms\Components\TextInput::make('icon_url')
                    ->label('URL do ícone (SVG/PNG)')
                    ->url()
                    ->placeholder('https://cdn.simpleicons.org/laravel')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('order')
                    ->label('Ordem')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('visible')
                    ->label('Visível no site')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')
                    ->label('Cor'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Categoria')
                    ->formatStateUsing(fn ($state) => Stack::categories()[$state] ?? $state)
                    ->colors([
                        'primary'   => 'frontend',
                        'success'   => 'backend',
                        'warning'   => 'database',
                        'danger'    => 'devops',
                        'secondary' => 'mobile',
                    ]),

                Tables\Columns\IconColumn::make('visible')
                    ->label('Visível')
                    ->boolean(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Ordem')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoria')
                    ->options(Stack::categories()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStacks::route('/'),
            'create' => Pages\CreateStack::route('/create'),
            'edit'   => Pages\EditStack::route('/{record}/edit'),
        ];
    }
}
