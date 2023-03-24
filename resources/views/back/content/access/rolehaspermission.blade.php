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
                  <th>Role Name</th>
                  <th>Has Permission</th>
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
        <form id="formHas" class="form-horizontal">
          <div class="modal-body scroll-y mx-5 pt-0 pb-15">
            <div class="text-center my-10 mb-13">
              <h1 class="modal-title">Grant Permissions to Role</h1>
            </div>
            <div id="load" class="text-center"></div>
            @csrf
            <input type="hidden" name="id" id="id" readonly>
            <div class="mb-5">
              <label class="form-label mb-1" for="name">Role Name</label>
              <input type="text" class="form-control bg-white" id="name" name="name" placeholder="" readonly>
              <small id="name_error" class="text-danger err-msg"></small>
            </div>
            <div class="mb-5">
              <label class="form-label mb-1" for="id_permission">Give Permission to</label>
              <select class="form-select" data-control="select2" data-allow-clear="true" multiple="multiple" name="id_permission[]" id="id_permission">
                @foreach ($permission as $item)
                  <option class="permissions" value="{{ $item->id }}">{{ $item->name }}</oprion>
                @endforeach
              </select>
              <small id="id_permission_error" class="text-danger err-msg"></small>
            </div>
            <button type="submit" class="btn btn-success fw-bolder w-100 mt-10" id="btn-save">Grant permissions</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
