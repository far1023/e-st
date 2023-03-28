@extends('back.layouts.main')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <button type="button" id="add" class="btn btn-sm btn-outline-primary float-sm-right">Tambah pengguna</button>
        </div>
        <div class="card-body">
          <div class="table-responsive py-3">
            <table class="table table-striped table-hover dttables" id="dt_user">
              <thead>
                <tr>
                  <th style="text-align: center;">#</th>
                  <th style="text-align: center;">Username</th>
                  <th style="text-align: center;">Nama</th>
                  <th style="text-align: center;">Level</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_pengguna" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title"></h5>
        </div>
        <form id="form_pengguna" name="form_pengguna">
          @csrf
          <div class="modal-body">
            <input type="hidden" class="d-none" name="id" id="id" value="">
            <div class="form-group">
              <label for="name">Nama Lengkap</label>
              <input type="text" class="form-control" id="name" name="name">
              <small class="text-danger err-msg" id="name_error"></small>
            </div>
            <div class="form-group">
              <label for="id_role">Level</label>
              <select class="form-control" name="id_role" id="id_role">
                <option value="-" disabled selected>--pilih</option>
                @foreach ($roles as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
              <small class="text-danger err-msg" id="name_error"></small>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username">
              <small class="text-danger err-msg" id="username_error"></small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password">
              <small class="text-danger err-msg" id="password_error"></small>
            </div>
            <div class="form-group">
              <label for="name">Ulangi Password</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
              <small class="text-danger err-msg" id="password_confirmation_error"></small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary px-4" id="btn-save">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
