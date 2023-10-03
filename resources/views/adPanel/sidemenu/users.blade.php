@extends('adPanel.layouts.main')

@section('container-header')
    <h1>Users</h1>
@endsection

@section('container')
    <div class="table-responsive col-lg-8">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->displayName }}</td>
                        <td>
                            <form action="/adPanel/users" method="POST">
                                @csrf
                                <input type="hidden" name="uid" id="uid" value="{{ $user->uid }}">
                                <input type="hidden" name="email" id="email" value="{{ $user->email }}">
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection