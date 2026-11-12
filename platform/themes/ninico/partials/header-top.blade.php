<div @class(['header-top', $class ?? 'space-bg'])>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 col-lg-12 col-md-12">
                @if(is_plugin_active('announcement') && ($announcements = \ArchiElite\Announcement\AnnouncementHelper::getAnnouncements()) && $announcements->isNotEmpty())
                    <div
                        class="ae-anno-announcement-wrapper"
                        style="
                            --background-color: {{ setting('announcement_background_color', theme_option('primary_color', '#000')) }};
                            --text-color: {{ setting('announcement_text_color', '#fff') }};
                            --font-size: {{ \ArchiElite\Announcement\AnnouncementHelper::getFontSize() }};
                        "
                        @if(setting('announcement_autoplay', true))
                            data-announcement-autoplay="{{ setting('announcement_autoplay', false) }}"
                        data-announcement-autoplay-delay="{{ setting('announcement_autoplay_delay', 5000) }}"
                        @endif
                    >
                        <div
                            class="ae-anno-announcement__items"
                            style="
                                justify-content: {{ \ArchiElite\Announcement\AnnouncementHelper::getTextAlignment() }};
                                @if (setting('announcement_text_alignment') === \ArchiElite\Announcement\Enums\TextAlignment::CENTER) text-align: center; @endif
                               max-width: {{ \ArchiElite\Announcement\AnnouncementHelper::getMaxWidth() }};
                            "
                        >
                            @if ($announcements->count() > 1)
                                @include('plugins/announcement::partials.controls')
                            @endif

                            @foreach($announcements as $announcement)
                                <div
                                    data-announcement-id="{{ $announcement->getKey() }}"
                                    style="display: none;"
                                    @class([
                                        'ae-anno-announcement',
                                        'ae-anno-announcement__bottom' => \ArchiElite\Announcement\AnnouncementHelper::isBottomPlacement(),
                                    ])
                                >
                                    <div class="ae-anno-announcement__content header-welcome-text">
                                        <div class="ae-anno-announcement__text">
                                            <span>{!! BaseHelper::clean($announcement->formatted_content) !!}</span>
                                        </div>

                                        @if ($announcement->has_action)
                                            <a
                                                class="ae-anno-announcement__button"
                                                href="{{ $announcement->action_url }}"
                                                @if ($announcement->action_open_new_tab) target="_blank" @endif
                                            >
                                                {!! BaseHelper::clean($announcement->action_label) !!}
                                                <i class="fal fa-long-arrow-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (setting('announcement_dismissible', false))
                            @include('plugins/announcement::partials.dismiss', [
                                'announcementIds' => $announcements->pluck('id')->toJson(),
                            ])
                        @endif
                    </div>
                @else
                    @if(theme_option('header_messages') && $headerMessages = json_decode(theme_option('header_messages'), true))
                        @php($message = collect($headerMessages[array_rand($headerMessages)])->pluck('value', 'key'))
                        @if ($message->get('message') && $message->get('link_text'))
                            <div class="header-welcome-text">
                                <span>{!! BaseHelper::clean($message->get('message')) !!}</span>
                                <a href="{{ $message->get('link') }}" class="ms-2">
                                    {!! BaseHelper::clean($message->get('link_text')) !!} <i class="fal fa-long-arrow-right"></i>
                                </a>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            <div class="col-xl-4 d-none d-xl-block">
                <div class="headertoplag d-flex align-items-center justify-content-end">
                    {!! Theme::partial('currency-switcher') !!}
                    {!! Theme::partial('language-switcher') !!}
                    @if ($socialLinks = Theme::getSocialLinks())
                        <div class="menu-top-social">
                            @foreach($socialLinks as $socialLink)
                                @continue(! $icon = $socialLink->getIconHtml())

                                <a {{ $socialLink->getAttributes() }}>
                                    {{ $icon }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
