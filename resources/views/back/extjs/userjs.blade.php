<script src="{{ asset('template/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    $('#add').click(function() {
      $('#modal_pengguna').modal('show');
      $('#modal_title').html('Tambah pengguna baru');
      $('#form_pengguna').trigger('reset');
      $('#id').val('');
      $('.err-msg').html('');
      $('.form-control').removeClass('is-invalid');
    });

    $('body').on('click', '.edit', function() {
      $.ajax({
        type: "GET",
        url: "{{ url('pengguna') }}" + "/" + $(this).data("id"),
        dataType: "json",
        success: function(res) {
          if (res.ok) {
            $('#modal_pengguna').modal('show');
            $('#modal_title').html('Perbaharui data pengguna');
            $('#form_pengguna').trigger('reset');

            $("#id").val(res.data.id);
            $("#name").val(res.data.name);
            $("#username").val(res.data.username);
            $('#id_role').val(res.data.roles[0].id);
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
    })

    $('#form_pengguna').submit(function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      var signed_url = "{{ url('/pengguna') }}";

      if ($('#id').val()) {
        formData.append('_method', 'PUT');
        signed_url = "{{ url('pengguna') }}" + "/" + $('#id').val();
      }

      console.log(signed_url);
      console.log(signed_url);

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

            $("#dt_user").DataTable().ajax.reload(null, false);
            $('#modal_pengguna').modal('hide');
            $('#modal_title').html('');
            $('#form_pengguna').trigger('reset');
          } else {
            iziToast.error({
              title: 'Error!',
              message: "somthing wnet wrong",
              position: 'topCenter'
            });
          }

          $('#btn-save').attr('disabled', false).html('Simpan data');
        },
        error: function(res) {
          $('#btn-save').attr('disabled', false).html('Simpan data');

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

    $('body').on('click', '.hapus', function() {
      if (confirm("Hapus data ini?")) {
        $.ajax({
          type: "DELETE",
          url: "{{ url('pengguna') }}" + "/" + $(this).data("id"),
          dataType: "json",
          success: function(res) {
            if (res.ok) {
              iziToast.success({
                title: 'Done!',
                message: res.message,
                position: 'topCenter'
              });
              $("#dt_user").DataTable().ajax.reload(null, false);
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

    $('#dt_user').DataTable({
      aaSorting: [],
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: false,
      info: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: "{{ url('pengguna/dttable') }}",
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
        {
          data: 'username',
          name: 'username'
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'level',
          name: 'level'
        },
        {
          data: 'aksi',
          name: 'aksi'
        },
      ]
    });
  });
</script>
