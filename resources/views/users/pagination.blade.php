<table class="table table-striped">
    <thead>
        <tr>
            <td>ID</td>
            <td>Email</td>
            <td>State</td>
            <td>Updated at</td>
            <td colspan=2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->email}} </td>
            <td class='state-name'>{{ config('user.'.$user->state)}}</td>
            <td>{{$user->updated_at}}</td>
            @if(auth()->user()->type == config('user.admin') && $user->state != config('user.approved'))
            <td>
                <form action="{{ route('users.update',$user->id) }}" method='post'>
                    @method('PATCH')
                    @csrf
                    <input name="state" type="hidden" value="approved">
                    <button class="btn btn-success" type="submit">Approve</button>
                </form>
            </td>
            @endif
            @if($user->state != config('user.cancelled'))
            <td>
                <form action="{{ route('users.destroy', $user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {!! $users->links() !!}
</div>