@extends('adPanel.layouts.main')

@section('container')
        @if(session()->has('success'))
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form class="row" action="/adPanel/users" method="post">
            @csrf
            <div class="input-group mb-3 w-50 ms-auto">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                <input name="search" id="search" type="text" class="form-control" placeholder="Cari User disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}">
                <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
            </div>
            <a class="mb-3" href="/adPanel/users" style="text-align: right;">Clear Search</a>
        </form>
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr style="text-align: center;">
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($search)
                    @foreach($users as $user)
                        @if(Str::contains($user->email, $query) || Str::contains($user->displayName, $query))
                            <tr>
                                <td style="font-weight: 500;">{{ $user->email }}</td>
                                <td style="font-weight: 500;">{{ $user->displayName }}</td>
                                <td style="font-weight: 500;">{{ $user->customClaims['role'] }}</td>
                                <td>
                                    <form action="/adPanel/users/del" method="POST">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="uid" id="uid" value="{{ $user->uid }}">
                                        <input type="hidden" name="email" id="email" value="{{ $user->email }}">
                                        <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    @foreach($users as $user)
                        <tr>
                            <td style="font-weight: 500;">{{ $user->email }}</td>
                            <td style="font-weight: 500;">{{ $user->displayName }}</td>
                            <td style="font-weight: 500;">{{ $user->customClaims['role'] }}</td>
                            <td>
                                <form action="/adPanel/users/del" method="POST">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="uid" id="uid" value="{{ $user->uid }}">
                                    <input type="hidden" name="email" id="email" value="{{ $user->email }}">
                                    <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
@endsection