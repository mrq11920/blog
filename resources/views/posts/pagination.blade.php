<table class="table table-striped">
    <thead>
        <tr>
            <td>ID</td>
            <td>Title</td>
            <td>Image</td>
            <td>Content</td>
            <td>State</td>
            <td>Updated at</td>
            <td colspan=2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <td>{{$post->id}}</td>
            <td>{{$post->title}} </td>
            <td>{{asset('storage/uploads/image/'.$post->image)}}</td>
            <td>{!!$post->content!!}</td>
            <td>{{ config('post.'.$post->state)}}</td>
            <td>{{$post->updated_at}}</td>
            @if(auth()->user()->type == config('user.admin') && $post->state != config('post.public'))
            <td>
                <form action="{{ route('posts.approve') }}" method="post">
                    @csrf
                    <!-- @method('PATCH') -->
                    <!-- <div class="form-group">
                        <input type="text" class="form-control" name="id" value="{{$post->id}}" />
                    </div> -->
                    <input name="id" type="hidden" value="{{$post->id}}">
                    <button class="btn btn-success" type="submit">Approve</button>
                </form>
            </td>
            @endif
            <td>
                <a href="{{ route('posts.edit',$post)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <a href="{{ route('posts.show',$post) }}" class="btn btn-info">Show</a>
            </td>
            <td>
                <form action="{{ route('posts.destroy', $post)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {!! $posts->links() !!}
</div>