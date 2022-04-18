@extends('base')
@section('main')
<h1 class="display-3">{{ $post->title }}</h1>
<div class="container">{!!$post->content!!}</div>
@endsection