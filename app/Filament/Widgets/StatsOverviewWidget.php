<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use App\Models\Project;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today       = Carbon::today();
        $yesterday   = Carbon::yesterday();
        $thisMonth   = Carbon::now()->startOfMonth();
        $lastMonth   = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $todayViews     = PageView::totalForPeriod($today, $today);
        $yesterdayViews = PageView::totalForPeriod($yesterday, $yesterday);
        $monthViews     = PageView::totalForPeriod($thisMonth, Carbon::now());
        $lastMonthViews = PageView::totalForPeriod($lastMonth, $lastMonthEnd);

        $todayTrend   = $this->trend($todayViews, $yesterdayViews);
        $monthTrend   = $this->trend($monthViews, $lastMonthViews);

        $todayChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);
            return PageView::totalForPeriod($date, $date);
        })->toArray();

        $monthChart = collect(range(5, 0))->map(function ($monthsAgo) {
            $from = Carbon::now()->subMonths($monthsAgo)->startOfMonth();
            $to   = $monthsAgo === 0 ? Carbon::now() : Carbon::now()->subMonths($monthsAgo)->endOfMonth();
            return PageView::totalForPeriod($from, $to);
        })->toArray();

        return [
            Stat::make('Acessos hoje', number_format($todayViews))
                ->description($todayTrend['text'])
                ->descriptionIcon($todayTrend['icon'])
                ->color($todayTrend['color'])
                ->chart($todayChart),

            Stat::make('Acessos este mês', number_format($monthViews))
                ->description($monthTrend['text'])
                ->descriptionIcon($monthTrend['icon'])
                ->color($monthTrend['color'])
                ->chart($monthChart),

            Stat::make('Total de projetos', Project::count())
                ->description(Project::where('featured', true)->count() . ' em destaque')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
        ];
    }

    private function trend(int $current, int $previous): array
    {
        if ($previous === 0) {
            return ['text' => 'Sem dados anteriores', 'icon' => 'heroicon-m-minus', 'color' => 'gray'];
        }
        $pct = round((($current - $previous) / $previous) * 100, 1);
        if ($pct >= 0) {
            return ['text' => "+{$pct}% em relação ao período anterior", 'icon' => 'heroicon-m-arrow-trending-up', 'color' => 'success'];
        }
        return ['text' => "{$pct}% em relação ao período anterior", 'icon' => 'heroicon-m-arrow-trending-down', 'color' => 'danger'];
    }
}
