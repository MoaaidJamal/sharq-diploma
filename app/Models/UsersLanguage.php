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
 * Class UsersLanguage
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $language_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Language|null $language
 * @property User|null $user
 *
 * @package App\Models
 */
class UsersLanguage extends Model
{
	use HasFactory;
	protected $table = 'users_languages';

	protected $casts = [
		'user_id' => 'int',
		'language_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'language_id'
	];

	public function language()
	{
		return $this->belongsTo(Language::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
