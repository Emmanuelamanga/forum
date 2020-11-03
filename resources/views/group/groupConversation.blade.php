@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">GROUP MEMBERS</div>
                <div class="card-body" style="height: 380px;overflow-y: scroll;">
                    <table class="table table-bordered">
                        <thead>
                            <th>Name</th>
                        </thead>
                        <tbody>
                            @foreach ($groupConversations as $item)
                                <tr>
                                    <td>{{\Illuminate\Support\Facades\DB::table('users')->where('id', $item->author_id)->groupby('fname')->distinct()->value('fname')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-uppercase">{{$group->groupname}} {{ __('group conversation') }}</div>
                <div class="card-body" style="height: 380px;
                overflow-y: scroll;">
                    {{-- display cnversations --}}
                    @if (count($groupConversations)>0)

                    @foreach ($groupConversations as $item)
                    <p style="clear: both"
                        class="card p-1 @if($item->author_id == Auth::user()->id) float-right @endif">
                        {!! $item->userText !!}
                        <span
                            class="font-weight-bold font-italic">Author: {{\Illuminate\Support\Facades\DB::table('users')->where('id', $item->author_id)->value('fname')}}</span>
                    </p>
                    @endforeach
                    @else
                    <div class="text-info">No conversations yet</div>
                    @endif

                    <form action="" id="groupConversation" class="mb-0" style="">
                        <input type="hidden" name="groupid" value="{{$group->id}}">
                        <input type="hidden" name="authorid" value="{{Auth::user()->id}}">
                        <div class="form-group" style="clear: both">
                            <label for="userText">Write Post</label>
                            <textarea name="userText" id="userText" class="form-control"></textarea>
                        </div>
                        <button style="width: 80px" class="btn btn-outline-success text-center float-right btn-sm"
                            type="submit">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $('#groupConversation').on('submit', function(e){
            e.preventDefault();
            submit();
        });
        function submit(){
            $.ajax({
                "_token": "{{ csrf_token() }}",
                url:'{{route("groupConversation.store")}}',
                type:'POST',
                data: $('#groupConversation').serializeArray(),
                success: function(response){
                    location.reload();
                    console.log(response)
                },
                error: function(err){
                    console.log(err)
                }
            })
        }
    })
</script>
@endsection
