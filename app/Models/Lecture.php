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
 * Class Lecture
 *
 * @property int $id
 * @property int|null $group_id
 * @property int|null $category_id
 * @property int|null $course_id
 * @property int|null $order
 * @property string|null $title
 * @property string|null $description
 * @property string|null $image
 * @property string|null $file_type
 * @property string|null $file
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property string|null $video_id
 * @property string|null $content
 * @property string|null $embedded_code
 * @property int|null $minutes
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property LecturesCategory|null $lectures_category
 * @property Course|null $course
 * @property LecturesGroup|null $lectures_group
 * @property Lecture|null $lecture
 * @property Collection|Lecture[] $lectures
 * @property Collection|UsersLecture[] $users_lectures
 *
 * @package App\Models
 */
class Lecture extends Model
{
    use SoftDeletes, HasFactory, HasTranslations;
    public $translatable = ['title', 'description', 'assignment'];

	protected $table = 'lectures';
    private $order = 1;

    const CATEGORY_COURSE = 1;
    const CATEGORY_QUIZ = 2;
    const CATEGORY_LIVE_SESSION = 3;
    const CATEGORY_BASIC_LESSON = 4;
    const CATEGORY_ASSIGNMENT = 5;
    const CATEGORY_RECORDED_SESSION = 6;
    const CATEGORY_PANEL_DISCUSSION = 7;
    const CATEGORY_INTERNATIONAL_RETREAT = 8;
    const CATEGORY_VIRTUAL_RETREAT = 9;
    const CATEGORY_BOOK_DISCUSSION = 10;
    const CATEGORY_DEBATE = 11;
    const CATEGORY_SKILL_LAB = 12;
    const CATEGORY_SOCIAL_EVENT = 13;
    const CATEGORY_ZOOM = 14;

    const CATEGORIES = [
        self::CATEGORY_COURSE => 'Course',
        self::CATEGORY_ZOOM => 'Zoom Meeting',
        self::CATEGORY_QUIZ => 'Quiz',
        self::CATEGORY_LIVE_SESSION => 'Live Session',
        self::CATEGORY_BASIC_LESSON => 'Basic Lesson',
        self::CATEGORY_ASSIGNMENT => 'Assignment',
        self::CATEGORY_RECORDED_SESSION => 'Recorded Session',
        self::CATEGORY_PANEL_DISCUSSION => 'Panel Discussion',
        self::CATEGORY_INTERNATIONAL_RETREAT => 'International Retreat',
        self::CATEGORY_VIRTUAL_RETREAT => 'Virtual Retreat',
        self::CATEGORY_BOOK_DISCUSSION => 'Book Discussion',
        self::CATEGORY_DEBATE => 'Debate',
        self::CATEGORY_SKILL_LAB => 'Skill Lab',
        self::CATEGORY_SOCIAL_EVENT => 'Social Event',
    ];

    const CATEGORIES_BADGE = [
        self::CATEGORY_COURSE => 'info',
        self::CATEGORY_QUIZ => 'primary',
        self::CATEGORY_LIVE_SESSION => 'secondary',
        self::CATEGORY_BASIC_LESSON => 'warning',
        self::CATEGORY_ASSIGNMENT => 'danger',
        self::CATEGORY_RECORDED_SESSION => 'light',
        self::CATEGORY_PANEL_DISCUSSION => 'dark',
        self::CATEGORY_INTERNATIONAL_RETREAT => 'success',
        self::CATEGORY_VIRTUAL_RETREAT => 'info',
        self::CATEGORY_BOOK_DISCUSSION => 'secondary',
        self::CATEGORY_DEBATE => 'warning',
        self::CATEGORY_SKILL_LAB => 'danger',
        self::CATEGORY_SOCIAL_EVENT => 'dark',
        self::CATEGORY_ZOOM => 'primary',
    ];

    const ZOOM_ACCOUNTS = [
        'diploma@sharqforum.org' => [
            'api_key' => '-e50ANalRNqOrgQ62xY9Xg',
            'api_secret' => 'o7WoIRJ8u2iwsmOafjnpL2ISJdvMOo3UMdfj',
        ],
        'exedu@sharqforum.org' => [
            'api_key' => '-Ho9yht3TuSRHDgX-q8Tmg',
            'api_secret' => 'P7p8nW1adDZfC8ch7PvOD5bPuhj62gisv4JE',
        ]
    ];

	protected $casts = [
		'group_id' => 'int',
		'course_id' => 'int',
		'order' => 'int',
		'enabled' => 'int'
	];

    protected $dates = [
        'start_date',
        'end_date'
    ];

	protected $fillable = [
		'group_id',
		'category_id',
		'course_id',
		'order',
		'title',
		'description',
		'image',
		'file_type',
		'file',
		'video_id',
		'content',
		'embedded_code',
        'assignment',
        'start_date',
        'end_date',
        'minutes',
        'meeting_id',
        'join_url',
        'start_url',
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

    public function getFileAttribute($file){
        return $file && file_exists(public_path($file)) ? url($file) : url('uploads/image_placeholder.png');
    }

	public function lectures_category()
	{
		return $this->belongsTo(LecturesCategory::class, 'category_id');
	}

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function lectures_group()
	{
		return $this->belongsTo(LecturesGroup::class, 'group_id');
	}

	public function users_lectures()
	{
		return $this->hasMany(UsersLecture::class, 'lecture_id');
	}

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

	public function is_user_lecture()
	{
		return $this->hasMany(UsersLecture::class, 'lecture_id')->where('user_id', auth()->id())->count();
	}

	public function next()
	{
		return $this->getOriginal('order') ? self::query()->where('order', '>', $this->getOriginal('order'))->where('course_id', $this->course_id)->where('enabled', 1)->orderBy('order')->first() : null;
	}

	public function previous()
	{
		return $this->getOriginal('order') ?  self::query()->where('order', '<', $this->getOriginal('order'))->where('course_id', $this->course_id)->where('enabled', 1)->orderBy('order', 'DESC')->first() : null;
	}

    public function scopeWithMainPhase($q)
    {
        return $q->when(session('dashboard_phase_id'), function ($q) {
            $q->whereHas('course', function ($q) {
                $q->where('phase_id', session('dashboard_phase_id'));
            });
        });
    }
}
