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

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TmdbCredit.
 *
 * @property int         $id
 * @property int         $tmdb_person_id
 * @property int|null    $tmdb_movie_id
 * @property int|null    $tmdb_tv_id
 * @property int         $occupation_id
 * @property int|null    $order
 * @property string|null $character
 */
class TmdbCredit extends Model
{
    /** @use HasFactory<\Database\Factories\TmdbCreditFactory> */
    use HasFactory;

    /**
     * Indicates If The Model Should Be Timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Occupation, $this>
     */
    public function occupation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Occupation::class, 'occupation_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TmdbPerson, $this>
     */
    public function person(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TmdbPerson::class, 'tmdb_person_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TmdbTv, $this>
     */
    public function tv(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TmdbTv::class, 'tmdb_tv_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TmdbMovie, $this>
     */
    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TmdbMovie::class, 'tmdb_movie_id');
    }
}
