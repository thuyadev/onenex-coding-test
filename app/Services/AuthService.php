<?php

namespace App\Services;

use App\Http\Requests\Api\LoginFormRequest;
use App\Http\Requests\Api\RegisterFormRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class AuthService
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private UserRepositoryInterface $userRepository,
    )
    {}

    /**
     * @param RegisterFormRequest $request
     * @return array
     */
    public function register(RegisterFormRequest $request): array
    {
        $data = $request->validated();

        $to_user = $request->toUser($data);

        $user = $this->userRepository->create($to_user);

        return [
            'user' => $user,
            'token' => $user->createToken('user')->accessToken
        ];
    }

    /**
     * @param LoginFormRequest $request
     * @return array
     */
    public function login(LoginFormRequest $request)
    {
        $data = $request->validated();

        $user = $this->checkUser($data['email'], $data['password']);

        $user->tokens()->delete();

        return [
            'user' => $user,
            'token' => $user->createToken('user')->accessToken
        ];
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    private function checkUser(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();

        if ($user == null)
        {
            throw new NotFoundResourceException('Register First!');
        }

        if (!Hash::check($password, $user->password))
        {
            throw new NotFoundResourceException("Incorrect Password!");
        }

        return $user;
    }
}
