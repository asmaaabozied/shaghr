<?php

namespace App\Helpers;


class DTHelper
{

    public static function dtEditButton($link, $title, $permission)
    {

//        if (auth()->user()->hasPermission($permission)) {

        $html = <<< HTML
 <a href="$link" class="update btn btn-sm btn-soft-success btn-circle mr-2" ><i class="dripicons-pencil"></i> </a>
HTML;

        return $html;
    }



    public static function dtDeleteButton($link, $title, $permission, $id)
    {
        $csrf = csrf_field();
        $method_field = method_field('delete');
//        if (auth()->user()->hasPermission($permission)) {

        $html = <<< HTML
<form action="$link" method="post" style="display: inline-block" id="deleteForm$id">
$csrf
$method_field
<a type="button" onclick="confirmDelete($id)" id="delete" class=" delete btn btn-sm btn-soft-danger btn-circle"
   >
<i class="dripicons-trash""></i>
</a>
</form>
HTML;

        return $html;
//        }
    }


    public static function dtShowButton($link, $title, $permission)
    {

//        if (auth()->user()->hasPermission($permission)) {

        $html = <<< HTML
 <a href="$link" class="btn-table"> <i class="fa fa-eye"></i></a>
HTML;

        return $html;
    }
}
