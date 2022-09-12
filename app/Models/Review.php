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
 * Class Review
 * 
 * @property int $id
 * @property string|null $comment
 * @property int|null $rate
 * @property string $review_type
 * @property int $review_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Review extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'reviews';

	protected $casts = [
		'rate' => 'int',
		'review_id' => 'int'
	];

	protected $fillable = [
		'comment',
		'rate',
		'review_type',
		'review_id'
	];
}
