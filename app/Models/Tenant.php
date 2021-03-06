<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Models\Tenant as ModelsTenant;
use Illuminate\Support\Str;

class Tenant extends ModelsTenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase;

    public static function booted()
    {
        // Hasing tenant admin password
        static::creating(function ($tenant) {
            $tenant->password = Hash::make($tenant->password);
        });
    }
}
