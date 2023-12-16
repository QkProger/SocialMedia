<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastmessageAccess()
    {
        return $this->hasMany(Message::class, 'user_id');
    }
    public function lastmessageSendler()
    {
        return $this->hasMany(Message::class, 'sendler_user_id');
    }

    public function hasLiked($post_id)
    {
        return $this->userPostRelationships()->where('post_id', $post_id)->exists();
    }

    public function userPostRelationships()
    {
        return $this->hasMany(UserPostRelationship::class, 'user_id');
    }

    public function hasSaved($post_id)
    {
        return $this->bookmarks()->where('post_id', $post_id)->exists();
    }

    public function bookmarks()
    {
        return $this->hasMany(UserPostBookmark::class, 'user_id');
    }
    
}
