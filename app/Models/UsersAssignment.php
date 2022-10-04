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
 * Class UsersAssignment
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $lecture_id
 * @property float|null $grade
 * @property string|null $file
 * @property string|null $file_name
 * @property string|null $comment
 * @property string|null $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Lecture|null $lecture
 * @property User|null $user
 *
 * @package App\Models
 */
class UsersAssignment extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'users_assignments';

	protected $casts = [
		'grade' => 'float',
		'user_id' => 'int',
		'lecture_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'lecture_id',
		'file',
		'file_name',
		'grade',
		'comment',
		'content'
	];

    public function getFileAttribute($file){
        return $file && file_exists(public_path($file)) ? url($file) : url('uploads/image_placeholder.png');
    }

	public function lecture()
	{
		return $this->belongsTo(Lecture::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function scopeWithMainPhase($q)
    {
        return $q->when(session('dashboard_phase_id'), function ($q) {
            $q->whereHas('lecture', function ($q) {
                $q->whereHas('course', function ($q) {
                    $q->where('phase_id', session('dashboard_phase_id'));
                });
            });
        });
    }
}
