<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $image
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Country extends Model
{
	use SoftDeletes, HasFactory, SoftCascadeTrait;

	protected $table = 'countries';

	protected $casts = [
		'enabled' => 'int'
	];

	protected $fillable = [
		'name',
		'image',
		'enabled'
	];

    public function getImageAttribute($file){
        return $file && file_exists(public_path($file)) ? url($file) : url('uploads/image_placeholder.png');
    }

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
