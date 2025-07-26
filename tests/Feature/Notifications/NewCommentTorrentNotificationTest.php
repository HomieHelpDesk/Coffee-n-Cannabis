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

use App\Http\Livewire\Comments;
use App\Models\Bot;
use App\Models\Chatroom;
use App\Models\Comment;
use App\Models\Group;
use App\Models\Torrent;
use App\Models\User;
use App\Models\UserNotification;
use App\Notifications\NewComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('comment own torrent does not create a notification for self', function (): void {
    Notification::fake();

    // Required for ChatRepository()
    $this->seed(UsersTableSeeder::class);

    $bot = Bot::factory()->create([
        'command' => 'Systembot',
    ]);
    $chat = Chatroom::factory()->create([
        'name' => config('chat.system_chatroom'),
    ]);

    $group = Group::factory()->create([
        'can_comment' => true,
        'can_request' => true,
    ]);

    $uploader = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);

    $uploaderNotificationSettings = UserNotification::factory()->for($uploader)->create([
        'block_notifications'  => 0,
        'show_torrent_comment' => 1,
    ]);

    $torrent = Torrent::factory()->for($uploader)->create();

    $commentText = 'This is a test comment';

    Livewire::actingAs($uploader)
        ->test(Comments::class, ['model' => $torrent])
        ->set('newCommentState', $commentText)
        ->set('anon', false)
        ->call('postComment');

    $this->assertEquals(1, Comment::count());

    Notification::assertCount(0);
});

test('comment a torrent creates a notification for the uploader', function (): void {
    Notification::fake();

    // Required for ChatRepository()
    $this->seed(UsersTableSeeder::class);

    $bot = Bot::factory()->create([
        'command' => 'Systembot',
    ]);
    $chat = Chatroom::factory()->create([
        'name' => config('chat.system_chatroom'),
    ]);

    $group = Group::factory()->create([
        'can_comment' => true,
        'can_request' => true,
    ]);

    $uploader = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);
    $commenter = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);

    $fillerNotificationSettings = UserNotification::factory()->for($uploader)->create([
        'block_notifications'  => 0,
        'show_torrent_comment' => 1,
    ]);

    $torrent = Torrent::factory()->for($uploader)->create();

    $commentText = 'This is a test comment';

    Livewire::actingAs($commenter)
        ->test(Comments::class, ['model' => $torrent])
        ->set('newCommentState', $commentText)
        ->set('anon', false)
        ->call('postComment');

    $this->assertEquals(1, Comment::count());

    Notification::assertSentTo(
        [$uploader],
        NewComment::class
    );
    Notification::assertCount(1);
});

test('comment a torrent creates a notification for the requester when request comment notifications are not disabled for specific group', function (): void {
    Notification::fake();

    // Required for ChatRepository()
    $this->seed(UsersTableSeeder::class);

    $bot = Bot::factory()->create([
        'command' => 'Systembot',
    ]);
    $chat = Chatroom::factory()->create([
        'name' => config('chat.system_chatroom'),
    ]);

    $group = Group::factory()->create([
        'can_comment' => true,
        'can_request' => true,
    ]);
    $randomGroup = Group::factory()->create();

    $uploader = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);
    $commenter = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);

    $fillerNotificationSettings = UserNotification::factory()->for($uploader)->create([
        'block_notifications'  => 0,
        'show_torrent_comment' => 1,
        'json_torrent_groups'  => [$randomGroup->id],
    ]);

    $torrent = Torrent::factory()->for($uploader)->create();

    $commentText = 'This is a test comment';

    Livewire::actingAs($commenter)
        ->test(Comments::class, ['model' => $torrent])
        ->set('newCommentState', $commentText)
        ->set('anon', false)
        ->call('postComment');

    $this->assertEquals(1, Comment::count());

    Notification::assertSentTo(
        [$uploader],
        NewComment::class
    );
    Notification::assertCount(1);
});

test('comment a torrent creates a notification for the requester when all notifications are disabled', function (): void {
    Notification::fake();

    // Required for ChatRepository()
    $this->seed(UsersTableSeeder::class);

    $bot = Bot::factory()->create([
        'command' => 'Systembot',
    ]);
    $chat = Chatroom::factory()->create([
        'name' => config('chat.system_chatroom'),
    ]);

    $group = Group::factory()->create([
        'can_comment' => true,
        'can_request' => true,
    ]);

    $uploader = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);
    $commenter = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);

    $fillerNotificationSettings = UserNotification::factory()->for($uploader)->create([
        'block_notifications'  => 1,
        'show_torrent_comment' => 1,
    ]);

    $torrent = Torrent::factory()->for($uploader)->create();

    $commentText = 'This is a test comment';

    Livewire::actingAs($commenter)
        ->test(Comments::class, ['model' => $torrent])
        ->set('newCommentState', $commentText)
        ->set('anon', false)
        ->call('postComment');

    $this->assertEquals(1, Comment::count());

    Notification::assertCount(0);
});

test('comment a torrent creates a notification for the requester when request comment notifications are disabled', function (): void {
    Notification::fake();

    // Required for ChatRepository()
    $this->seed(UsersTableSeeder::class);

    $bot = Bot::factory()->create([
        'command' => 'Systembot',
    ]);
    $chat = Chatroom::factory()->create([
        'name' => config('chat.system_chatroom'),
    ]);

    $group = Group::factory()->create([
        'can_comment' => true,
        'can_request' => true,
    ]);

    $uploader = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);
    $commenter = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);

    $fillerNotificationSettings = UserNotification::factory()->for($uploader)->create([
        'block_notifications'  => 0,
        'show_torrent_comment' => 0,
    ]);

    $torrent = Torrent::factory()->for($uploader)->create();

    $commentText = 'This is a test comment';

    Livewire::actingAs($commenter)
        ->test(Comments::class, ['model' => $torrent])
        ->set('newCommentState', $commentText)
        ->set('anon', false)
        ->call('postComment');

    $this->assertEquals(1, Comment::count());

    Notification::assertCount(0);
});

test('comment a torrent creates a notification for the requester when request comment notifications are disabled for specific group', function (): void {
    Notification::fake();

    // Required for ChatRepository()
    $this->seed(UsersTableSeeder::class);

    $bot = Bot::factory()->create([
        'command' => 'Systembot',
    ]);
    $chat = Chatroom::factory()->create([
        'name' => config('chat.system_chatroom'),
    ]);

    $group = Group::factory()->create([
        'can_comment' => true,
        'can_request' => true,
    ]);

    $uploader = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);
    $commenter = User::factory()->create([
        'group_id'    => $group->id,
        'can_comment' => true,
        'can_request' => true,
    ]);

    $fillerNotificationSettings = UserNotification::factory()->for($uploader)->create([
        'block_notifications'  => 0,
        'show_torrent_comment' => 1,
        'json_torrent_groups'  => [$group->id],
    ]);

    $torrent = Torrent::factory()->for($uploader)->create();

    $commentText = 'This is a test comment';

    Livewire::actingAs($commenter)
        ->test(Comments::class, ['model' => $torrent])
        ->set('newCommentState', $commentText)
        ->set('anon', false)
        ->call('postComment');

    $this->assertEquals(1, Comment::count());

    Notification::assertCount(0);
});
