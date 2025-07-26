<section class="panelV2 blocks__uploaders" x-data="{ tab: @entangle('tab').live }">
    <h2 class="panel__heading">Top Users</h2>
    <menu class="panel__tabs">
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'uploaders' && 'panel__tab--active'"
            x-on:click="tab = 'uploaders'"
        >
            Uploaders
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'downloaders' && 'panel__tab--active'"
            x-on:click="tab = 'downloaders'"
        >
            Downloaders
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'uploaded' && 'panel__tab--active'"
            x-on:click="tab = 'uploaded'"
        >
            Uploaded
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'downloaded' && 'panel__tab--active'"
            x-on:click="tab = 'downloaded'"
        >
            Downloaded
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'seeders' && 'panel__tab--active'"
            x-on:click="tab = 'seeders'"
        >
            Seeders
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'seedtime' && 'panel__tab--active'"
            x-on:click="tab = 'seedtime'"
        >
            Seedtime
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'served' && 'panel__tab--active'"
            x-on:click="tab = 'served'"
        >
            Users Served
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'commenters' && 'panel__tab--active'"
            x-on:click="tab = 'commenters'"
        >
            Commenters
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'posters' && 'panel__tab--active'"
            x-on:click="tab = 'posters'"
        >
            Posters
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'thankers' && 'panel__tab--active'"
            x-on:click="tab = 'thankers'"
        >
            Thankers
        </li>
        <li
            class="panel__tab"
            role="tab"
            x-bind:class="tab === 'personals' && 'panel__tab--active'"
            x-on:click="tab = 'personals'"
        >
            Personal Releases
        </li>
    </menu>
    <div class="panel__body" wire:loading.block>Loading...</div>
    <div class="panel__body" wire:loading.remove>
        <div class="user-stat-card-container">
            @switch($this->tab)
                @case('uploaders')
                    @foreach ($this->uploaders as $uploader)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$uploader->user"
                                    :anon="$uploader->user->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">{{ $uploader->value }} Uploads</h4>

                            @if ($uploader->user->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $uploader->user->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $uploader->user]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('downloaders')
                    @foreach ($this->downloaders as $downloader)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$downloader->user"
                                    :anon="$downloader->user->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">
                                {{ $downloader->value }} Downloads
                            </h4>

                            @if ($downloader->user->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $downloader->user->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $downloader->user]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('uploaded')
                    @foreach ($this->uploaded as $upload)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$upload"
                                    :anon="$upload->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">
                                {{ App\Helpers\StringHelper::formatBytes($upload->uploaded, 2) }}
                                Uploaded
                            </h4>

                            @if ($upload->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $upload->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $upload]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('downloaded')
                    @foreach ($this->downloaded as $download)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$download"
                                    :anon="$download->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">
                                {{ App\Helpers\StringHelper::formatBytes($download->downloaded, 2) }}
                                Downloaded
                            </h4>

                            @if ($download->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $download->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $download]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('seeders')
                    @foreach ($this->seeders as $seeder)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$seeder->user"
                                    :anon="$seeder->user->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">{{ $seeder->value }} Seeds</h4>

                            @if ($seeder->user->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $seeder->user->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $seeder->user]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('seedtime')
                    @foreach ($this->seedtimes as $seedtime)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$seedtime"
                                    :anon="$seedtime->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">
                                {{ App\Helpers\StringHelper::timeElapsed($seedtime->seedtime ?? 0) }}
                                {{ __('user.total-seedtime') }}
                            </h4>

                            @if ($seedtime->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $seedtime->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $seedtime]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('served')
                    @foreach ($this->served as $serve)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$serve"
                                    :anon="$serve->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">
                                {{ $serve->upload_snatches_count }} Users Served
                            </h4>

                            @if ($serve->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $serve->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $serve]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('commenters')
                    @foreach ($this->commenters as $commenter)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$commenter->user"
                                    :anon="$commenter->user->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">
                                {{ $commenter->value }} Comments Made
                            </h4>

                            @if ($commenter->user->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $commenter->user->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $commenter->user]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('posters')
                    @foreach ($this->posters as $poster)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$poster->user"
                                    :anon="$poster->user->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">{{ $poster->value }} Posts Made</h4>

                            @if ($poster->user->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $poster->user->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $poster->user]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('thankers')
                    @foreach ($this->thankers as $thanker)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$thanker->user"
                                    :anon="$thanker->user->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">
                                {{ $thanker->value }} Thanks Given
                            </h4>

                            @if ($thanker->user->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $thanker->user->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $thanker->user]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
                @case('personals')
                    @foreach ($this->personals as $personal)
                        <article class="user-stat-card">
                            <h3 class="user-stat-card__username">
                                <x-user-tag
                                    :user="$personal->user"
                                    :anon="$personal->user->privacy?->private_profile"
                                />
                                <div title="Place" class="top-users__place">
                                    {{ Number::ordinal($loop->iteration) }}
                                </div>
                            </h3>
                            <h4 class="user-stat-card__stat">
                                {{ $personal->value }} Personal Releases
                            </h4>

                            @if ($personal->user->privacy?->private_profile)
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ url('img/profile.png') }}"
                                />
                            @else
                                <img
                                    class="user-stat-card__avatar"
                                    alt=""
                                    src="{{ $personal->user->image === null ? url('img/profile.png') : route('authenticated_images.user_avatar', ['user' => $personal->user]) }}"
                                />
                            @endif
                        </article>
                    @endforeach

                    @break
            @endswitch
        </div>
    </div>
</section>
