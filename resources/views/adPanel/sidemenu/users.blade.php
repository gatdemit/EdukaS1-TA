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
                <input name="search" id="search" type="text" class="form-control" placeholder="Cari User disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}" required>
                <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
            </div>
            <a class="mb-3" href="/adPanel/users" style="text-align: right;">Clear Search</a>
        </form>
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Verifikasi</th>
                    <th scope="col" style="text-align: center;">Block</th>
                </tr>
            </thead>
            <tbody>
                @if($search)
                    @foreach($users as $user)
                        @if(Str::contains(Str::upper($user->email), Str::upper($query)) || Str::contains(Str::upper($user->displayName), Str::upper($query)))
                            <tr>
                                <td style="font-weight: 500;">{{ $user->email }}</td>
                                <td style="font-weight: 500;">{{ $user->displayName }}</td>
                                <td style="font-weight: 500;">{{ $user->customClaims['role'] }}</td>
                                <td style="font-weight: 500;">{{ $user->emailVerified ? 'verified' : 'unverified' }}</td>
                                <td style="text-align: center;">
                                    @if(Session::get('email') != Str::replace('.', '', $user->email))
                                        <form action="/adPanel/users/del" method="POST">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="uid" id="uid" value="{{ $user->uid }}">
                                            <input type="hidden" name="email" id="email" value="{{ $user->email }}">
                                            <input type="hidden" name="role" id="role" value="{{ $user->customClaims['role'] }}">
                                            <button class="btn btn-{{ $user->disabled ? 'primary' : 'danger' }} rounded-pill" onclick="return confirm('Are you sure?')">{{ $user->disabled ? 'Unblock' : 'Block' }}</button>
                                        </form>
                                    @endif
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
                            <td style="font-weight: 500;">{{ $user->emailVerified ? 'verified' : 'unverified' }}</td>
                            <td style="text-align: center;">
                                @if(Session::get('email') != Str::replace('.', '', $user->email))
                                    <form action="/adPanel/users/del" method="POST">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="uid" id="uid" value="{{ $user->uid }}">
                                        <input type="hidden" name="email" id="email" value="{{ $user->email }}">
                                        <input type="hidden" name="role" id="role" value="{{ $user->customClaims['role'] }}">
                                        <button class="btn btn-{{ $user->disabled ? 'primary' : 'danger' }} rounded-pill" onclick="return confirm('Are you sure?')">{{ $user->disabled ? 'Unblock' : 'Block' }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
@endsection