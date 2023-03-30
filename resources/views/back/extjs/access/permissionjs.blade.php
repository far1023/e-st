<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    $('body').on('click', '#add', function() {
      $('.modal-title').html('Add New Permission');
      $('.err-msg').html('');
      $('.form-control').removeClass('is-invalid');
      $('#id').val('');
      $('#formPermission').trigger('reset');
      $('#modalPermission').modal('show');
    });

    $('body').on('click', '.edit', function() {
      $('.modal-title').html('Edit Permission');
      $('.err-msg').html('');
      $('.form-control').removeClass('is-invalid');
      $('#formPermission').trigger('reset');
      $('#id').val($(this).data('id'));
      $('#name').val($(this).data('name'));
      $('#modalPermission').modal('show');
    });

    $('#dataPermission').DataTable({
      aaSorting: [],
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: false,
      info: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: "{{ url('/controls/permissions/dttable') }}",
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'guard_name',
          name: 'guard_name'
        },
        {
          data: 'aksi',
          name: 'aksi'
        },
      ],
    });

    $('body').on('click', '.hapus', function() {
      if (confirm("Hapus data ini?")) {
        $.ajax({
          type: "DELETE",
          url: "{{ url('controls/permissions') }}" + "/" + $(this).data("id"),
          dataType: "json",
          success: function(res) {
            if (res.ok) {
              iziToast.success({
                title: 'Done!',
                message: res.message,
                position: 'topCenter'
              });
              $("#dataPermission").DataTable().ajax.reload(null, false);
            } else {
              iziToast.error({
                title: 'Error!',
                message: "somthing wnet wrong",
                position: 'topCenter'
              });
            }
          },
          error: function(res) {
            iziToast.error({
              title: 'Error!',
              message: res.responseJSON.message,
              position: 'topCenter'
            });
          }
        });
      }
    });

    $('#formPermission').submit(function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      var signed_url = "{{ url('/controls/permissions') }}";

      if ($('#id').val()) {
        formData.append('_method', 'PUT');
        signed_url = "{{ url('controls/permissions') }}" + "/" + $('#id').val();
      }

      $.ajax({
        type: "POST",
        url: signed_url,
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
          console.log(res.ok);
          if (res.ok) {
            iziToast.success({
              title: 'Stored!',
              message: res.message,
              position: 'topCenter'
            });

            $("#dataPermission").DataTable().ajax.reload(null, false);
            $('#modalPermission').modal('hide');
            $('.modal-title').html('');
            $('#formPermission').trigger('reset');
          } else {
            iziToast.error({
              title: 'Error!',
              message: "somthing wnet wrong",
              position: 'topCenter'
            });
          }

          $('#btn-save').attr('disabled', false).html('Simpan');
        },
        error: function(res) {
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
  });
</script>
