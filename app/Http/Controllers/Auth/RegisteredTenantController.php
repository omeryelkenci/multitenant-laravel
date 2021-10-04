<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTenantRequest;
use App\Models\Tenant;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RegisteredTenantController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterTenantRequest $request)
    {
        $tenant = Tenant::create($request->validated());
        $user = User::create($tenant->getAttributes());

        TenantUser::create([
            'user_id' => $user->id,
            'tenant_id' => $tenant->id
        ]);

        tenancy()->initialize($tenant);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return Inertia::location(route('tenant.dashboard', $tenant));
        }
    }
}
