@extends('emails.emailmaster')

@section('content')
    <h1>New errors</h1>
    @foreach ($errors as $error)
        <div class="entry">
            <p>
                <strong>Error ID:</strong> {{ $error->error_id }} <br>
                <strong>University:</strong> {{ $error->university_id}}: {{ $error->university->name }}<br>
                @if (!empty($error->rule_id))
                    <strong>Rule ID:</strong> {{ $error->rule_id }}<br>
                @endif
                @if (!empty($error->name))
                    <strong>Name:</strong> {{ $error->name }}<br>
                @endif
                @if (!empty($error->message))
                    <strong>Message:</strong> {{ $error->message }}<br>
                @endif
                @if (!empty($error->email))
                    <strong>Email:</strong> {{ $error->email }}<br>
                @endif
                <strong>App version:</strong> {{ $error->app_version }}<br>
                @if (!empty($error->android_version))
                    <strong>Android version:</strong> {{ $error->android_version }}<br>
                @endif
                @if (!empty($error->device))
                    <strong>Gerät:</strong> {{ $error->device }}<br>
                @endif
                <strong>Time:</strong> {{ $error->created_at->format('d.m.Y H:i') }} Uhr
            </p>
        </div>
    @endforeach
@endsection