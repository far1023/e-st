<script src="{{ asset('js/print-this.js') }}"></script>
<script>
  $(document).ready(function() {
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
</script>
