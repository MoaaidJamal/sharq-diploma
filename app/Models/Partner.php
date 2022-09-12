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
 * Class Partner
 *
 * @property int $id
 * @property string|null $image
 * @property string|null $url
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Partner extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'partners';

	protected $casts = [
		'enabled' => 'int'
	];

    public function getImageAttribute($file){
        return $file && file_exists(base_path($file)) ? url($file) : url('uploads/image_placeholder.png');
    }

	protected $fillable = [
		'image',
		'url',
		'enabled'
	];
}
