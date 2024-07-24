<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\ConfeaApiService;


class RegisteredUserController extends Controller
{
    private $confeaApiService;
    public function __construct(ConfeaApiService $confeaApiService) {
        $this->confeaApiService = $confeaApiService;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'rnp' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $data = $this->confeaApiService->getUserData($request->rnp);

            $user = User::create([
                'rnp' => $request->rnp,
                'name' => $data['nme'],
                'email' => $data['eml'],
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        } catch (\Exception $error) {
            dd("teste  {$error->getMessage()}");
            //return redirect()->back()->withErrors(['message' => 'Failed to register user.']);
        }
    }
}
