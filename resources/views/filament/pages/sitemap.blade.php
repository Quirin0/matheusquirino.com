<x-filament-panels::page>
    <x-filament::section>
        <div class="space-y-4">
            @if($lastGenerated)
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Último sitemap gerado em: <strong>{{ $lastGenerated }}</strong>
                </p>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum sitemap gerado ainda.</p>
            @endif

            @if($sitemapContent)
                <div class="rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4">
                    <pre class="text-xs text-gray-700 dark:text-gray-300 overflow-x-auto whitespace-pre-wrap break-all max-h-96">{{ $sitemapContent }}</pre>
                </div>
                <p class="text-xs text-gray-400">
                    Acessível em:
                    <a href="{{ config('app.url') }}/sitemap.xml" target="_blank" class="text-primary-500 underline">
                        {{ config('app.url') }}/sitemap.xml
                    </a>
                </p>
            @endif
        </div>
    </x-filament::section>
</x-filament-panels::page>
