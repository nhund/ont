<?php

namespace App\Http\Controllers\Auth;

use App\Components\Auth\Authenticator;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Transformers\auth\AccessTokenEntityFull;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param RegisterUserRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function store(RegisterUserRequest $request)
    {
        dd($request->user());

         $data = $request->only(['email', 'full_name', 'password']);

         User::create([
             'email'     => $data['email'],
             'full_name' => $data['full_name'] ?? null,
             'password'  => bcrypt($data['password']),
//             'level'     => $data['level'],
//             'status'    => $data['status'],
         ]);

        $tokenEntity = (new Authenticator())->issueTokensUsingPasswordGrantWithClient(
            $request->oauthClient(),
            $data['email'],
            $data['password']
        );

        return fractal()
            ->item($tokenEntity)
            ->transformWith(new AccessTokenEntityFull)
            ->respond();
    }
}
