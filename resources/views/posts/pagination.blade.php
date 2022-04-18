<table class="table table-striped">
    <thead>
        <tr>
            <td>ID</td>
            <td>Title</td>
            <td>Content</td>
            <td>Publish</td>
            <td>Updated at</td>
            <td colspan=2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <td>{{$post->id}}</td>
            <td>{{$post->title}} </td>
            <td>{{$post->content}}</td>
            <td>{{$post->is_published}}</td>
            <td>{{$post->updated_at}}</td>
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