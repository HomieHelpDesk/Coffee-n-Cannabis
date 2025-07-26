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

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Playlist;
use App\Models\Torrent;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AuthenticatedImageController extends Controller
{
    private const array HEADERS = [
        'Cache-Control' => 'private, max-age=7200',
    ];

    public function articleImage(Article $article): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = $article->image === null
            ? public_path('img/missing-image.png')
            : Storage::disk('article-images')->path($article->image);

        abort_unless(file_exists($path), 404);

        return response()->file($path, self::HEADERS);
    }

    public function categoryImage(Category $category): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = Storage::disk('category-images')->path($category->image);

        abort_unless(file_exists($path), 404);

        return response()->file($path, self::HEADERS);
    }

    public function playlistImage(Playlist $playlist): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = Storage::disk('playlist-images')->path($playlist->cover_image);

        abort_unless(file_exists($path), 404);

        return response()->file($path, self::HEADERS);
    }

    public function torrentBanner(Torrent $torrent): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = Storage::disk('torrent-banners')->path("torrent-banner_{$torrent->id}.jpg");

        abort_unless(file_exists($path), 404);

        return response()->file($path, self::HEADERS);
    }

    public function torrentCover(Torrent $torrent): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = Storage::disk('torrent-covers')->path("torrent-cover_{$torrent->id}.jpg");

        abort_unless(file_exists($path), 404);

        return response()->file($path, self::HEADERS);
    }

    public function userAvatar(User $user): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = Storage::disk('user-avatars')->path($user->image);

        abort_unless(file_exists($path), 404);

        return response()->file($path, self::HEADERS);
    }

    public function userIcon(User $user): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = Storage::disk('user-icons')->path($user->icon);

        abort_unless(file_exists($path), 404);

        return response()->file($path, self::HEADERS);
    }
}
