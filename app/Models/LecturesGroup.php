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
 * Class LecturesGroup
 *
 * @property int $id
 * @property int|null $course_id
 * @property int|null $order
 * @property string|null $title
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Course|null $course
 * @property Collection|Lecture[] $lectures
 *
 * @package App\Models
 */
class LecturesGroup extends Model
{
    use SoftDeletes, HasFactory, HasTranslations;
    public $translatable = ['title'];

	protected $table = 'lectures_groups';

	protected $casts = [
		'order' => 'int',
		'course_id' => 'int',
		'enabled' => 'int'
	];

	protected $fillable = [
		'order',
		'course_id',
		'title',
		'enabled'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function lectures()
	{
		return $this->hasMany(Lecture::class, 'group_id')->orderBy('order');
	}

    public function getLecturesCount(){
        return $this->lectures->count();
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::query()->max('order') + 1;
        });
    }

    public function next()
    {
        return $this->getOriginal('order') ? self::query()->where('order', '>', $this->getOriginal('order'))->where('course_id', $this->course_id)->orderBy('order')->first() : null;
    }

    public function previous()
    {
        return $this->getOriginal('order') ? self::query()->where('order', '<', $this->getOriginal('order'))->where('course_id', $this->course_id)->orderBy('order', 'DESC')->first() : null;
    }

    public function scopeWithMainPhase($q)
    {
        return $q->when(session('dashboard_phase_id'), function ($q) {
            $q->whereHas('course', function ($q) {
                $q->where('phase_id', session('dashboard_phase_id'));
            });
        });
    }
}
