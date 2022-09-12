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
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int $id
 * @property int|null $country_id
 * @property string|null $name
 * @property string|null $name_en
 * @property string|null $position
 * @property string|null $bio
 * @property string|null $email
 * @property string|null $mobile
 * @property string|null $password
 * @property string|null $remember_token
 * @property string|null $provider
 * @property string|null $provider_id
 * @property string|null $work
 * @property string|null $study
 * @property int|null $extrovert
 * @property int|null $feeling
 * @property int|null $intuition
 * @property int|null $perceiving
 * @property int|null $maker
 * @property int|null $connector
 * @property int|null $idea_generator
 * @property int|null $collaborator
 * @property int|null $finisher
 * @property int|null $evaluator
 * @property int|null $organiser
 * @property int|null $moderator
 * @property int|null $gender
 * @property string|null $request_session_description
 * @property string|null $image
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $linkedin
 * @property string|null $instagram
 * @property string|null $slack
 * @property Carbon|null $dob
 * @property int|null $type
 * @property int|null $verified
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Country|null $country
 * @property Collection|Course[] $courses
 * @property Collection|UsersLecture[] $users_lectures
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use SoftDeletes, HasFactory, Notifiable, HasRoles;
	protected $table = 'users';

    protected $casts = [
        'country_id' => 'int',
        'extrovert' => 'int',
        'feeling' => 'int',
        'intuition' => 'int',
        'perceiving' => 'int',
        'maker' => 'int',
        'connector' => 'int',
        'idea_generator' => 'int',
        'collaborator' => 'int',
        'finisher' => 'int',
        'evaluator' => 'int',
        'organiser' => 'int',
        'moderator' => 'int',
        'gender' => 'int',
        'type' => 'int',
        'verified' => 'int',
        'enabled' => 'int'
    ];

    protected $appends = ['full_path_image'];

	protected $hidden = [
		'password'
	];

    protected $fillable = [
        'country_id',
        'name',
        'name_en',
        'position',
        'bio',
        'email',
        'mobile',
        'password',
        'remember_token',
        'provider',
        'provider_id',
        'work',
        'study',
        'extrovert',
        'feeling',
        'intuition',
        'perceiving',
        'maker',
        'connector',
        'idea_generator',
        'collaborator',
        'finisher',
        'evaluator',
        'organiser',
        'moderator',
        'image',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'slack',
        'request_session_description',
        'gender',
        'dob',
        'type',
        'verified',
        'enabled'
    ];

    public function getFullPathImageAttribute(){
        return $this->image && file_exists(base_path($this->image)) ? url($this->image) : url('uploads/image_placeholder.png');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function users_assignments()
    {
        return $this->hasMany(UsersAssignment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'users_courses')
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function user_interests()
    {
        return $this->hasMany(UsersInterest::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'users_interests')
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'users_languages')
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function lectures()
    {
        return $this->belongsToMany(Lecture::class, 'users_lectures')
            ->withPivot('id', 'deleted_at')
            ->withTimestamps();
    }

    public function dates()
    {
        return $this->hasMany(UsersDate::class)->where('users_dates.enabled', 1);
    }

    public function users_mentors_requests()
    {
        return $this->hasMany(UsersMentorsRequest::class);
    }

    public function users_verifications()
    {
        return $this->hasMany(UsersVerification::class);
    }

	public function users_lectures()
	{
		return $this->hasMany(UsersLecture::class);
	}

    public function user_attempts()
    {
        return $this->hasMany(UserAttempt::class);
    }

    public function grades()
    {
        return $this->hasMany(UsersGrades::class);
    }
}
