<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\View;
use App\Repositories\UserInterface;

class UserViewsService
{
    private $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Update user's both weekly & monthly views.
     * 
     * @param String $ip
     * @param Integer $id
     * @return Void
     */
    public function updateUsersViews($ip, $id = null)
    {
        if ($id) {
            $user = $this->userRepository->getUserByID($id);
            View::create(['user_id' => $user->id, 'user_ip' => $ip]);

            if ($this->checkNewMonth()) {
                $user->update(['monthly_views_count' => 1]);
            } else {
                if ($this->checkNewWeek()) {
                    $user->update(['weekly_views_count' => 1]);
                } else {
                    $user->increment('monthly_views_count');
                    $user->increment('weekly_views_count');
                }
            }
        } else {
            if ($this->checkNewMonth()) {
                $this->userRepository->resetMonthlyViews();
            } else {
                if ($this->checkNewWeek()) {
                    $this->userRepository->resetWeeklyViews();
                } else {
                    $this->userRepository->updateViews();
                }
            }
        }
    }

    /**
     * Check if it's a new week.
     * 
     * @return Bool
     */
    private function checkNewWeek()
    {
        $lastView = View::latest()->first();
        $date = Carbon::parse($lastView->created_at);

        return ($date->lessThanOrEqualTo(Carbon::now()->startOfWeek() )
            && $date->greaterThanOrEqualTo(Carbon::now()->endOfWeek()))? true : false;
    }

    /**
     * Check if it's a new month.
     * 
     * @return Bool
     */
    private function checkNewMonth()
    {
        $lastView = View::latest()->first();
        $date = Carbon::parse($lastView->created_at);

        return ($date->lessThanOrEqualTo(Carbon::now()->startOfMonth() )
            && $date->greaterThanOrEqualTo(Carbon::now()->endOfMonth()))? true : false;
    }
}
