@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6 h5  text-uppercase">{{ __('Home Group :') }}</div>
                        <div class="fom-group col-sm-6">
                            <select name="homecounty" id="homecounty" class="form-control">
                                <option value="" selected disabled>Select Home County</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="usersTable-container">
                        <table class="table table-bordered table-striped" id="usersTable">
                            <thead>
                                <th>Name</th>
                                <th>Registration Number</th>
                                <th>Date Joined</th>
                            </thead>
                            <tbody id="userData">
                            </tbody>
                            <tfoot>
                                <th>Name</th>
                                <th>Registration Number</th>
                                <th>Date Joined</th>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" ></script>
<script>
    $(document).ready(function(){
        // initialize datatables
        // $('#usersTable').DataTable();
        // hide users table on load
        $('.usersTable-container').hide();

        $.ajax({
            url:'/counties',
            type:'get',
            dataType:'json',
            success: function(data){


                $.each(data, function(key, value){
                  $('#homecounty').append('<option value='+value.name+'>'+value.name+'</option>')
                });
                // console.log(JSON.stringify(data))
            },
            error: function(err){
                console.log(err)
            }
        });
        // on change search for users
        $('#homecounty').on('change', function(){
            // hide if it was initially open
            $('.usersTable-container').hide(800);
            // search for users in this county
            $.ajax({
                url:'/users/'+$(this).val(),
                type:'get',
                dataType:'json',
                success: function(data){
                    // console.log(data)
                    if (data.length == 0) {
                    alert('No user data for selected county')
                }else{
                    // show the table

                     $('.usersTable-container').show(1000);
                // append the user rows
                $.each(data, function(key, value){
                    $('#userData').html(
                        '<tr><td>'+value.username+'</td><td>'+value.regnumber+'</td><td>'+(new Date(value.created_at)).toDateString()+'</td></tr>'
                    );
                })
                }

                }
            })
        })
    })
</script>
@endsection
