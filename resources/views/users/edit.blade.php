@extends('layouts.master')

@section('title', 'Edit User')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit User</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Level User</label>
                                <select required class="form-control select2" name="role" data-placeholder="Pilih Level User"
                                    style="width: 100%;">
                                    @foreach ($levels as $level)
                                        <option value="{{ $level }}"
                                            {{ old('role', $user->role) == $level ? 'selected' : '' }}>{{ $level }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nama User</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name', $user->name) }}" placeholder="Masukkan Nama User">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Email User</label>
                                <input required type="email" class="form-control" name="email"
                                    value="{{ old('email', $user->email) }}" placeholder="Masukkan Kode User">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                                    placeholder="Masukkan Password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm-password"
                                    value="{{ old('confirm-password') }}" placeholder="Konfirmasi Password">
                                @error('confirm-password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('users.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
