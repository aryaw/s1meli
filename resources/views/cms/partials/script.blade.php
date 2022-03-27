    <script src="{{ asset('cms/dist/js/vendor.min.js') }}"></script>
    <script src="{{ asset('cms/dist/js/app.min.js') }}"></script>
    <script>
      var ADMIN_URL = '{!! url(config('app.cms.admin_prefix')) !!}';
      var SITE_URL = '{!! url("/") !!}';
      $(document).ready(function(){
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      });
    </script>
    @section('extrastyle')
    @section('script')
    @show
    