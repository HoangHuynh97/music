<?php
function loadHeader()
{
    $data['title'] = 'Max Music';
    return view('head/header', $data);
}

function loadFooter()
{
    $data['title'] = 'mm';
    return view('head/footer', $data);
}

function loadMenu()
{
    $data['title'] = 'mm';
    return view('head/menu', $data);
}

function loadTop()
{
    $session = session();
    if(isset($session->name)) {
        $data['username'] = $session->name;
        $data['userid'] = $session->id;
    }

    $data['title'] = 'mm';
    return view('head/top', $data);
}

function loadBot()
{
    $data['title'] = 'mm';
    return view('head/bot', $data);
}

function loadModalUpload()
{
    $data['title'] = 'mm';
    return view('upload/index', $data);
}