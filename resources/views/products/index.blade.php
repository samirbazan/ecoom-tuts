@extends('layouts.main')

@section('content')
    <div id="admin">
        <h1>Products Admin Panel</h1><hr>
        <p>Here you can view, delete, and create new Products.</p>
        <h2>Products</h2><hr>
        <ul>
            @foreach($products as $product)
                <li>
                    {!! Html::image($product->image, $product->title, array('width'=>'50')) !!}
                    {!! $product->title !!} -
                    {!! Form::open(array('url'=>'admin/products/destroy', 'class'=>'form-inline')) !!}
                    {!! Form::hidden('id', $product->id) !!}
                    {!! Form::submit('delete') !!}
                    {!! Form::close() !!} -

                    {!! Form::open(array('url'=>'admin/products/toggle-availability', 'class'=>'form-inline')) !!}
                    {!! Form::hidden('id', $product->id) !!}
                    {!! Form::select('availability', array('1'=>'In Stock', '0'=>'Out of Stock'), $product->availability) !!}
                    {!! Form::submit('Update') !!}
                    {!! Form::close() !!}
                </li>
            @endforeach
        </ul>

        <h2>Create a New Product</h2>

        @if($errors->has())
            <div id="form-errors">
                <p>The folowing errors have ocurred!:</p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::open(array('url'=>'admin/products/create', 'files'=>true)) !!}
        <p>
            {!! Form::label('category_id', 'Category') !!}
            {!! Form::select('category_id', $categories) !!}
        </p>
        <p>
            <!-- Title Form Input -->

        <div class="form-group">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Description:') !!}
            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('price', 'Price:') !!}
            {!! Form::text('price', null, ['class' => 'form-price']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('image', 'Choose an Image:') !!}
            {!! Form::file('image', null, ['class' => 'form-control']) !!}
        </div>

        </p>
        {!! Form::submit('Create Product', array('class'=>'secondary-cart-btn')) !!}
        {!! Form::close() !!}
    </div>


@stop