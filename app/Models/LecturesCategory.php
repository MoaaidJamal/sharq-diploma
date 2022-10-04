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
 * Class LecturesCategory
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $image
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Lecture[] $lectures
 *
 * @package App\Models
 */
class LecturesCategory extends Model
{
    use SoftDeletes, HasFactory, HasTranslations;
    public $translatable = ['title'];

	protected $table = 'lectures_categories';

	protected $casts = [
		'enabled' => 'int'
	];

	protected $fillable = [
		'title',
		'image',
		'enabled'
	];

    public function getImageAttribute($file){
        return $file && file_exists(public_path($file)) ? url($file) : url('uploads/image_placeholder.png');
    }

	public function lectures()
	{
		return $this->hasMany(Lecture::class, 'category_id');
	}
}
