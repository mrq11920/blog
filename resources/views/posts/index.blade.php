@extends('base')

@section('main')
<div class="row">
  <div class="col-sm-12">
    <h1 class="display-3">Posts</h1>
    <div>
      <a href="{{ route('posts.create')}}" class="btn btn-primary mb-3">Add Post</a>
    </div>

    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
    @endif

    <div class="dropdown">
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
    </div>
    <div id="table_data">
      @include('posts.pagination')
    </div>
    <script>
      $(document).ready(function() {

        $(document).on('click', '.pagination a', function(event) {
          event.preventDefault();
          var page = $(this).attr('href').split('page=')[1];
          fetch_data(page);
        });

        function fetch_data(page) {
          $.ajax({
            url: "/posts/pagination?page=" + page,
            success: function(data) {
              $('#table_data').html(data);
            }
          });
        }

      });
    </script>

  </div>
</div>

@endsection