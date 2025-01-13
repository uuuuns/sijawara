@extends('template_guest.profile.profile_template')
@section('content')
<style>
    .form-select {
        border: 2px solid #F5F5F5;
        height: 55px;
        padding-left: 20px;
        background-color: #F5F5F5;
    }
</style>
<div class="col ms-0 ms-md-4 px-5 py-5 shadow rounded-3 overflow-hidden bg-white">
    <img src="{{ asset('assets') }}/images/UnderDev.png" alt="">
</div>

<script>
    $(function() {
        $(".number").on("keypress keyup blur", function(event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    });
    const edit = document.querySelector(".edit");
    edit.addEventListener('click', function() {
        $('#academic-form').submit()
    })
</script>
@endsection