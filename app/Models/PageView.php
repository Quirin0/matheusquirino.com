<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = ['path', 'date', 'count'];

    protected $casts = [
        'date'  => 'date',
        'count' => 'integer',
    ];

    public static function record(string $path = '/'): void
    {
        try {
            // Garante que o registro existe sem erro de constraint
            static::insertOrIgnore([
                'path'       => $path,
                'date'       => now()->toDateString(),
                'count'      => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            static::where('path', $path)
                ->where('date', now()->toDateString())
                ->increment('count', 1, ['updated_at' => now()]);
        } catch (\Throwable) {
            // Falha silenciosa — rastreamento não deve quebrar a requisição
        }
    }

    public static function totalForPeriod(\Carbon\Carbon $from, \Carbon\Carbon $to): int
    {
        return (int) static::whereBetween('date', [$from, $to])->sum('count');
    }

    public static function dailyForPeriod(\Carbon\Carbon $from, \Carbon\Carbon $to): array
    {
        return static::whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->selectRaw('date, SUM(count) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }
}
