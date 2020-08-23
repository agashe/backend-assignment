<?php

namespace App\Repositories;

interface UserInterface
{
    /**
     * Get all users.
     * 
     * @return Array
     */
    public function getAllUsers();

    /**
     * Get all users order by weekly vists
     * and paginated (15 per page).
     * 
     * @return UserResource
     */
    public function getAllUsersOrderByWeeklyVisits();
    
    /**
     * Get user by ID.
     * 
     * @param Integer id
     * @return User
     */
    public function getUserByID($id);

    /**
     * Get user by ID and return UserResource.
     * 
     * @param Integer id
     * @return UserResource
     */
    public function getUserByIdJSON($id);
    
    /**
     * Reset weekly views for all users 
     * 
     * @return Void
     */
    public function resetWeeklyViews();
    
    /**
     * Reset monthly views for all users 
     * 
     * @return Void
     */
    public function resetMonthlyViews();
    
    /**
     * Increase weekly & monthly views for all users.
     * 
     * @return Void
     */
    public function updateViews();
}
