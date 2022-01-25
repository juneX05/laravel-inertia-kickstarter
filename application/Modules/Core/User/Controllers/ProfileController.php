<?php

namespace Application\Modules\Core\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function profile()
    {
        return Inertia::render('Core/User/Views/Profile', []);
    }


}
