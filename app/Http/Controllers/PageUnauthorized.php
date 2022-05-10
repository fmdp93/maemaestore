<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageUnauthorized extends Controller
{
    public function admin(){
        $data['title'] = "Page Unauthorized";
        $data['heading'] = "Page Unauthorized";
        $data['user_content'] = 'admin_content';
        $data['components_user_content'] = 'components.admin.content';

        return view('pages.page-unauthorized', $data);
    }

    public function cashier(){
        $data['title'] = "Page Unauthorized";
        $data['heading'] = "Page Unauthorized";
        $data['user_content'] = 'admin_content';
        $data['components_user_content'] = 'components.admin.content';

        return view('pages.page-unauthorized', $data);
    }

}
