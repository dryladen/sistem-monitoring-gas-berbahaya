@extends('layout.layout')
@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $title }}</a></li>
                </ol>
            </div>
        </div>
        <div class="container-fluid pt-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @foreach ($data_profile as $item)
                            <form action="/profile/updateProfile/{{ $item->id }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">{{ $title }}</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        <input type="text" value="{{ $item->name }}" class="form-control"
                                            name="name" placeholder="Nama Lengkap ..." required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" value="{{ $item->email }}" class="form-control"
                                                    name="email" placeholder="Email ..." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Password ..." required>
                                                <input type="text" value="{{ $item->role }}" class="form-control"
                                                    name="role" placeholder="Role ..." hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
