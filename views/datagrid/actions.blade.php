

@if (in_array("show", $actions))
    <a class="row-action action-show btn btn-primary btn-xs" title="@lang('rapyd::rapyd.show')" href="{!! $uri !!}?show={!! $id !!}"><span class="glyphicon glyphicon-eye-open"> </span> Смотреть</a>
@endif
@if (in_array("modify", $actions))
    <a class="row-action action-modify btn btn-primary btn-xs" title="@lang('rapyd::rapyd.modify')" href="{!! $uri !!}?modify={!! $id !!}"><span class="glyphicon glyphicon-edit"> </span> Редактировать</a>
@endif
@if (in_array("delete", $actions))
    <a class="row-action action-delete text-danger btn btn-danger btn-xs" title="@lang('rapyd::rapyd.delete')" href="{!! $uri !!}?delete={!! $id !!}"><span class="glyphicon glyphicon-trash"> </span> Удалить</a>
@endif
