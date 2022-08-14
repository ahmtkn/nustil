<?php

namespace App\Traits;

use App\Models\View;
use Carbon\CarbonPeriod;

trait Viewable
{

    public function view()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function views(?CarbonPeriod $period = null)
    {
        $morph = $this->view();
        if ($period) {
            return $morph->whereBetween(
                'viewed_at',
                [$period->startDate(), $period->endDate()]
            )->count();
        }

        return $morph->count();
    }

    public function vipeViews()
    {
        $this->view()->delete();

        return $this;
    }

    public function addView()
    {
        $this->view()->create([
            'viewed_at' => now(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer' => request()->input('referer') ?? request()->input('ref') ?? request()->header('referer'),
        ]);
    }


}
