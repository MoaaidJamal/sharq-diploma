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
 * Class UsersVerification
 * 
 * @property int $id
 * @property int|null $user_id
 * @property string|null $email
 * @property string|null $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class UsersVerification extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'users_verifications';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'user_id',
		'email',
		'token'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
