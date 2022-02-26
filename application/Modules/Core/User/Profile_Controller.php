<?php

namespace Application\Modules\Core\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Profile_Controller extends Controller
{
    public function profile()
    {
        return Inertia::render('Core/User/Profile', []);
    }


}
