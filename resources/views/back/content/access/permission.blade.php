@extends('back.layouts.main')

@section('content')
  <div class="toolbar py-5 py-lg-15" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
      <h3 class="text-white fw-bolder fs-2qx me-5">{{ $title }}</h3>
      <div class="d-flex align-items-center flex-wrap py-2">
        <a href="javascript:void(0)" class="btn btn-custom btn-color-white btn-active-primary my-2 me-2 me-lg-6" id="add" data-bs-toggle="modal" data-bs-target="#modalPermission">Add
          new permission</a>
      </div>
    </div>
  </div>
  <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl mb-5 pb-5">
    <div class="content flex-row-fluid" id="kt_content">
      <div class="card">
        <div class="card-body p-5">
          <div class="table-responsive">
            <table class="table align-middle table-row-bordered table-row-dashed gy-3 gs-6" id="dataPermission">
              <thead class="text-xs text-gray">
                <tr>
                  <th>#</th>
                  <th>Permission Name</th>
                  <th>Guard Name</th>
                  <th></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalPermission">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formPermission" class="form-horizontal">
          <div class="modal-body scroll-y mx-5 pt-0 pb-15">
            <div class="text-center my-10 mb-13">
              <h1 class="modal-title"></h1>
            </div>
            <div id="load" class="text-center"></div>
            @csrf
            <input type="hidden" name="id" id="id">
            <div class="mb-5">
              <label class="form-label mb-1" for="name">Permission Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="">
              <small id="name_error" class="text-danger err-msg"></small>
            </div>
            <button type="submit" class="btn btn-success fw-bolder w-100 mt-10" id="btn-save">Save permission</button>
          </div>
      </div>
      </form>
    </div>
  </div>
@endsection
