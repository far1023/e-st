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
          url: "{{ url('data/ganti-rugi') }}" + "/" + $(this).data("id"),
          dataType: "json",
          success: function(res) {
            if (res.ok) {
              iziToast.success({
                title: 'Done!',
                message: res.message,
                position: 'topCenter'
              });
              $("#dt_spgr").DataTable().ajax.reload(null, false);
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

    $('#dt_spgr').DataTable({
      aaSorting: [],
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: false,
      info: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: "{{ url('data/ganti-rugi/dttable') }}",
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
        {
          data: 'no_reg',
          name: 'no_reg'
        },
        {
          data: 'ktp_pihak_pertama',
          name: 'ktp_pihak_pertama'
        },
        {
          data: 'nama_pihak_pertama',
          name: 'nama_pihak_pertama'
        },
        {
          data: 'ttl',
          name: 'ttl'
        },
        {
          data: 'wn_pihak_pertama',
          name: 'wn_pihak_pertama'
        },
        {
          data: 'alamat_pihak_pertama',
          name: 'alamat_pihak_pertama'
        },
        {
          data: 'aksi',
          name: 'aksi'
        },
      ]
    });
  });
</script>
