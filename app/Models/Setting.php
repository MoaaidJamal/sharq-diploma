<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use SoftDeletes, HasFactory, HasTranslations;
    public $translatable = [
        'header_title',
        'header_description',
        'home_video_title',
        'home_video_description',
        'find_your_mate_title',
        'find_your_mate_description',
        'popular_mentors_title',
        'popular_mentors_description',
        'learning_paths_title',
        'learning_paths_description',
        'partners_title',
        'partners_description',
        'gallery_title',
        'gallery_description',
        'home_menu_title',
        'learning_paths_menu_title',
        'find_your_mate_menu_title',
        'mentors_menu_title',
        'schedule_menu_title',
        'follow_us_on_social_media',
        'copyright',
    ];


	protected $table = 'settings';

    protected $fillable = [
        'header_title',
        'header_description',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'slack',
        'address',
        'email',
        'mobile',
        'home_video_id',
        'home_video_title',
        'home_video_description',
        'find_your_mate_title',
        'find_your_mate_description',
        'popular_mentors_title',
        'popular_mentors_description',
        'learning_paths_title',
        'learning_paths_description',
        'partners_title',
        'partners_description',
        'gallery_title',
        'gallery_description',
        'home_menu_title',
        'learning_paths_menu_title',
        'find_your_mate_menu_title',
        'mentors_menu_title',
        'schedule_menu_title',
        'follow_us_on_social_media',
        'copyright',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'file');
    }
}
