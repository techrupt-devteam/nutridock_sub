<!-- @if(Session::has('error'))
  <div class="alert alert-danger alert_msg alert1">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ Session::get('error') }}
  </div>
@endif
@if(Session::has('success'))
  <div class="alert alert-success alert_msg alert1">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ Session::get('success') }}
  </div>
@endif -->
<script>
  @if(Session::has('success'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('success') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  toastr.error("{{ session('error') }}");
  @endif

  @if(Session::has('info'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  toastr.info("{{ session('info') }}");
  @endif

  @if(Session::has('warning'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  toastr.warning("{{ session('warning') }}");
  @endif
</script>