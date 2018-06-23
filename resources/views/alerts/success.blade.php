<script src="{{ asset('js/jquery-3.1.1.min.js') }}" charset="utf-8"></script>
<script type="text/javascript">
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });
</script>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('success') }}
    </div>
@endif
