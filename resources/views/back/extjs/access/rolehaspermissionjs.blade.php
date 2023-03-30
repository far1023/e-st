<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('.select2').select2();

  $(document).ready(function() {
    $('body').on('click', '.edit', function() {
      $('#id_permission').val(null).trigger('change');
      $('.err-msg').html('');
      $('.form-control').removeClass('is-invalid');
      $('#formRoleHas').trigger('reset');
      $('#id').val($(this).data('id'));

      $.ajax({
        type: "GET",
        url: "{{ url('/controls/access-granting') }}" + "/" + $(this).data("id"),
        dataType: "json",
        beforeSend: function() {
          $('#modalRoleHas').modal('show');
          $('#load').html('<div class="mb-3"><span class="spinner-border spinner-border-sm"></span>&nbsp;<small>Memuat data</small></div>');
        },
        success: function(res) {
          if (res.ok) {
            console.log(res.data);
            $('#load').html('');
            $('#id').val(res.data.role.id);
            $('#name').val(res.data.role.name);

            for (i = 0; i < res.data.permission.length; i++) {
              $('.permissions').each(function() {
                if ($(this).val() == res.data.permission[i].id) {
                  $(this).prop('selected', true);
                }
              })
            };

            $('#id_permission').trigger('change');
          } else {
            $('#load').html(res.msg);
          }
        },
        error: function(res) {
          $('#load').html('');

          iziToast.error({
            title: 'Error!',
            message: res.responseJSON.message,
            position: 'topCenter'
          });
        }
      });
    });

    $('#formRoleHas').submit(function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      formData.append('_method', 'PUT');

      $.ajax({
        type: "post",
        url: "{{ url('controls/access-granting') }}" + "/" + $('#id').val(),
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.err-msg').html('');
          $('.form-control').removeClass('is-invalid');
          $('#btn-save').attr('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        },
        success: function(res) {
          if (res.ok) {
            iziToast.success({
              title: 'Stored!',
              message: res.message,
              position: 'topCenter'
            });

            $("#dataRoleHas").DataTable().ajax.reload(null, false);
            $('#modalRoleHas').modal('hide');
            $('.modal-title').html('');
            $('#formRoleHas').trigger('reset');
            $('#id').val('');
          } else {
            iziToast.error({
              title: 'Error!',
              message: "somthing wnet wrong",
              position: 'topCenter'
            });
          }

          $('#btn-save').attr('disabled', false).html('Simpan');
        },
        error: function(data) {
          $('#btn-save').attr('disabled', false).html('Simpan');

          iziToast.error({
            title: 'Error!',
            message: res.responseJSON.message,
            position: 'topCenter'
          });

          $.each(res.responseJSON.error, function(i, val) {
            $("#" + i + "_error").html(val);
            $("#" + i).addClass("is-invalid");
          });
        }
      });
    });

    $('#dataRoleHas').DataTable({
      aaSorting: [],
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: false,
      info: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: "{{ url('/controls/access-granting/dttable') }}",
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
        {
          data: 'role',
          name: 'role'
        },
        {
          data: 'has_permission',
          name: 'has_permission'
        },
        {
          data: 'aksi',
          name: 'aksi'
        },
      ],
    });
  });
</script>
