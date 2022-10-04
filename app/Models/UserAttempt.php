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

/**
 * Class UserAttempt
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $lecture_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Lecture|null $lecture
 * @property User|null $user
 * @property Collection|UserAttemptAnswer[] $user_attempt_answers
 *
 * @package App\Models
 */
class UserAttempt extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'users_attempts';

	protected $casts = [
		'user_id' => 'int',
		'lecture_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'lecture_id'
	];

	public function lecture()
	{
		return $this->belongsTo(Lecture::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function answers()
	{
		return $this->hasMany(UserAttemptAnswer::class, 'attempt_id');
	}

    public function scopeWithMainPhase($q)
    {
        return $q->when(session('dashboard_phase_id'), function ($q) {
            $q->whereHas('lecture', function ($q) {
                $q->whereHas('course', function ($q) {
                    $q->where('phase_id', session('dashboard_phase_id'));
                });
            });
        });
    }
}
