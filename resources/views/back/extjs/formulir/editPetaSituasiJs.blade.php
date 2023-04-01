<script src="{{ asset('template/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>

<script>
  var stepper = new Stepper($('.bs-stepper')[0]);

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function load() {
    $('#load').html('<span class="spinner-border spinner-border-sm"></span> sedang memuat...');
    $.ajax({
      type: "GET",
      url: "{{ url('data/peta-situasi-tanah') }}" + "/" + "{{ request()->route('id') }}",
      dataType: "json",
      success: function(res) {
        if (res.ok) {
          $.each(res.data, function(i, val) {
            $("#" + i).val(val);
          });
        } else {
          iziToast.error({
            title: 'Error!',
            message: "somthing wnet wrong",
            position: 'topCenter'
          });
        }
        $('#load').html('');
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
  }

  $(document).ready(function() {
    load();

    $('#formpetasituasi').submit(function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      $.ajax({
        type: "POST",
        url: "{{ url('formulir/peta-situasi-tanah') }}" + "/" + "{{ request()->route('id') }}" + "/update",
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
            $('.card-body').html(res.message + ' <a href="{{ url('formulir/peta-situasi-tanah') }}">Ajukan baru</a>');
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
