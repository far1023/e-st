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
    });

    $('body').on('click', '.edit', function() {
      $('.modal-title').html('Edit Permission');
      $('.err-msg').html('');
      $('.form-control').removeClass('is-invalid');
      $('#formPermission').trigger('reset');
      $('#id').val($(this).data('id'));
      $('#name').val($(this).data('name'));
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
      ajax: "{{ url('/control/permission/dttabledatapermission') }}",
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
          type: "POST",
          url: "{{ url('/control/permission/destroy') }}",
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
              $("#dataPermission").DataTable().ajax.reload(null, false);
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

    $('#formPermission').submit(function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      $.ajax({
        type: "post",
        url: "{{ url('/control/permission/store') }}",
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
            $("#dataPermission").DataTable().ajax.reload(null, false);
            $(this).trigger('reset');
            $('#modalPermission').modal('hide');
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
