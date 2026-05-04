<x-filament-panels::page>

    {{-- Ações rápidas --}}
    <x-filament::section>
        <x-slot name="heading">Ações Disponíveis</x-slot>
        <x-slot name="description">Execute comandos do Artisan diretamente pelo painel. O output será exibido abaixo.</x-slot>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Migrate --}}
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-arrow-up-circle" class="h-5 w-5 text-primary-500" />
                    <span class="font-semibold text-sm text-gray-900 dark:text-white">php artisan migrate</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    Executa todas as migrations pendentes no banco de dados.
                </p>
                <x-filament::button
                    wire:click="runMigrate"
                    wire:loading.attr="disabled"
                    icon="heroicon-o-play"
                    color="primary"
                    size="sm"
                    class="mt-auto"
                >
                    <span wire:loading.remove wire:target="runMigrate">Executar Migrate</span>
                    <span wire:loading wire:target="runMigrate">Executando...</span>
                </x-filament::button>
            </div>

            {{-- Migrate Status --}}
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-magnifying-glass" class="h-5 w-5 text-info-500" />
                    <span class="font-semibold text-sm text-gray-900 dark:text-white">migrate:status</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    Lista o status de todas as migrations (executadas ou pendentes).
                </p>
                <x-filament::button
                    wire:click="runMigrateStatus"
                    wire:loading.attr="disabled"
                    icon="heroicon-o-eye"
                    color="info"
                    size="sm"
                    class="mt-auto"
                >
                    <span wire:loading.remove wire:target="runMigrateStatus">Ver Status</span>
                    <span wire:loading wire:target="runMigrateStatus">Carregando...</span>
                </x-filament::button>
            </div>

            {{-- Seed Stacks --}}
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-cpu-chip" class="h-5 w-5 text-success-500" />
                    <span class="font-semibold text-sm text-gray-900 dark:text-white">StackSeeder</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    Sincroniza as stacks padrão no banco sem duplicar registros existentes.
                </p>
                <x-filament::button
                    wire:click="runSeedStacks"
                    wire:loading.attr="disabled"
                    icon="heroicon-o-arrow-path"
                    color="success"
                    size="sm"
                    class="mt-auto"
                >
                    <span wire:loading.remove wire:target="runSeedStacks">Sincronizar Stacks</span>
                    <span wire:loading wire:target="runSeedStacks">Sincronizando...</span>
                </x-filament::button>
            </div>

            {{-- Cache Clear --}}
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-5 flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-trash" class="h-5 w-5 text-warning-500" />
                    <span class="font-semibold text-sm text-gray-900 dark:text-white">cache:clear</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    Limpa o cache da aplicação e das configurações do Laravel.
                </p>
                <x-filament::button
                    wire:click="runCacheClear"
                    wire:loading.attr="disabled"
                    icon="heroicon-o-x-circle"
                    color="warning"
                    size="sm"
                    class="mt-auto"
                >
                    <span wire:loading.remove wire:target="runCacheClear">Limpar Cache</span>
                    <span wire:loading wire:target="runCacheClear">Limpando...</span>
                </x-filament::button>
            </div>

        </div>
    </x-filament::section>

    {{-- Output --}}
    @if($migrateOutput)
        <x-filament::section class="mt-6">
            <x-slot name="heading">Output do Comando</x-slot>

            <div class="rounded-lg overflow-hidden border
                {{ $migrateStatus === 'success' ? 'border-success-300 dark:border-success-700' : '' }}
                {{ $migrateStatus === 'error'   ? 'border-danger-300 dark:border-danger-700'   : '' }}
                {{ $migrateStatus === 'info'    ? 'border-info-300 dark:border-info-700'       : '' }}
            ">
                <div class="px-3 py-2 text-[10px] font-mono font-semibold uppercase tracking-widest
                    {{ $migrateStatus === 'success' ? 'bg-success-50 dark:bg-success-900/30 text-success-700 dark:text-success-300' : '' }}
                    {{ $migrateStatus === 'error'   ? 'bg-danger-50 dark:bg-danger-900/30 text-danger-700 dark:text-danger-300'     : '' }}
                    {{ $migrateStatus === 'info'    ? 'bg-info-50 dark:bg-info-900/30 text-info-700 dark:text-info-300'             : '' }}
                ">
                    {{ $migrateStatus === 'success' ? '✓ Sucesso' : ($migrateStatus === 'error' ? '✗ Erro' : 'ℹ Info') }}
                </div>
                <pre class="p-4 text-xs font-mono text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-950 overflow-x-auto whitespace-pre-wrap">{{ $migrateOutput }}</pre>
            </div>
        </x-filament::section>
    @endif

</x-filament-panels::page>
