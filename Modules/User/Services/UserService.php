<?php

namespace Modules\User\Services;

use App\Models\Favorite;
use App\Models\User;
use App\Services\FileOperationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Enums\AuthEnum;
use Modules\Role\Services\RoleService;
use Modules\Technical\app\Models\Technical;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Enums\UserTypeEnum;

class UserService
{
    public User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(): Collection
    {
        return $this->userModel::with(['avatar', 'roles'])->get();
    }

    public function store($data)
    {
        $errors = [];
        $role = (new RoleService())->roleExists($data['role_id'], $errors);

        if ($errors) {
            return $errors;
        }

        $user = $this->userModel::create($data + ['type' => UserTypeEnum::EMPLOYEE]);

        $user->assignRole($role);


        (new FileOperationService())->storeImageFromRequest($user, AuthEnum::AVATAR_COLLECTION_NAME, 'avatar');

        return true;
    }

    public function show($id): Model|Builder|User
    {
        return $this->userModel::whereId($id)->with('avatar')->firstOrFail();
    }

    public function update($data, $id)
    {
        $errors = [];
        $user = $this->userModel::whereId($id)->firstOrFail();

        $role = (new RoleService())->roleExists($data['role_id'], $errors);

        if ($errors) {
            return $errors;
        }

        $user->update($data);

        $user->syncRoles($role);

        if (isset($data['avatar'])) {
            $user->getRegisteredMediaCollections();
            (new FileOperationService())->storeImageFromRequest($user, AuthEnum::AVATAR_COLLECTION_NAME, 'avatar');
        }

        return true;
    }

    public function destroy($id): bool
    {
        $user = $this->userModel::whereId($id)->firstOrFail();

        $user->delete();

        return true;
    }

    public function rating($data)
    {
        $user = $this->userModel::whereId($data['user_id'])->firstOrFail();
        $user->rating()->updateOrCreate(['user_id' => auth()->id()],['user_id' => auth()->id(), 'rate' => $data['rate']]);
        $user->update(['average_rating' => $user->rating()->avg('rate')]);

        return true;
    }

    public function showRates()
    {
    }

    public function favorites($userId)
    {
        $user = $this->userModel::whereId($userId)->firstOrFail();
        $favorite = $user->favorite()->where('user_id' , auth()->id())->first();
        if ($favorite){
            $user->favorite()->delete();
            return false;
        }
        $user->favorite()->create(['user_id' => auth()->id()]);

        return true;
    }

    public function showAllFavorites()
    {
        return Favorite::where('user_id', auth()->id())->with('favoritable')->get()->pluck('favoritable');
    }

}
