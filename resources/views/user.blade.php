@extends('layout.layout')
@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Data</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $title }}</a></li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center px-4 pt-4">
                                <h4 class="card-title">{{ $title }}</h4>
                                <button type="button" class="btn btn-primary btn-rounded ml-auto" data-toggle="modal"
                                    data-target="#modalCreate"><i class="fa fa-plus"></i> Tambah Data</button>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($data_user as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->role }}</td>
                                                <td>
                                                    <a href="#modalEdit{{ $row->id }}" data-toggle="modal"
                                                        class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>
                                                        Edit</a>
                                                    <a href="#modalHapus{{ $row->id }}" data-toggle="modal"
                                                        class="btn btn-xs btn-danger delete-box">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create User --}}
    <div class="modal fade " id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Data User</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="user/store" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama Lengkap ..."
                                required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email ..." required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password ..." required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="" hidden>-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="peternak">Peternak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i>
                            Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Update User --}}
    @foreach ($data_user as $userEdit)
        <div class="modal fade " id="modalEdit{{ $userEdit->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data User</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="user/update/{{ $userEdit->id }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" value="{{ $userEdit->name }}" class="form-control" name="name"
                                    placeholder="Nama Lengkap ..." required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" value="{{ $userEdit->email }}" class="form-control"
                                    name="email" placeholder="Email ..." required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password ..."
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" class="form-control" required>
                                    <option <?php if ($userEdit['role'] == "admin") echo "selected"; ?> value="admin">Admin</option>
                                    <option <?php if ($userEdit['role'] == "kasir") echo "selected"; ?> value="kasir">Kasir</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                    class="fa fa-undo"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- Hapus User --}}
    @foreach ($data_user as $userDelete)
        <div class="modal fade " id="modalHapus{{ $userDelete->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data User</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form action="user/delete/{{ $userDelete->id }}" method="get">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <h5>Apakah anda ingin menghapus data ini ?</h5>
                            </div>

                        </div>
                        <div class="modal-footer sweetalert">
                            <button type="button" class="btn btn-secondary " data-dismiss="modal"><i
                                    class="fa fa-undo"></i> Batal</button>
                            <button type="submit" class="btn btn-danger "><i class="fa fa-trash "></i> Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
