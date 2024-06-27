@extends('admin.layouts.admin-layout')

@section('title', 'Articles')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Articles</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('articles.index') }}">Articles</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    {{-- New Category add Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Articles</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="title" class="form-label">Title<span class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{isset($article->title) ? $article->title : old('title')}}" id="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('title'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('title') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                                                    <textarea name="description"  id="description" class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}" placeholder="Enter Description">{{ isset($article->description) ? $article->description : old('description') }}</textarea>
                                                    @if ($errors->has('description'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('description') }}
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="category" class="form-label">Category</label>
                                                    <input type="category" name="category" id="category" value="{{isset($article->category) ? $article->category : old('description')}}" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('category'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('category') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn form_button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
