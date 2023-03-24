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
    $('body').on('click', '.edit', function() {
      $('#id_permission').val(null).trigger('change');
      $('.err-msg').html('');
      $('.form-control').removeClass('is-invalid');
      $('#formHas').trigger('reset');
      $('#id').val($(this).data('id'));
      $.ajax({
        type: "POST",
        url: "{{ url('/control/role-has-permission/edit') }}",
        data: {
          id: $(this).data("id"),
        },
        dataType: "json",
        beforeSend: function() {
          $('#modalHas').modal('show');
          $('#load').html('<div class="mb-3"><span class="spinner-border spinner-border-sm"></span>&nbsp;<small>Memuat data</small></div>');
        },
        success: function(res) {
          if (res.status == 'ok') {
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
            message: 'Terjadi kesalahan',
            position: 'topCenter'
          });
        }
      });
    });

    $('#dataHas').DataTable({
      aaSorting: [],
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: false,
      info: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: "{{ url('/control/role-has-permission/dttable') }}",
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

    $('body').on('click', '.hapus', function() {
      if (confirm("Hapus data ini?")) {
        $.ajax({
          type: "POST",
          url: "{{ url('/control/role-has-permission/destroy') }}",
          data: {
            id: $(this).data("id"),
          },
          dataType: "json",
          success: function(res) {
            if (res.status == 'ok') {
              iziToast.success({
                title: 'Deleted!',
                message: 'Data berhasil dihapus',
                position: 'topCenter'
              });
              $("#dataHas").DataTable().ajax.reload(null, false);
            } else {
              iziToast.error({
                title: 'Error!',
                message: 'Terjadi kesalahan',
                position: 'topCenter'
              });
            }
          },
          error: function(res) {
            iziToast.error({
              title: 'Error!',
              message: 'Terjadi kesalahan',
              position: 'topCenter'
            });
          }
        });
      }
    });

    $('#formHas').submit(function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      $.ajax({
        type: "post",
        url: "{{ url('/control/role-has-permission/store') }}",
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
          if (res.status == false) {
            iziToast.error({
              title: 'Error!',
              message: 'Cek kembali formulir',
              position: 'topCenter'
            });
            $.each(res.error, function(i, val) {
              $("#" + i + "_error").html(val);
              $("#" + i).addClass("is-invalid");
            });
          } else {
            iziToast.success({
              title: 'Stored!',
              message: res.msg,
              position: 'topCenter'
            });
            $("#dataHas").DataTable().ajax.reload(null, false);
            $(this).trigger('reset');
            $('#modalHas').modal('hide');
            $('.err-msg').html('');
          }
          $('#btn-save').attr('disabled', false).html('Simpan');
        },
        error: function(data) {
          $('#btn-save').attr('disabled', false).html('Simpan');
          iziToast.error({
            title: 'Error!',
            message: 'Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.',
            position: 'topCenter'
          });
        }
      });
    });
  });
</script>
