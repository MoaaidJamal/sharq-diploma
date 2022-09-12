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
 * Class Slider
 *
 * @property int $id
 * @property string|null $image
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Slider extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'sliders';

	protected $casts = [
		'enabled' => 'int'
	];

	protected $fillable = [
		'image',
		'enabled'
	];

    public function getImageAttribute($file){
        return $file && file_exists(base_path($file)) ? url($file) : url('uploads/image_placeholder.png');
    }
}
