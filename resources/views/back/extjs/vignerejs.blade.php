<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    $('.vignere').click(function() {
      $('.vignere').attr('disabled', true);
      $('.err-msg').html('');
      $(this).html('<span class="spinner-border spinner-border-sm"></span>');
      let id = this.id;
      let method = $(this).data('method');
      $.ajax({
        type: "POST",
        url: "{{ url('/tes-vignere/cipher') }}",
        data: {
          text: $('#text').val(),
          key: $('#key').val(),
          method: method
        },
        dataType: "json",
        success: function(res) {
          if (res.ok) {
            $('#result').html(res.data.cipher);
          } else {
            iziToast.error({
              title: 'Error!',
              message: "somthing wnet wrong",
              position: 'topCenter'
            });
          }
          $('.vignere').attr('disabled', false);
          $('#' + id).html(method);
        },
        error: function(res) {
          iziToast.error({
            title: 'Error!',
            message: res.responseJSON.message,
            position: 'topCenter'
          });

          (res.responseJSON.error.text) ? $('#text_error').html(res.responseJSON.error.text[0]): $('#text_error').html('');
          (res.responseJSON.error.key) ? $('#key_error').html(res.responseJSON.error.key[0]): $('#key_error').html('');

          $('.vignere').attr('disabled', false);
          $('#' + id).html(method);
        }
      });
    })
  });
</script>
