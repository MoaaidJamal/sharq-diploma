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
 * Class UsersLecture
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
 *
 * @package App\Models
 */
class UsersLecture extends Model
{
	use HasFactory;
	protected $table = 'users_lectures';

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
		return $this->belongsTo(Lecture::class, 'lecture_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
