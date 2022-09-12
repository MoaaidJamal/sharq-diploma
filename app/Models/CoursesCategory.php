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

/**
 * Class CoursesCategory
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Course[] $courses
 *
 * @package App\Models
 */
class CoursesCategory extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'courses_categories';

	protected $casts = [
		'enabled' => 'int'
	];

	protected $fillable = [
		'title',
		'enabled'
	];

	public function courses()
	{
		return $this->hasMany(Course::class, 'category_id');
	}
}
