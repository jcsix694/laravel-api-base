<?php

namespace App\Api\Repositories;

use App\Api\Core\Helpers\StatusCodeHelper;
use App\Api\Models\AccountTypeModel;
use App\Api\Models\UserModel;
use App\Api\Requests\CreateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersRepository
{
    protected $accountTypesRepository;

    function __construct()
    {
        $this->accountTypesRepository = new AccountTypesRepository();
    }

    /**
     * Creates a customer
     *
     * @param CreateUserRequest $request
     *
     * @return UserModel
     * @throws \Exception
     *
     */
    public function createMember(CreateUserRequest $data){
        try {
            $data->accountType = AccountTypeModel::MEMBER;
            return $this->create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Creates a user
     */
    public function create($data)
    {
        DB::beginTransaction();
        if($this->getUserByEmail($data->email)) throw new \Exception('The email has already been taken.', StatusCodeHelper::STATUS_UNPROCESSABLE);

        if(!$data->accountType) throw new \Exception('Account type is Required', StatusCodeHelper::STATUS_UNPROCESSABLE);

        $accountType = $this->accountTypesRepository->getByType($data->accountType);

        if(!$accountType) throw new \Exception('Account type does not exist', StatusCodeHelper::STATUS_UNPROCESSABLE);

        $user = new UserModel([
            'email' => $data->email,
            'name' => $data->name,
            'surname' => $data->surname,
            'password' => Hash::make($data->password),
        ]);

        try {
            $user->saveOrFail();

            $user->userAccount()->create([
                'account_type_id' => $accountType->id,
            ]);

            DB::commit();
            return $user->refresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Something went wrong whilst trying to create this user, please try again.', StatusCodeHelper::STATUS_NOT_FOUND);
        }
    }

    /**
     * Returns a user by email
     *
     */
    public function getUserByEmail(string $email)
    {
        return UserModel::where('email', $email)->first();
    }

    /**
     * Returns a user by id
     *
     */
    public function getUserById(int $id){
        return UserModel::where('id', $id)->first();
    }
}
