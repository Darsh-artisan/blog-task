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
        <h1>Articles</h1>
        <form method="GET" action="{{ route('articles.index') }}">
            <input type="text" name="search" placeholder="Search articles" value="{{ request()->query('search') }}">
            <button type="submit">Search</button>
        </form>
        <a href="{{ route('articles.create') }}">Create New Article</a>
        <ul>
            @foreach ($articles as $article)
                <li>
                    <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                    <a href="{{ route('articles.edit', $article->id) }}">Edit</a>
                </li>
            @endforeach
        </ul>


    </div>
</section>


@endsection


{{-- Custom Script --}}
@section('page-js')

@endsection
