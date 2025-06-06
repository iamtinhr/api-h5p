<?php

namespace EscolaLms\HeadlessH5P\Policies;

use App\Models\User;
use EscolaLms\HeadlessH5P\Enums\H5PPermissionsEnum;
use EscolaLms\HeadlessH5P\Models\H5PContent;
use Illuminate\Auth\Access\HandlesAuthorization;

class H5PContentPolicy
{
    use HandlesAuthorization;

    public function list(?User $user): bool
    {
//        return $user && ($user->can(H5PPermissionsEnum::H5P_LIST) || $user->can(H5PPermissionsEnum::H5P_AUTHOR_LIST));
        return true;
    }

    public function read(?User $user): bool
    {
//        return $user && $user->can(H5PPermissionsEnum::H5P_READ);
        return true;
    }

    public function create(?User $user): bool
    {
//        return $user && $user->can(H5PPermissionsEnum::H5P_CREATE);
        return true;
    }

    public function delete(?User $user): bool
    {
//        return $user && $user->can(H5PPermissionsEnum::H5P_DELETE);
        return true;
    }

    public function update(?User $user, H5PContent $h5PContent ): bool
    {
//        if ($user && $user->can(H5PPermissionsEnum::H5P_AUTHOR_UPDATE) && !$user->can(H5PPermissionsEnum::H5P_UPDATE)) {
//            return $h5PContent->user_id == $user->getKey();
//        }
//
//        return $user && $user->can(H5PPermissionsEnum::H5P_UPDATE);
        return true;
    }
}
