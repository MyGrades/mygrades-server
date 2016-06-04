@extends('master')

@section('title', 'MyGrades - Errors')

@section('content')
    <div class="container">
        <h1>Errors</h1>


        <form action="{{ route('adminErrorsUpdate') }}" method="post">
            <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
            <table class="striped">
                <thead>
                    <th>Error ID</th>
                    <th>University</th>
                    <th>Rule ID</th>
                    <th>Name</th>
                    <th>Message</th>
                    <th>Email</th>
                    <th>App Version</th>
                    <th>Gerät</th>
                    <th>Android Version</th>
                    <th>Time</th>
                    <th>Written</th>
                    <th>Fixed</th>
                </thead>

                <tbody>
                @foreach ($openErrors as $error)
                    <tr>
                        <td>{{ $error->error_id }}</td>
                        <td>{{ $error->university_id }}: {{ $error->university->name }}</td>
                        <td>{{ $error->rule_id }}</td>
                        <td>{{ $error->name }}</td>
                        <td>{{ $error->message }}</td>
                        <td>{{ $error->email }}</td>
                        <td>{{ $error->app_version }}</td>
                        <td>{{ $error->device }}</td>
                        <td>{{ $error->android_version }}</td>
                        <td>{{ $error->created_at->format('d.m.Y H:i') }} Uhr</td>
                        <td>
                            <p style="text-align: center">
                                <input type="checkbox" id="written{{$error->error_id}}" {{ $error->written ? 'checked="checked"' : ''}} name="written{{$error->error_id}}"  value="1" />
                                <label for="written{{$error->error_id}}"></label>
                            </p>
                        </td>
                        <td>
                            <p style="text-align: center">
                                <input type="checkbox" id="fixed{{$error->error_id}}" {{ $error->fixed ? 'checked="checked"' : ''}} name="fixed{{$error->error_id}}" value="1" />
                                <label for="fixed{{$error->error_id}}"></label>
                            </p>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            <button style="margin-top: 30px" class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
        </form>


        <h2>Fixed</h2>
        <table class="striped">
            <thead>
                <th>Error ID</th>
                <th>University</th>
                <th>Name</th>
                <th>Message</th>
                <th>Email</th>
                <th>App Version</th>
                <th>Time</th>
            </thead>

            <tbody>
            @foreach ($fixedErrors as $error)
                <tr>
                    <td>{{ $error->error_id }}</td>
                    <td>{{ $error->university_id }}: {{ $error->university->name }}</td>
                    <td>{{ $error->name }}</td>
                    <td>{{ $error->message }}</td>
                    <td>{{ $error->email }}</td>
                    <td>{{ $error->app_version }}</td>
                    <td>{{ $error->created_at->format('d.m.Y H:i') }} Uhr</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
@endsection