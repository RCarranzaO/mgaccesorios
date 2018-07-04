
<script type="text/javascript">
    $("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#danger-alert").slideUp(500);
    });
</script>
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{$error}}
                </li>
            @endforeach
        </ul>
    </div>
@elseif (session('fail'))
  <div class="alert alert-danger alert-dismissible fade show" id="danger-alert" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      {{ session('fail') }}
  </div>
@endif
