<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama','name','email','password','role','status','remember_token','reset_token','reset_token_expiry'])]
#[Hidden(['password','remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'reset_token_expiry' => 'datetime',
        ];
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function getGuruAttribute()
    {
        if ($this->relationLoaded('guru')) {
            $guru = $this->getRelation('guru');
        } else {
            $guru = $this->hasOne(Guru::class)->first();
        }

        if (!$guru) {
            $name = $this->nama ?: $this->name;
            if ($name) {
                $guru = Guru::where('nama_guru', $name)->first();
                if ($guru) {
                    if (!$guru->user_id) {
                        $guru->user_id = $this->id;
                        $guru->save();
                    }
                    $this->setRelation('guru', $guru);
                }
            }
        }

        return $guru;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->isGuru()) {
            return $this->nama ?: ($this->name ?: explode('@', $this->email)[0]);
        }

        if ($this->isAdmin()) {
            return explode('@', $this->email)[0];
        }

        return $this->nama ?: ($this->name ?: explode('@', $this->email)[0]);
    }
}
