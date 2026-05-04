<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

class DatabaseTools extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?string $navigationLabel = 'Ferramentas do Banco';
    protected static ?string $title           = 'Ferramentas do Banco de Dados';
    protected static string $view             = 'filament.pages.database-tools';
    protected static ?int $navigationSort     = 10;

    public string $migrateOutput = '';
    public string $migrateStatus = '';

    public function runMigrate(): void
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $this->migrateOutput = Artisan::output();
            $this->migrateStatus = 'success';

            Notification::make()
                ->title('Migrate executado com sucesso!')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            $this->migrateOutput = $e->getMessage();
            $this->migrateStatus = 'error';

            Notification::make()
                ->title('Erro ao executar migrate')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function runMigrateStatus(): void
    {
        try {
            Artisan::call('migrate:status');
            $this->migrateOutput = Artisan::output();
            $this->migrateStatus = 'info';

            Notification::make()
                ->title('Status das migrations carregado')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            $this->migrateOutput = $e->getMessage();
            $this->migrateStatus = 'error';

            Notification::make()
                ->title('Erro ao verificar status')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function runSeedStacks(): void
    {
        try {
            Artisan::call('db:seed', ['--class' => 'StackSeeder', '--force' => true]);
            $this->migrateOutput = Artisan::output() ?: 'Stacks sincronizadas com sucesso.';
            $this->migrateStatus = 'success';

            Notification::make()
                ->title('StackSeeder executado!')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            $this->migrateOutput = $e->getMessage();
            $this->migrateStatus = 'error';

            Notification::make()
                ->title('Erro ao executar seeder')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function runCacheClear(): void
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            $this->migrateOutput = "Cache e configurações limpos com sucesso.\n";
            $this->migrateStatus = 'success';

            Notification::make()
                ->title('Cache limpo!')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            $this->migrateOutput = $e->getMessage();
            $this->migrateStatus = 'error';

            Notification::make()
                ->title('Erro ao limpar cache')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
