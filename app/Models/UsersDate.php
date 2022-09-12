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
 * Class UsersDate
 *
 * @property int $id
 * @property int|null $user_id
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
class UsersDate extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'users_dates';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'date_from',
		'date_to'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
