<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\UserInterface;
use App\Services\UserViewsService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository, $userViewsService;

    public function __construct(UserInterface $userRepository, UserViewsService $userViewsService)
    {
        $this->userRepository = $userRepository;
        $this->userViewsService = $userViewsService;
    }

    /**
     * Get all users paginated (15 per page)
     * and update their views.
     * 
     * @param Request $request
     * @return UserResource
     */
    public function getAllUsers(Request $request)
    {
        $this->userViewsService->updateUsersViews($request->getClientIp());
        return $this->userRepository->getAllUsersOrderByWeeklyVisits();
    }
    
    /**
     * Get user by ID , and update his visits.
     * 
     * @param Request $request
     * @param Integer id
     * @return UserResource
     */
    public function getUser(Request $request, $id)
    {
        $this->userViewsService->updateUsersViews($request->getClientIp(), $id);
        return $this->userRepository->getUserByIdJSON($id);
    }
}
