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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('playlist_suggestions', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedInteger('torrent_id');
            $table->unsignedInteger('user_id');
            $table->text('message');
            $table->timestamps();

            $table->foreign('playlist_id')->references('id')->on('playlists')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('torrent_id')->references('id')->on('torrents')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
        });
    }
};
