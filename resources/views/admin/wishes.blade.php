@extends('master')

@section('title', 'MyGrades - Wishes')

@section('content')
    <div class="container">
        <h1>Wishes</h1>


        <form action="{{ route('adminWishesUpdate') }}" method="post">
            <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
            <table class="striped">
                <thead>
                    <th>Wish ID</th>
                    <th>University Name</th>
                    <th>Name</th>
                    <th>Message</th>
                    <th>Email</th>
                    <th>App Version</th>
                    <th>Time</th>
                    <th>Written</th>
                    <th>Done</th>
                </thead>

                <tbody>
                @foreach ($openWishes as $wish)
                    <tr>
                        <td>{{ $wish->wish_id }}</td>
                        <td>{{ $wish->university_name }}</td>
                        <td>{{ $wish->name }}</td>
                        <td>{{ $wish->message }}</td>
                        <td>{{ $wish->email }}</td>
                        <td>{{ $wish->app_version }}</td>
                        <td>{{ $wish->created_at->format('d.m.Y H:i') }} Uhr</td>
                        <td>
                            <p style="text-align: center">
                                <input type="checkbox" id="written{{$wish->wish_id}}" {{ $wish->written ? 'checked="checked"' : ''}} name="written{{$wish->wish_id}}"  value="1" />
                                <label for="written{{$wish->wish_id}}"></label>
                            </p>
                        </td>
                        <td>
                            <p style="text-align: center">
                                <input type="checkbox" id="done{{$wish->wish_id}}" {{ $wish->done ? 'checked="checked"' : ''}} name="done{{$wish->wish_id}}" value="1" />
                                <label for="done{{$wish->wish_id}}"></label>
                            </p>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            <button style="margin-top: 30px" class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
        </form>


        <h2>Done</h2>
        <table class="striped">
            <thead>
            <th>Wish ID</th>
            <th>University Name</th>
            <th>Name</th>
            <th>Message</th>
            <th>Email</th>
            <th>App Version</th>
            <th>Time</th>
            </thead>

            <tbody>
            @foreach ($doneWishes as $wish)
                <tr>
                    <td>{{ $wish->wish_id }}</td>
                    <td>{{ $wish->university_name }}</td>
                    <td>{{ $wish->name }}</td>
                    <td>{{ $wish->message }}</td>
                    <td>{{ $wish->email }}</td>
                    <td>{{ $wish->app_version }}</td>
                    <td>{{ $wish->created_at->format('d.m.Y H:i') }} Uhr</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
@endsection