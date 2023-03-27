<script src="{{ asset('template/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    $('body').on('click', '.hapus', function() {
      if (confirm("Hapus data ini?")) {
        $.ajax({
          type: "DELETE",
          url: "{{ url('data/kepemilikan-tanah') }}" + "/" + $(this).data("id"),
          dataType: "json",
          success: function(res) {
            if (res.ok) {
              iziToast.success({
                title: 'Done!',
                message: res.message,
                position: 'topCenter'
              });
              $("#dt_skt").DataTable().ajax.reload(null, false);
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

    $('#dt_skt').DataTable({
      aaSorting: [],
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: false,
      info: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: "{{ url('data/kepemilikan-tanah/dttable') }}",
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
        {
          data: 'ktp_pemilik',
          name: 'ktp_pemilik'
        },
        {
          data: 'nama_pemilik',
          name: 'nama_pemilik'
        },
        {
          data: 'ttl',
          name: 'ttl'
        },
        {
          data: 'wn_pemilik',
          name: 'wn_pemilik'
        },
        {
          data: 'alamat_pemilik',
          name: 'alamat_pemilik'
        },
        {
          data: 'aksi',
          name: 'aksi'
        },
      ]
    });
  });
</script>
