<?php
/**
 * @var \Datlv\Menu\Menu $menu
 * @var array $params
 */
?>
@extends('kit::backend.layouts.modal')
@section('content')
    {!! Form::model($params,['class' => 'form-horizontal form-modal','url' => $url, 'method' => 'put']) !!}
    <div class="form-group">
        <label class="col-xs-3 control-label">{{ trans('menu::common.menu') }}</label>
        <div class="col-xs-9">
            <p class="form-control-static text-primary">{{ $menu->label }}</p>
        </div>
    </div>
    <div class="form-group {{ $errors->has("category_id") ? ' has-error':'' }}">
        {!! Form::label("category_id", $labels['category_id'], ['class' => "col-xs-3 control-label"]) !!}
        <div class="col-xs-9">
            {!! Form::select('category_id', $menu->typeInstance()->getCategories(), null, ['prompt' =>trans( 'category::common.select_category' ), 'class' => 'form-control selectize-tree']) !!}
            @if($errors->has('category_id'))
                <p class="help-block">{{ $errors->first('category_id') }}</p>
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has("route_show") ? ' has-error':'' }}">
        {!! Form::label("route_show", $labels['route_show'], ['class' => "col-xs-3 control-label"]) !!}
        <div class="col-xs-9">
            {!! Form::select(
                "route_show", $menu->typeInstance()->getRoutes(), null, ['prompt' => trans('category::menu.category.route_show_hint'), 'class' => 'form-control selectize'])
            !!}
            @if($errors->has('route_show'))
                <p class="help-block">{{ $errors->first('route_show') }}</p>
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@stop