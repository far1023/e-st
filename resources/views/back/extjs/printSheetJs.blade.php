<script src="{{ asset('js/print-this.js') }}"></script>
<script>
  var signedUrl = "{{ $data['signed_url'] }}";

  $(document).ready(function() {
    load(signedUrl);

    $('body').on('click', '.print', function() {
      $('#printMe').printThis({
        loadCSS: [
          "{{ asset('css/print.css') }}",
          "{{ asset('css/bs4/bootstrap.min.css') }}"
        ],
        pageTitle: "{{ $title }}",
        printDelay: 333,
      });
    });
  });

  function load(url) {
    $.ajax({
      type: "get",
      url: url,
      beforeSend: function() {
        $('#printMe').html('<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Memuat...</div>');
      },
      success: function(res) {
        $('#printMe').html(res);
      },
      error: function(err) {
        $('#printMe').html('<div class="text-center">Ooops... Somthing wnet wrong!?!?</div>');
      }
    });
  }
</script>
