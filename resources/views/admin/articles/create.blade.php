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
                        <li class="breadcrumb-item active">Create</li>
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
                    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" id="regForm">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Articles</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="title" class="form-label">Title<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="title" id="title"
                                                        value="{{ old('title') }}"
                                                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Title">
                                                    @if ($errors->has('title'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('title') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="description" class="form-label">Description<span
                                                            class="text-danger">*</span></label>
                                                    <textarea  name="description" id="description"
                                                        value="{{ old('description') }}"
                                                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Description" ></textarea>
                                                    @if ($errors->has('description'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('description') }}
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="category" class="form-label">Category<span
                                                            class="text-danger">*</span></label>
                                                    <input type="category" name="category" id="category"
                                                        value="{{ old('category') }}"
                                                        class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Category">
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
                            <button class="btn form_button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
