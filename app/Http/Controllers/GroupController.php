<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupConversation;
use App\Models\GroupUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $groups = Group::where('homecounty', Auth::user()->hometown)->get();
        $groups = Group::all();
        return view('group.index')->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'homecounty' => 'required',
            'groupName' => 'required',
            'groupUser' => 'required'
        ]);
        // create group
        $id =  Group::create([
            'groupName' => $request->groupName,
            'homecounty' => $request->homecounty,
        ]);
        // create groupusers
        foreach ($request->groupUser as $key => $groupUser) {
            GroupUsers::create([
                'group_id' => $id,
                'user_id' => $groupUser
            ]);
        }

        return redirect()->route('group.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $conversations =  GroupConversation::where('group_id', $group->id)->get();

        return view(
            'group.groupConversation',
            [
                'group' => $group,
                'groupConversations' => $conversations
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
}
