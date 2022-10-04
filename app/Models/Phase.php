<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

/**
 * Class Phase
 *
 * @property int $id
 * @property int|null $order
 * @property string|null $title
 * @property string|null $description
 * @property string|null $image
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Course[] $courses
 * @property Collection|Course[] $available_courses
 *
 * @package App\Models
 */
class Phase extends Model
{
	use SoftDeletes, HasFactory, HasTranslations;
    public $translatable = ['title', 'description'];
	protected $table = 'phases';

	protected $casts = [
		'enabled' => 'int'
	];

	protected $fillable = [
		'order',
		'title',
		'description',
		'image',
		'enabled'
	];

    public function getImageAttribute($file){
        return $file && file_exists(public_path($file)) ? url($file) : url('uploads/image_placeholder.png');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'phase_id');
    }

    public function lectures()
    {
        return $this->hasManyThrough(Lecture::class, Course::class);
    }

    public function available_courses()
    {
        return $this->hasMany(Course::class, 'phase_id')->where('enabled', 1)->orderBy('order');
    }

    public function available_lectures()
    {
        return $this->hasManyThrough(Lecture::class, Course::class)->where('lectures.enabled', 1)->orderBy('lectures.order');
    }

    public function usersPivot()
    {
        return $this->hasMany(UsersPhase::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_phases')
            ->withTimestamps();
    }

    public function next()
    {
        return $this->getOriginal('order') ? self::query()->where('order', '>', $this->getOriginal('order'))->where('enabled', 1)->orderBy('order')->first() : null;
    }

    public function previous()
    {
        return $this->getOriginal('order') ? self::query()->where('order', '<', $this->getOriginal('order'))->where('enabled', 1)->orderBy('order', 'DESC')->first() : null;
    }

    public function getUserScore($user_id = null)
    {
        return $this->available_lectures()->count() ? number_format(UsersLecture::query()->where('user_id', $user_id ?: auth()->id())->whereIn('lecture_id', $this->available_lectures()->pluck('lectures.id')->toArray())->get()->unique('lecture_id')->count() / $this->available_lectures()->count() * 100) : 0;
    }
}
