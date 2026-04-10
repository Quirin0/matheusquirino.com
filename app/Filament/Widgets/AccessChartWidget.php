<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Widgets\ChartWidget;

class AccessChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Acessos ao longo do tempo';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    public string $period = '30d';

    protected function getFilters(): ?array
    {
        return [
            '7d'  => 'Últimos 7 dias',
            '30d' => 'Últimos 30 dias',
            '90d' => 'Últimos 3 meses',
            '12m' => 'Últimos 12 meses',
        ];
    }

    protected function getData(): array
    {
        $period = $this->filter ?? '30d';

        [$labels, $current, $previous] = match ($period) {
            '7d'  => $this->dailyData(7),
            '90d' => $this->dailyData(90),
            '12m' => $this->monthlyData(12),
            default => $this->dailyData(30),
        };

        return [
            'datasets' => [
                [
                    'label'           => 'Período atual',
                    'data'            => $current,
                    'borderColor'     => '#6366f1',
                    'backgroundColor' => 'rgba(99,102,241,0.15)',
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
                [
                    'label'           => 'Período anterior',
                    'data'            => $previous,
                    'borderColor'     => '#94a3b8',
                    'backgroundColor' => 'rgba(148,163,184,0.08)',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'borderDash'      => [5, 5],
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function dailyData(int $days): array
    {
        $labels  = [];
        $current = [];
        $prev    = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date  = Carbon::today()->subDays($i);
            $pDate = Carbon::today()->subDays($i + $days);
            $labels[]  = $date->format('d/m');
            $current[] = PageView::totalForPeriod($date, $date);
            $prev[]    = PageView::totalForPeriod($pDate, $pDate);
        }

        return [$labels, $current, $prev];
    }

    private function monthlyData(int $months): array
    {
        $labels  = [];
        $current = [];
        $prev    = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $from  = Carbon::now()->subMonths($i)->startOfMonth();
            $to    = $i === 0 ? Carbon::now() : Carbon::now()->subMonths($i)->endOfMonth();
            $pFrom = Carbon::now()->subMonths($i + $months)->startOfMonth();
            $pTo   = Carbon::now()->subMonths($i + $months)->endOfMonth();

            $labels[]  = $from->format('M/y');
            $current[] = PageView::totalForPeriod($from, $to);
            $prev[]    = PageView::totalForPeriod($pFrom, $pTo);
        }

        return [$labels, $current, $prev];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
