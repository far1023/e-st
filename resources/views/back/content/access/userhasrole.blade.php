@extends('back.layouts.main')

@section('content')
  <div class="toolbar py-5 py-lg-15" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
      <h3 class="text-white fw-bolder fs-2qx me-5">{{ $title }}</h3>
    </div>
  </div>
  <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl mb-5 pb-5">
    <div class="content flex-row-fluid" id="kt_content">
      <div class="card">
        <div class="card-body p-5">
          <div class="table-responsive">
            <table class="table table-row-bordered table-row-dashed gy-3 gs-6" id="dataHas">
              <thead class="text-xs text-gray">
                <tr>
                  <th>#</th>
                  <th>User Name</th>
                  <th>Has Roles</th>
                  <th></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalHas">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Grant Roles to User</h5>
        </div>
        <form id="formHas" class="form-horizontal">
          <div class="modal-body">
            <div id="load" class="text-center"></div>
            @csrf
            <input type="hidden" name="id" id="id" readonly>
            <div class="mb-5">
              <label class="form-label mb-1" for="name">User Name</label>
              <input type="text" class="form-control bg-white" id="name" name="name" placeholder="" readonly>
              <small id="name_error" class="text-danger err-msg"></small>
            </div>
            <div class="mb-5">
              <label class="form-label mb-1" for="id_role">Give Roles</label>
              <div class="select2-primary">
                <select class="form-control select2bs4" multiple="multiple" data-placeholder="-- pilih" data-dropdown-css-class="select2-primary" name="id_role[]" id="id_role">
                  @foreach ($role as $item)
                    <option class="roles" value="{{ $item->id }}">{{ $item->name }}</oprion>
                  @endforeach
                </select>
              </div>
              <small id="id_role_error" class="text-danger err-msg"></small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-tutup btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success btn-sm px-10" id="btn-save">Simpan</button>
          </div>
      </div>
      </form>
    </div>
  </div>
@endsection
