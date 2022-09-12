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
use Spatie\Translatable\HasTranslations;

/**
 * Class Interest
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Interest extends Model
{
	use SoftDeletes, HasFactory, HasTranslations;
    public $translatable = ['name'];

	protected $table = 'interests';

	protected $casts = [
		'enabled' => 'int'
	];

	protected $fillable = [
		'name',
		'enabled'
	];

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_interests')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
}
