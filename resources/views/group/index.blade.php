@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                   <table class="table table-bordered table-striped">
                       <thead>
                           <th>Goup Name</th>
                           <th>Home county</th>
                       </thead>
                       <tbody>
                           @if (count($groups)>0)
                                @foreach ($groups as $group)
                                    <tr>
                                        <td><a href="/group/{{$group->id}}">{{$group->groupname}}</a> </td>
                                        <td>{{$group->homecounty}}</td>
                                    </tr>
                                @endforeach
                           @endif
                       </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
