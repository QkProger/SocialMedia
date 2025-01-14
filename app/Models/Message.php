<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'sendler_user_id');
    }

    public function getSvgIcon()
    {
        if ($this->file_name) {
            $extension = strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
            switch ($extension) {
                case 'jpg':
                case 'png':
                case 'jpeg':
                    return '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon-image">
                            <rect x="3" y="3" width="18" height="18" rx="2"
                                ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>';
                    break;
                case 'mp3':
                case 'wav':
                case 'webm':
                    return '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon-music">
                            <path d="M9 18V5l12-2v13"></path>
                            <circle cx="6" cy="18" r="3"></circle>
                            <circle cx="18" cy="16" r="3"></circle>
                        </svg>';
                    break;
                case 'mp4':
                case 'avi':
                    return '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon-film">
                            <rect x="2" y="2" width="20" height="20" rx="2.18"
                                ry="2.18"></rect>
                            <line x1="7" y1="2" x2="7"
                                y2="22"></line>
                            <line x1="17" y1="2" x2="17"
                                y2="22"></line>
                            <line x1="2" y1="12" x2="22"
                                y2="12"></line>
                            <line x1="2" y1="7" x2="7"
                                y2="7"></line>
                            <line x1="2" y1="17" x2="7"
                                y2="17"></line>
                            <line x1="17" y1="17" x2="22"
                                y2="17"></line>
                            <line x1="17" y1="7" x2="22"
                                y2="7"></line>
                        </svg>';
                    break;
                default:
                    return '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon-file">
                            <path
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                            </path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>';
                    break;
            }
        } else {
            return '';
        }
    }
}
