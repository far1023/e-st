<script src="{{ asset('template/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/print-this.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    $('body').on('click', '.approve', function() {
      Swal.fire({
        title: "Setujui berkas Kepemilikan Tanah",
        text: "Tindakan ini tidak dapat dikembalikan!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28A745',
        cancelButtonColor: '#DC3545',
        confirmButtonText: 'Setujui berkas!',
        cancelButtonText: 'Batalkan'
      }).then((result) => {
        if (result['isConfirmed']) {
          $.ajax({
            type: "POST",
            url: "{{ url('data/kepemilikan-tanah/approve') }}" + "/" + $(this).data("id"),
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
      })
    });

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
          data: 'status',
          name: 'status'
        },
        {
          data: 'aksi',
          name: 'aksi'
        },
      ]
    });

    $('body').on('click', '.cetak', function() {
      let signedUrl = $(this).data('url');
      load(signedUrl);
    });
  });

  function load(url) {
    $.ajax({
      type: "get",
      url: url,
      success: function(res) {
        $('#myFrame').html(res).printThis({
          loadCSS: [
            "{{ asset('css/print.css') }}",
            "{{ asset('css/bs4/bootstrap.min.css') }}"
          ],
          pageTitle: "{{ $title }}",
          printDelay: 333,
        });
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
</script>
