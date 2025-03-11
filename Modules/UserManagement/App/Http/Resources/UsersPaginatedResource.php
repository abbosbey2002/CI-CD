<?php
namespace Modules\UserManagement\App\Http\Resources;
use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\UserManagement\App\Models\User;

class UsersPaginatedResource extends PaginatedResource
{
    public function initCollection()
    {
        return $this->collection->map(function (User $user) {
            return $user;
        });
    }
}
    