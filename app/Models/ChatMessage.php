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
 * Class ChatMessage
 *
 * @property int $id
 * @property int|null $chat_id
 * @property int|null $user_id
 * @property string $message
 * @property boolean $is_file
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Chat|null $chat
 * @property User|null $user
 * @package App\Models
 * @property-read mixed $status_value
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage active()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage available()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage hidden()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage newQuery()
 * @method static \Illuminate\Database\Query\Builder|ChatMessage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|ChatMessage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ChatMessage withoutTrashed()
 */
class ChatMessage extends Model
{
	use SoftDeletes, HasFactory;
	protected $table = 'chat_messages';

	protected $casts = [
		'chat_id' => 'int',
		'is_file' => 'boolean',
		'user_id' => 'int'
	];

	protected $fillable = [
		'chat_id',
		'user_id',
		'is_file',
		'message'
	];

	public function chat()
	{
		return $this->belongsTo(Chat::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
