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
 * @author     Roardom <roardom@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Notifications;

use App\Interfaces\SystemNotificationInterface;
use App\Models\Torrent;
use App\Models\User;
use App\Notifications\Channels\SystemNotificationChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;

class TorrentsDeleted extends Notification implements ShouldQueue, SystemNotificationInterface
{
    use Queueable;

    /**
     * @param Collection<int, Torrent> $torrents
     */
    public function __construct(public Collection $torrents, public string $title, public string $reason)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return class-string
     */
    public function via(object $notifiable): string
    {
        return SystemNotificationChannel::class;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toSystemNotification(User $notifiable): array
    {
        return [
            'subject' => 'Bulk Torrents Deleted - '.$this->title.'! ',
            'message' => <<<BBCODE
            [b]Attention:[/b] The following torrents have been removed from our site.

            [list]
            [*]{$this->torrents->pluck('name')->join("\n[*]")}
            [/list]

            Our system shows that you were either the uploader, a seeder or a leecher on said torrent. We just wanted to let you know you can safely remove it from your client.

            [b]Removal Reason:[/b] {$this->reason}
            BBCODE
        ];
    }
}
