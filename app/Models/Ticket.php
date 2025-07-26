<?php

declare(strict_types=1);

/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ticket.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $category_id
 * @property int                             $priority_id
 * @property int|null                        $staff_id
 * @property bool                            $user_read
 * @property bool                            $staff_read
 * @property string                          $subject
 * @property string                          $body
 * @property \Illuminate\Support\Carbon|null $closed_at
 * @property \Illuminate\Support\Carbon|null $reminded_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $deleted_at
 */
class Ticket extends Model
{
    use Auditable;

    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array{user_read: 'bool', staff_read: 'bool', closed_at: 'datetime', reminded_at: 'datetime'}
     */
    protected function casts(): array
    {
        return [
            'user_read'   => 'bool',
            'staff_read'  => 'bool',
            'closed_at'   => 'datetime',
            'reminded_at' => 'datetime',
        ];
    }

    /**
     * Belongs To A User (Created).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'System',
            'id'       => User::SYSTEM_USER_ID,
        ]);
    }

    /**
     * Belongs To A Staff User (Assigned).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this>
     */
    public function staff(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Belongs To A Ticket Priority.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TicketPriority, $this>
     */
    public function priority(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TicketPriority::class);
    }

    /**
     * Belongs To A Ticket Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TicketCategory, $this>
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TicketCategory::class);
    }

    /**
     * Has Many Ticket Attachments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<TicketAttachment, $this>
     */
    public function attachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<Comment, $this>
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Has Many Ticket Notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<TicketNote, $this>
     */
    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TicketNote::class);
    }
}
