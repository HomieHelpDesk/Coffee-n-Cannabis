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

use App\Enums\AuthGuard;
use App\Models\Category;
use App\Models\Torrent;
use App\Models\User;

test('filter returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $user = User::factory()->create();

    $response = $this->actingAs($user, AuthGuard::API->value)->getJson('api/torrents/filter');
    $response->assertOk();
    $response->assertJsonStructure([
    ]);
});

test('index returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $torrents = Torrent::factory()->times(3)->create();

    $response = $this->getJson(route('api.torrents.index'));

    $response->assertOk();
    $response->assertJsonStructure([
        // TODO: compare expected response data
    ]);

    // TODO: perform additional assertions
});

test('show returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $torrent = Torrent::factory()->create();

    $response = $this->getJson('api/torrents/{id}');

    $response->assertOk();
    $response->assertJsonStructure([
        // TODO: compare expected response data
    ]);

    // TODO: perform additional assertions
});

test('store returns an ok response', function (): void {
    $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

    $category = Category::factory()->create();
    $user = User::factory()->create();

    $response = $this->postJson('api/torrents/upload', [
        // TODO: send request data
    ]);

    $response->assertOk();
    $response->assertJsonStructure([
        // TODO: compare expected response data
    ]);

    // TODO: perform additional assertions
});

// test cases...
