<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoView;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Videos', Video::count())
                ->description('All videos in the system')
                ->descriptionIcon('heroicon-m-film')
                ->color('success'),
            
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            
            Stat::make('Views Today', VideoView::whereDate('viewed_at', today())->count())
                ->description('Video views today')
                ->descriptionIcon('heroicon-m-eye')
                ->color('warning'),
            
            Stat::make('Premium Users', User::where('is_premium', true)->count())
                ->description('Active premium subscriptions')
                ->descriptionIcon('heroicon-m-star')
                ->color('primary'),
        ];
    }
}
