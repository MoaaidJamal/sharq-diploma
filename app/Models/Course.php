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
use Spatie\Translatable\HasTranslations;

/**
 * Class Course
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $phase_id
 * @property int|null $user_id
 * @property int|null $order
 * @property string|null $title
 * @property string|null $description
 * @property string|null $tags
 * @property string|null $image
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property int|null $is_available
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property CoursesCategory|null $courses_category
 * @property Course|null $course
 * @property Collection|Course[] $courses
 * @property Collection|Lecture[] $lectures
 * @property Collection|Lecture[] $available_lectures
 * @property Collection|LecturesGroup[] $lectures_groups
 * @property Collection|User[] $users
 * @property Collection|Phase[] $phases
 *
 * @package App\Models
 */
class Course extends Model
{
    use SoftDeletes, HasFactory, HasTranslations;
    public $translatable = ['title', 'description'];

    protected $table = 'courses';
    private $order = 1;

    protected $casts = [
        'phase_id' => 'int',
        'user_id' => 'int',
        'category_id' => 'int',
        'order' => 'int',
        'is_available' => 'int',
        'enabled' => 'int'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    protected $fillable = [
        'phase_id',
        'user_id',
        'category_id',
        'order',
        'title',
        'description',
        'tags',
        'image',
        'start_date',
        'end_date',
        'hours',
        'is_available',
        'enabled'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::query()->max('order') + 1;
        });
    }

    public function getImageAttribute($file){
        return $file && file_exists(public_path($file)) ? url($file) : url('uploads/image_placeholder.png');
    }

    public function courses_category()
    {
        return $this->belongsTo(CoursesCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function available_lectures()
    {
        return $this->hasMany(Lecture::class)->where('enabled', 1)->orderBy('order');
    }

    public function first_lecture()
    {
        return $this->hasOne(Lecture::class)->where('enabled', 1)->orderBy('order');
    }

    public function other_lectures()
    {
        return $this->hasMany(Lecture::class, 'course_id')->where('enabled', 1)->where(function ($q) {
            $q->whereDoesntHave('lectures_group')->orWhereHas('lectures_group', function ($q) {
                $q->where('enabled', '!=', 1);
            });
        })->orderBy('order');
    }

    public function all_lectures_groups()
    {
        return $this->hasMany(LecturesGroup::class)->orderBy('order');
    }

    public function lectures_groups()
    {
        return $this->hasMany(LecturesGroup::class)->where('lectures_groups.enabled', 1)->orderBy('order');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_courses')
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function getLecturesCount() {
        return $this->lectures()->count();
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

    public function scopeWithMainPhase($q)
    {
        return $q->when(session('dashboard_phase_id'), function ($q) {
            $q->where('phase_id', session('dashboard_phase_id'));
        });
    }
}
