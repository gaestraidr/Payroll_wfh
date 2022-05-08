<!DOCTYPE html>
<html>
  <head>
    <title>Sistem Payroll - @yield('title')</title>
    <!-- meta -->
    @include('layout.meta')

    <!-- css -->
    @include('layout.css')

    <!-- js -->
    @include('layout.js')

    @laravelPWA
  </head>

  <body>
   <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
      <!-- header -->
      @include('layout.header') <!-- nav -->

      <div class="app-main">
          <!-- sidebar -->
          @include('layout.sidebar')

          <div class="app-main__outer">
              <!-- content -->
              @include('layout.content') <!-- headerContent --><!-- mainContent -->

              <!-- footer -->
              @include('layout.footer')
          </div>
      </div>
   </div>

   <div class="modal-wrapper">
   </div>

   <script>
   $(document).ready(function() {
       $('#logout').click(function() {
          $.ajax({
              method: 'POST',
              url: '{{ route('logout') }}',
              data: '_token=' + $('meta[name="csrf-token"]').attr('content')
          }).done(function(data) {
              setTimeout(function() {
                  window.location.href = '{{ route('login') }}';
              }, 100);
          })
       });
   });
   </script>

   @yield('page-script')


  </body>
</html>
