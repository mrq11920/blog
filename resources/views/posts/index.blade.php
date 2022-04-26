@extends('base')

@section('main')
<div class="row">
  <div class="col-sm-12">
    <h1 class="display-3">Posts</h1>
    <div class="col-md-12 bg-light text-right ">
      <a href="{{ route('admin.posts.create')}}" class="btn btn-primary mb-3">Add Post</a>
      <a href="{{route('admin.posts.index','state=public')}}" class="btn btn-primary mb-3">Public Posts</a>
      <a href="{{route('admin.posts.index','state=pending')}}" class="btn btn-primary mb-3">Pending Posts</a>
      <a href="{{route('admin.posts.index','state=cancel')}}" class="btn btn-primary mb-3">Cancel Posts</a>
    </div>
    </div>

    <!-- <div>
      <a 
    </div> -->

    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
    @endif

    @if(session()->get('failure'))
    <div class="alert alert-danger">
      {{session()->get('failure') }}
    </div>
    @endif


    <div id="table_data">
      @include('posts.pagination')
    </div>
    <script>
      $(document).ready(function() {

        $(document).on('click', '.pagination a', function(event) {
          event.preventDefault();
          var page = $(this).attr('href').split('page=')[1];
          var state_name = document.getElementsByClassName('state-name')[0].innerText;
          fetch_data(page,state_name);
        });

        function fetch_data(page,state_name) {
          $.ajax({
            url: "posts/pagination?page=" + page + '&state='+state_name,
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