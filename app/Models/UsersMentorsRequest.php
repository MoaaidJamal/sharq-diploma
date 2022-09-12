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
 * Class UsersMentorsRequest
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $mentor_id
 * @property Carbon|null $date_from
 * @property Carbon|null $date_to
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class UsersMentorsRequest extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'users_mentors_requests';

	protected $casts = [
		'user_id' => 'int',
		'mentor_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'mentor_id',
		'date_from',
		'date_to'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function mentor()
	{
		return $this->belongsTo(User::class, 'mentor_id');
	}
}
