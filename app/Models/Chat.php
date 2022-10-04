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

/**
 * Class Chat
 *
 * @property int $id
 * @property int|null $phase_id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Phase|null $phase
 * @property Collection|ChatMessage[] $chat_messages
 * @property Collection|User[] $users
 * @package App\Models
 * @property-read int|null $chat_messages_count
 * @property-read mixed $status_value
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Chat active()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat available()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat hidden()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newQuery()
 * @method static \Illuminate\Database\Query\Builder|Chat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat wherePhaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Chat withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Chat withoutTrashed()
 */
class Chat extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'chats';

	protected $casts = [
		'phase_id' => 'int'
	];

	protected $fillable = [
		'phase_id'
	];

	public function phase()
	{
		return $this->belongsTo(Phase::class);
	}

	public function messages()
	{
		return $this->hasMany(ChatMessage::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_chats')
					->withPivot('id')
					->withTimestamps();
	}
}
