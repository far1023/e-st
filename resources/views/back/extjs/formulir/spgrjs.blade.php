<script src="{{ asset('template/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('js/terbilang.js') }}"></script>

<script>
  $('.datetimepicker-input').datetimepicker({
    format: "YYYY-MM-DD"
  });

  $('#besaran').inputmask();

  var stepper = new Stepper($('.bs-stepper')[0]);

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    $('#besaran').change(function() {
      let kalimatTerbilang = angkaTerbilang($(this).val().replace(/\./g, ''));
      $('#terbilang').val(kalimatTerbilang + " Rupiah");
    });

    $('#formspgr').submit(function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      $.ajax({
        type: "POST",
        url: "{{ url('/formulir/ganti-rugi') }}",
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
  })
</script>
