<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersChat
 *
 * @property int $id
 * @property int|null $chat_id
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Chat|null $chat
 * @property User|null $user
 * @package App\Models
 * @property-read mixed $status_value
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat active()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat available()
 * @method static \Database\Factories\UsersChatFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat hidden()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat query()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersChat whereUserId($value)
 * @mixin \Eloquent
 */
class UsersChat extends Model
{
	use HasFactory;
	protected $table = 'users_chats';

	protected $casts = [
		'chat_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'chat_id',
		'user_id'
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
