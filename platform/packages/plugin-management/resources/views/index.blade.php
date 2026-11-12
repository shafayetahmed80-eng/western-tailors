@extends(BaseHelper::getAdminMasterLayoutTemplate())

@push('header')
    <style>
        .plugin-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .plugin-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .plugin-card .card-img-top {
            border-bottom: 1px solid var(--bb-border-color);
        }
        .plugin-card .plugin-image-placeholder {
            background: var(--bb-card-cap-bg);
        }
        .plugin-card .plugin-icon-wrapper {
            background: rgba(var(--bb-primary-rgb), 0.1);
        }
        .plugin-card .card-footer {
            background: var(--bb-card-cap-bg);
        }
    </style>
@endpush

@push('header-action')
    @if (
        $isEnabledMarketplaceFeature =
            config('packages.plugin-management.general.enable_marketplace_feature') &&
            auth()->user()->hasPermission('plugins.marketplace'))
        <x-core::button
            tag="a"
            :href="route('plugins.new')"
            color="primary"
            icon="ti ti-plus"
            class="ms-auto"
        >
            {{ trans('packages/plugin-management::plugin.plugins_add_new') }}
        </x-core::button>
    @endif

    {!! apply_filters('plugin_management_installed_header_actions', null) !!}
@endpush

@section('content')
    @if ($plugins->isNotEmpty())
        <x-core::card class="mb-4">
            <x-core::card.body class="py-3">
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-between align-items-sm-center">
                    <div class="w-100" style="max-width: 320px;">
                        <x-core::form.text-input
                            type="search"
                            name="search"
                            :placeholder="trans('packages/plugin-management::plugin.search')"
                            :group-flat="true"
                            data-bb-toggle="change-search"
                        >
                            <x-slot:prepend>
                                <span class="input-group-text">
                                    <x-core::icon name="ti ti-search" />
                                </span>
                            </x-slot:prepend>
                        </x-core::form.text-input>
                    </div>

                    <div class="flex-shrink-0">
                        <div class="d-block d-sm-none dropdown">
                            <x-core::button
                                class="dropdown-toggle"
                                data-bs-toggle="dropdown"
                            >
                                <span
                                    data-bb-toggle="status-filter-label"
                                    class="ms-1"
                                >
                                    {{ $filterStatuses[array_key_first($filterStatuses)] }}
                                    (<span
                                        data-bb-toggle="plugins-count"
                                        data-status="{{ array_key_first($filterStatuses) }}"
                                    >{{ $plugins->count() }}</span>)
                                </span>
                            </x-core::button>
                            <div
                                class="dropdown-menu dropdown-menu-end"
                                data-popper-placement="bottom-end"
                            >
                                @foreach ($filterStatuses as $key => $value)
                                    <button
                                        @class(['dropdown-item', 'active' => $loop->first])
                                        type="button"
                                        data-value="{{ $key }}"
                                        data-bb-toggle="change-filter-plugin-status"
                                    >
                                        {{ $value }}
                                        (<span
                                            data-bb-toggle="plugins-count"
                                            data-status="{{ $key }}"
                                        >0</span>)
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-none d-sm-flex form-selectgroup">
                            @foreach ($filterStatuses as $key => $value)
                                <label class="form-selectgroup-item">
                                    <input
                                        type="radio"
                                        name="status"
                                        value="{{ $key }}"
                                        data-bb-toggle="change-filter-plugin-status"
                                        class="form-selectgroup-input"
                                        @checked($loop->first)
                                    />
                                    <span class="form-selectgroup-label">
                                        {{ $value }}
                                        (<span
                                            data-bb-toggle="plugins-count"
                                            data-status="{{ $key }}"
                                        >0</span>)
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-core::card.body>
        </x-core::card>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4 plugin-list">
            @foreach ($plugins as $plugin)
                <div
                    class="col plugin-item"
                    data-name="{{ $plugin->name }}"
                    data-author="{{ $plugin->author }}"
                    data-description="{{ $plugin->description }}"
                    data-status="{{ $plugin->status ? 'activated' : 'not-activated' }}"
                >
                    <x-core::card class="h-100 plugin-card">
                        <div class="position-relative">
                            <div
                                @class(['card-img-top d-flex align-items-center justify-content-center', 'plugin-image-placeholder' => !$plugin->image])
                                @style([
                                    'height: 120px',
                                    "background-image: url('$plugin->image'); background-size: cover; background-position: center" => $plugin->image,
                                ])
                            >
                                @if (!$plugin->image)
                                    <div class="avatar avatar-xl rounded plugin-icon-wrapper">
                                        <x-core::icon
                                            name="ti ti-puzzle"
                                            class="text-primary"
                                            style="font-size: 2rem;"
                                        />
                                    </div>
                                @endif
                            </div>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span @class([
                                    'badge',
                                    'bg-green-lt text-green' => $plugin->status,
                                    'bg-secondary-lt text-secondary' => !$plugin->status,
                                ])>
                                    <x-core::icon
                                        :name="$plugin->status ? 'ti ti-circle-check' : 'ti ti-circle-x'"
                                        class="me-1"
                                    />
                                    {{ $plugin->status ? trans('packages/plugin-management::plugin.activated') : trans('packages/plugin-management::plugin.deactivated') }}
                                </span>
                            </div>
                        </div>

                        <x-core::card.body class="d-flex flex-column">
                            <div class="mb-3">
                                <h4 class="card-title mb-1" title="{{ $plugin->name }}">
                                    <span class="text-truncate d-block">{{ $plugin->name }}</span>
                                </h4>
                                @if ($plugin->description)
                                    <p
                                        class="text-secondary small mb-0"
                                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.5em;"
                                        title="{{ $plugin->description }}"
                                    >
                                        {{ $plugin->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex flex-wrap gap-2 text-secondary small">
                                    @if (!config('packages.plugin-management.general.hide_plugin_author', false) && $plugin->author)
                                        <div class="d-flex align-items-center gap-1">
                                            <x-core::icon name="ti ti-user" class="text-muted" />
                                            @if (!empty($plugin->url))
                                                <a
                                                    href="{{ $plugin->url }}"
                                                    target="_blank"
                                                    class="text-reset text-decoration-none"
                                                >{{ $plugin->author }}</a>
                                            @else
                                                <span>{{ $plugin->author }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($plugin->version)
                                        <div class="d-flex align-items-center gap-1 ms-auto">
                                            <x-core::icon name="ti ti-tag" class="text-muted" />
                                            <span>v{{ $plugin->version }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </x-core::card.body>

                        <x-core::card.footer>
                            <div class="btn-list justify-content-center">
                                @if (auth()->user()->hasPermission('plugins.edit'))
                                    <x-core::button
                                        type="button"
                                        size="sm"
                                        :color="$plugin->status ? 'warning' : 'primary'"
                                        class="btn-trigger-change-status"
                                        :icon="$plugin->status ? 'ti ti-player-pause' : 'ti ti-player-play'"
                                        data-plugin="{{ $plugin->path }}"
                                        data-status="{{ $plugin->status }}"
                                        :data-check-requirement-url="route('plugins.check-requirement', ['name' => $plugin->path])"
                                        :data-change-status-url="route('plugins.change.status', ['name' => $plugin->path])"
                                    >
                                        @if ($plugin->status)
                                            {{ trans('packages/plugin-management::plugin.deactivate') }}
                                        @else
                                            {{ trans('packages/plugin-management::plugin.activate') }}
                                        @endif
                                    </x-core::button>
                                @endif

                                @if ($isEnabledMarketplaceFeature)
                                    <x-core::button
                                        class="btn-trigger-update-plugin"
                                        color="success"
                                        size="sm"
                                        icon="ti ti-refresh"
                                        style="display: none;"
                                        data-name="{{ $plugin->path }}"
                                        data-check-update="{{ $plugin->id ?? 'plugin-' . $plugin->path }}"
                                        :data-check-update-url="route('plugins.marketplace.ajax.check-update')"
                                        :data-update-url="route('plugins.marketplace.ajax.update', [
                                            'id' => '__id__',
                                            'name' => $plugin->path,
                                        ])"
                                        data-version="{{ $plugin->version }}"
                                    >
                                        {{ trans('packages/plugin-management::plugin.update') }}
                                    </x-core::button>
                                @endif

                                @if (auth()->user()->hasPermission('plugins.remove'))
                                    <x-core::button
                                        type="button"
                                        size="sm"
                                        color="danger"
                                        :outlined="true"
                                        class="btn-trigger-remove-plugin"
                                        icon="ti ti-trash"
                                        data-plugin="{{ $plugin->path }}"
                                        :data-url="route('plugins.remove', ['plugin' => $plugin->path])"
                                    >
                                        {{ trans('packages/plugin-management::plugin.remove') }}
                                    </x-core::button>
                                @endif
                            </div>
                        </x-core::card.footer>
                    </x-core::card>
                </div>
            @endforeach
        </div>
    @endif

    <x-core::empty-state
        :title="trans('No plugins found')"
        :subtitle="trans('It looks as there are no plugins here.')"
        icon="ti ti-puzzle"
        @style(['display: none' => $plugins->isNotEmpty()])
    />
@stop

@push('footer')
    <x-core::modal.action
        id="remove-plugin-modal"
        type="danger"
        :title="trans('packages/plugin-management::plugin.remove_plugin')"
        :description="trans('packages/plugin-management::plugin.remove_plugin_confirm_message')"
        :submit-button-attrs="['id' => 'confirm-remove-plugin-button']"
        :submit-button-label="trans('packages/plugin-management::plugin.remove_plugin_confirm_yes')"
    />

    @if ($isEnabledMarketplaceFeature)
        <x-core::modal
            id="confirm-install-plugin-modal"
            :title="trans('packages/plugin-management::plugin.install_plugin')"
            button-id="confirm-install-plugin-button"
            :button-label="trans('packages/plugin-management::plugin.install')"
        >
            <input
                type="hidden"
                name="plugin_name"
                value=""
            >
            <input
                type="hidden"
                name="ids"
                value=""
            >

            <p id="requirement-message"></p>
        </x-core::modal>
    @endif
@endpush
