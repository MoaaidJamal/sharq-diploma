<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UsersGrades
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $lecturer_id
 * @property int|null $course_id
 * @property float|null $grade1
 * @property float|null $grade2
 * @property float|null $grade3
 * @property float|null $grade4
 * @property float|null $grade5
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Course|null $course
 * @property User|null $user
 *
 * @package App\Models
 */
class UsersGrades extends Model
{
	use HasFactory;
	protected $table = 'users_grades';

	protected $casts = [
		'user_id' => 'int',
		'lecturer_id' => 'int',
		'course_id' => 'int',
		'grade1' => 'float',
		'grade2' => 'float',
		'grade3' => 'float',
		'grade4' => 'float',
		'grade5' => 'float',
		'enabled' => 'int',
	];

	protected $fillable = [
		'user_id',
		'lecturer_id',
		'course_id',
		'grade1',
		'grade2',
		'grade3',
		'grade4',
		'grade5',
		'enabled',
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function lecturer()
	{
		return $this->belongsTo(User::class, 'lecturer_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
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
