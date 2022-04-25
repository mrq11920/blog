@extends('base')



@section('main')
<!-- 
<div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Dropdown button
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
      </div>
    </div> -->

<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Editing Post</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif
        <form method="post" action="{{ route('posts.update', $post) }}">
            @method('PATCH')
            @csrf
            <div class="form-group">

                <label for="title">Title:*</label>
                <input type="text" class="form-control" name="title" value="{{ $post->title }}" />
            </div>
            <div class="form-group">
                <label for="image">Add image:</label>
                <input type="file" class="form-control" name="image"/>
            </div>
            <div class="form-group">
                <label for="ticket">Content:*</label>
                <textarea class="form-control" id="content-ckeditor" name="content"></textarea>
                <input type="hidden" id='content-value' value="{{ $post->content }}">
                <!-- <input type="text" class="form-control" name="content" value="{{ $post->content }}" /> -->
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

@endsection