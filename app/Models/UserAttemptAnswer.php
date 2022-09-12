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
 * Class UserAttemptAnswer
 *
 * @property int $id
 * @property int|null $attempt_id
 * @property int|null $question_id
 * @property int|null $answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property UserAttempt|null $user_attempt
 * @property Lecture|null $lecture
 *
 * @package App\Models
 */
class UserAttemptAnswer extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'users_attempts_answers';

	protected $casts = [
		'attempt_id' => 'int',
		'question_id' => 'int',
		'answer' => 'int'
	];

	protected $fillable = [
		'attempt_id',
		'question_id',
		'answer'
	];

	public function user_attempt()
	{
		return $this->belongsTo(UserAttempt::class, 'attempt_id');
	}

	public function question()
	{
		return $this->belongsTo(Question::class, 'question_id');
	}
}
