@extends('master')
@section('content')
    <!-- Form section -->
    <!-- start: page toolbar -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-secondary">Report</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Refund Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- start: page body -->
    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
        <div class="container-fluid">
            <div class="row g-3">


                <!-- Form Validation -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Refund Report</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="search_form">
                                @csrf




                                <div class="col-lg-5 col-md-5 col-sm-12">
                                    <div class="input-group" style="height: 53px;">
                                        <input class="form-control" type="text" id="daterange" name="daterange">
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>




                            </form>

                            <div id="showReport"></div>
                        </div>
                    </div>
                </div>
            </div> <!-- .row end -->

        </div>
    </div>
    <!-- end form section -->



    <script type="text/javascript">

        $("#search_form").submit(function(e) {
            e.preventDefault();
            Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Please Wait...',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,

                    })
            $(".error_msg").html('');
            var data = new FormData($('#search_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('report/get-refund-report') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('#showReport').html(data);

                }
            }).done(function() {
                $("#success_msg").html("Data Fetched Successfully");
                // window.location.href = "{{ url('get-client-ledger-report') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                        "</span>");
                });
            });
        });


    </script>
    <script>
        $(document).ready(function() {
        $(function(){
            $('#start_date, #end_date').change(function(){
               let start = new Date($('#start_date').val());
               let end = new Date($('#end_date').val());

                // To calculate the time difference of two dates
                let Difference_In_Time = end.getTime() - start.getTime();

                    // To calculate the no. of days between two dates
                let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                if(Difference_In_Days < 0){
                alert('End Date cannot be earlier than Start Date');
                let getValue= document.getElementById("end_date");
                if (getValue.value !="") {
                    getValue.value = "";
                }
               }
            });
         });


    })
    </script>

@endsection