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
 * Class Question
 *
 * @property int $id
 * @property int|null $lecture_id
 * @property string|null $question
 * @property string|null $answer1
 * @property string|null $answer2
 * @property string|null $answer3
 * @property string|null $answer4
 * @property int|null $order
 * @property int|null $correct_answer
 * @property int|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Lecture|null $lecture
 *
 * @package App\Models
 */
class Question extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'questions';

	protected $casts = [
		'lecture_id' => 'int',
        'order' => 'int',
		'correct_answer' => 'int',
		'enabled' => 'int'
	];

	protected $fillable = [
		'lecture_id',
		'question',
		'answer1',
		'answer2',
		'answer3',
		'answer4',
		'order',
		'correct_answer',
		'enabled'
	];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::query()->max('order') + 1;
        });
    }

	public function lecture()
	{
		return $this->belongsTo(Lecture::class);
	}
}
