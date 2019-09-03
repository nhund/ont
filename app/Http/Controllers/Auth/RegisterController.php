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

    protected $authenticator;

    /**
     * Create a new controller instance.
     *
     * RegisterController constructor.
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator){
        $this->authenticator = $authenticator;
        $this->middleware('guest');

    }

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    /**
     * @param RegisterUserRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function store(RegisterUserRequest $request)
    {
         $data = $request->only(['email', 'full_name', 'password', 'phone']);

         User::create([
             'email'     => $data['email'],
             'full_name' => $data['full_name'] ?? null,
             'phone'     => $data['phone'] ?? null,
             'password'  => bcrypt($data['password']),
//             'level'     => $data['level'],
//             'status'    => $data['status'],
         ]);

        $tokenEntity = $this->authenticator->issueTokensUsingPasswordGrantWithClient(
            $request->oauthClient(),
            $data['email'],
            $data['password']
        );

        return $this->authenticator->respondWithTokens($request, $tokenEntity);
    }
}
