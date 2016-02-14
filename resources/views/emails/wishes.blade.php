@extends('emails.emailmaster')

@section('content')
    <h1>New wishes</h1>
    @foreach ($wishes as $wish)
        <div class="entry">
            <p>
                <strong>Wish ID:</strong> {{ $wish->wish_id }} <br>
                <strong>University Name:</strong> {{ $wish->university_name }}<br>
                @if (!empty($wish->name))
                <strong>Name:</strong> {{ $wish->name }}<br>
                @endif
                @if (!empty($wish->message))
                <strong>Message:</strong> {{ $wish->message }}<br>
                @endif
                @if (!empty($wish->email))
                <strong>Email:</strong> {{ $wish->email }}<br>
                @endif
                <strong>App version:</strong> {{ $wish->app_version }}<br>
                <strong>Time:</strong> {{ $wish->created_at->format('d.m.Y H:i') }} Uhr
            </p>
        </div>
    @endforeach
@endsection