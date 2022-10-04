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
 * Class File
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $path
 * @property string $file_type
 * @property int $file_id
 * @property int $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class File extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'files';

	protected $casts = [
		'file_id' => 'int',
		'enabled' => 'int'
	];

	protected $fillable = [
		'name',
		'path',
		'file_type',
		'file_id',
        'enabled',
	];

    public function getPathAttribute($file){
        return $file && file_exists(public_path($file)) ? url($file) : url('assets/images/image_placeholder.png');
    }

    public function file() {
        return $this->morphTo();
    }
}
