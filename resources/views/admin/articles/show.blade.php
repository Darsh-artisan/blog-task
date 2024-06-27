@extends('admin.layouts.admin-layout')

@section('title', 'Articles')

@section('content')

<div class="pagetitle">
    <h1>Articles</h1>
    <div class="row">
        <div class="col-md-8">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Articles</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

 {{-- Category Section --}}
 <section class="section dashboard">
    <div class="container">

        <h1>{{ $article->title }}</h1>
        <p>{{ $article->description }}</p>
        <p>Category: {{ $article->category }}</p>
        <a href="{{ route('articles.index') }}">Back to Articles</a>
    </div>
</section>


@endsection


{{-- Custom Script --}}
@section('page-js')



@endsection
