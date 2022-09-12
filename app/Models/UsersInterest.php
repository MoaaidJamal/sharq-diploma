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
 * Class UsersInterest
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $interest_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Interest|null $interest
 * @property User|null $user
 *
 * @package App\Models
 */
class UsersInterest extends Model
{
	use HasFactory;
	protected $table = 'users_interests';

	protected $casts = [
		'user_id' => 'int',
		'interest_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'interest_id'
	];

	public function interest()
	{
		return $this->belongsTo(Interest::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
