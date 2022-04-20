@extends('base')

@section('main')
<div class="row">
  <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">Add Post</h1>
    <div>
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div><br />
      @endif

      <!-- <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          {{ Config::get('languages')[App::getLocale()] }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          @foreach (Config::get('languages') as $lang => $language)
          @if ($lang != App::getLocale())
          <li><a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{$language}}</a></li>
          @endif
          @endforeach
        </ul>
      </div> -->

      <form method="post" action="{{ route('posts.store') }}">
        @csrf
        <div class="form-group">
          <label for="title">Title:*</label>
          <input type="text" class="form-control" name="title" />
        </div>

        <div class="form-group">
          <label for="content">Content:*</label>
          <!-- <input type="textarea" -->
          <textarea class="form-control" id="content-ckeditor" name="content"></textarea>
        </div>

        <!-- <div class="form-group">
          <label for="is_published">Publish:</label>
          <select id="is_published" name="is_published">
            <option value="0">False</option>
            <option value="1">True</option>
          </select>
        </div> -->
        <button type="submit" class="btn btn-primary">Add Post</button>
      </form>
    </div>
  </div>
</div>
@endsection