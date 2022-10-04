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
 * Class UsersPhase
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $phase_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Phase|null $phase
 * @property User|null $user
 *
 * @package App\Models
 */
class UsersPhase extends Model
{
	use HasFactory;
	protected $table = 'users_phases';

	protected $casts = [
		'user_id' => 'int',
		'phase_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'phase_id'
	];

	public function phase()
	{
		return $this->belongsTo(Phase::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
