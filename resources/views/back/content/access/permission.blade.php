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
        <div class="card-body table-responsive px-0 py-4">
          <div class="mx-3">
            <button type="button" id="add" class="btn btn-sm btn-outline-primary float-sm-right">Add Permission</button>
          </div>
          <table class="table table-striped table-hover dttables" id="dataPermission">
            <thead class="text-xs text-gray">
              <tr>
                <th>#</th>
                <th>Permission Name</th>
                <th>Guard Name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalPermission" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <form id="formPermission" name="formPermission">
          @csrf
          <div class="modal-body">
            <input type="hidden" class="d-none" name="id" id="id" value="">
            <div class="form-group">
              <label for="name">Permission Name</label>
              <input type="text" class="form-control" id="name" name="name">
              <small class="text-danger err-msg" id="name_error"></small>
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
