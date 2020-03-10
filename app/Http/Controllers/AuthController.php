<?php
namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\User;
use App\Enums\Error;
use App\Enums\RoleType;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use Symfony\Component\HttpFoundation\Response as Response;

class AuthController extends Controller
{
    /**
    * @OA\Post(
    *         path="/api/auth/register",
    *         tags={"Authentication"},
    *         summary="Register",
    *         description="Register a new user and send notification mail",
    *         operationId="register",
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=422,
    *             description="Validation error"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    *         @OA\RequestBody(
    *             required=true,
    *             @OA\MediaType(
    *                 mediaType="application/x-www-form-urlencoded",
    *                 @OA\Schema(
    *                     type="object",
    *                     @OA\Property(
    *                         property="email",
    *                         description="Email",
    *                         type="string",
    *                     ),
    *                     @OA\Property(
    *                         property="password",
    *                         description="Password",
    *                         type="string",
    *                         format="password"
    *                     ),
    *                     @OA\Property(
    *                         property="password_confirmation",
    *                         description="Confirm password",
    *                         type="string",
    *                         format="password"
    *                     )
    *                 )
    *             )
    *         )
    * )
    */
    public function register(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'password_confirmation' => 'required|string|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json(
            [
                'error' =>
                        [
                            'code' => Error::GENR0002,
                            'message' => Error::getDescription(Error::GENR0002)
                        ],
                'validation' => $validator->errors()
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Create user
        $user = new User([
            'email' => $request->email,
            'status' => UserStatus::Activated,
            'activation_token' => '',
            'password' => bcrypt($request->password),
            'activation_token' => str_random(60)
        ]);
        $user->save();



        return response()->json(['user' => $user], Response::HTTP_OK);
    }

    /**
    * @OA\Post(
    *         path="/api/auth/login",
    *         tags={"Authentication"},
    *         summary="Login",
    *         description="Login an user",
    *         operationId="login",
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=422,
    *             description="Validation error"
    *         ),
    *         @OA\Response(
    *             response=403,
    *             description="Wrong combination of email and password or email not verified"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    *         @OA\RequestBody(
    *             required=true,
    *             @OA\MediaType(
    *                 mediaType="application/x-www-form-urlencoded",
    *                 @OA\Schema(
    *                     type="object",
    *                      @OA\Property(
    *                         property="email",
    *                         description="Email",
    *                         type="string",
    *                     ),
    *                     @OA\Property(
    *                         property="password",
    *                         description="Password",
    *                         type="string",
    *                         format="password"
    *                     ),
    *                 )
    *             )
    *         )
    * )
    */
    public function login(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(
            [
                'error' =>
                        [
                            'code' => Error::GENR0002,
                            'message' => Error::getDescription(Error::GENR0002)
                        ],
                'validation' => $validator->errors()
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = request(['email', 'password']);
        $credentials['status'] = 1;
        $credentials['deleted_at'] = null;
        // Check the combination of email and password, also check for activation status
        if(!$token = auth('api')->attempt($credentials)) {
            return response()->json(
                ['error' =>
                            [
                                'code' => Error::AUTH0001,
                                'message' => Error::getDescription(Error::AUTH0001)
                            ]
                ], Response::HTTP_UNAUTHORIZED
            );
        }
        $user = auth('api')->user();

     //   return response()->json(['user' => $user], Response::HTTP_OK)->withCookie('token', $token, config('jwt.ttl'), "/", null, false, true);
        return response()->json(['user' => $user,'token'=>$token], Response::HTTP_OK);

    }

    /**
    * @OA\Get(
    *         path="/api/auth/logout",
    *         tags={"Authentication"},
    *         summary="Logout",
    *         description="Logout an user",
    *         operationId="logout",
    *         @OA\Response(
    *             response=204,
    *             description="Successful operation with no content in return"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    * )
    */
    public function logout(Request $request)
    {
        auth('api')->logout();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
    * @OA\Get(
    *         path="/api/auth/getUser",
    *         tags={"Authentication"},
    *         summary="Get user",
    *         description="Retrieve information from current user",
    *         operationId="getUser",
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    * )
    */
    public function getUser(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => $user], Response::HTTP_OK);
    }


    /*public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();
        // If the token is not existing, throw error
        if (!$user) {
            return response()->json(
                ['error' =>
                            [
                                'code' => Error::AUTH0002,
                                'message' => Error::getDescription(Error::AUTH0002)
                            ]
                ], Response::HTTP_BAD_REQUEST
            );
        }
        // Update activation info
        $user->status = UserStatus::Activated;
        $user->activation_token = '';
        $user->email_verified_at = Carbon::now();
        $user->save();

        return response()->json(['user' => $user], Response::HTTP_OK);
    }*/


    /**
    * @OA\Patch(
    *         path="/api/auth/password/change",
    *         tags={"Authentication"},
    *         summary="Change password",
    *         description="Change an user's password (requires current password) and send notification mail",
    *         operationId="changePassword",
    *         @OA\Response(
    *             response=200,
    *             description="Successful operation"
    *         ),
    *         @OA\Response(
    *             response=422,
    *             description="Validation error"
    *         ),
    *         @OA\Response(
    *             response=403,
    *             description="Wrong combination of email and password or email not verified"
    *         ),
    *         @OA\Response(
    *             response=500,
    *             description="Server error"
    *         ),
    *         @OA\RequestBody(
    *             required=true,
    *             @OA\MediaType(
    *                 mediaType="application/x-www-form-urlencoded",
    *                 @OA\Schema(
    *                     type="object",
    *                      @OA\Property(
    *                         property="password",
    *                         description="Password",
    *                         type="string",
    *                         format="password"
    *                     ),
    *                     @OA\Property(
    *                         property="new_password",
    *                         description="New password",
    *                         type="string",
    *                         format="password"
    *                     ),
    *                     @OA\Property(
    *                         property="new_password_confirmation",
    *                         description="Confirm new password",
    *                         type="string",
    *                         format="password"
    *                     ),
    *                 )
    *             )
    *         )
    * )
    */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $email = $user->email;
        // Validate input data
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'new_password' => 'required|string|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json(
            [
                'error' =>
                        [
                            'code' => Error::GENR0002,
                            'message' => Error::getDescription(Error::GENR0002)
                        ],
                'validation' => $validator->errors()
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Check if the combination of email and password is correct, if it is then proceed, if no, throw error
        $credentials = request(['password']);
        $credentials['email'] = $email;
        $credentials['status'] = UserStatus::Activated;
        $credentials['deleted_at'] = null;

        // Check the combination of email and password, also check for activation status
        if(!Auth::guard('web')->attempt($credentials)) {
            return response()->json(
                ['error' =>
                            [
                                'code' => Error::AUTH0001,
                                'message' => Error::getDescription(Error::AUTH0001)
                            ]
                ], Response::HTTP_BAD_REQUEST
            );
        }

        // Save new password
        $user->password = bcrypt($request->new_password);
        $user->save();

        Auth::guard('api')->refresh();
        return response()->json(['user' => $user], Response::HTTP_OK);
    }

    protected function respondWithToken($token)
    {
        return [
            'token' => $token,
            'token_type'   => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
