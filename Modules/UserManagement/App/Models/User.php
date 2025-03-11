<?php

namespace Modules\UserManagement\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles;

    protected $table = 'new_users';

    protected $fillable = [
        'name', 'login', 'password', 'phone', 'tg_id', 'company_tin', 'company_integration_id', 'role', 'type','current_mode'];

    protected $hidden = ['password'];

    // JWTSubject methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
}
