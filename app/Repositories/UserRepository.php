<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserInterface;
use App\Http\Resources\User as UserResource;

class UserRepository implements UserInterface
{
    /**
     * Get all users.
     * 
     * @return Array
     */
    public function getAllUsers()
    {
        return User::all();
    }
    
    /**
     * Get all users order by weekly vists
     * and paginated (15 per page).
     * 
     * @return UserResource
     */
    public function getAllUsersOrderByWeeklyVisits()
    {
        return UserResource::collection(User::orderBy('weekly_views_count', 'DESC')->paginate(15));
    }
    
    /**
     * Get user by ID.
     * 
     * @param Integer id
     * @return User
     */
    public function getUserByID($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Get user by ID and return UserResource.
     * 
     * @param Integer id
     * @return UserResource
     */
    public function getUserByIdJSON($id)
    {
        return new UserResource($this->getUserByID($id));
    }

    /**
     * Reset weekly views for all users 
     * 
     * @return Void
     */
    public function resetWeeklyViews()
    {
        User::update(['weekly_views_count' => 1]);
    }

    /**
     * Reset monthly views for all users 
     * 
     * @return Void
     */
    public function resetMonthlyViews()
    {
        User::update(['monthly_views_count' => 1]);
    }

    /**
     * Increase weekly & monthly views for all users.
     * 
     * @return Void
     */
    public function updateViews()
    {
        User::increment('monthly_views_count');
        User::increment('weekly_views_count');
    }
}
