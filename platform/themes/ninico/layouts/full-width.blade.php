@extends(Theme::getThemeNamespace('layouts.base'))

@section('content')
    {!! Theme::partial('headers.index') !!}

    <main>
        {!! Theme::content() !!}
    </main>

    {!! Theme::partial('footer') !!}
@endsection
