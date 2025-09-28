<?php
$config['menu'] = array(
    array(
        "name" => 'dashboard',
        'title' => azlang('Dashboard'),
        'icon' => 'tachometer-alt',
        'url' => 'home',
        'role' => array(
            array(
                'role_name' => 'role_table',
                'role_title' => 'Data'
            ),
        ),
        'submenu' => array(),
    ),
    array(
        "name" => "ruangan",
        "title" => "Ruangan",
        "icon" => "building",
        "url" => "ruangan",
        'role' => array(
            array(
                'role_name' => 'role_view_ruangan',
                'role_title' => 'Hanya lihat data'
            ),
        ),
    ),
    array(
        "name" => "komponen",
        "title" => "Komponen",
        "icon" => "tag",
        "url" => "komponen",
        'role' => array(
            array(
                'role_name' => 'role_view_komponen',
                'role_title' => 'Hanya lihat data'
            ),
        ),
    ),
    array(
        "name" => "layanan",
        "title" => "Layanan",
        "icon" => "user-cog",
        "url" => "layanan",
        'role' => array(
            array(
                'role_name' => 'role_view_layanan',
                'role_title' => 'Hanya lihat data'
            ),
        ),
    ),
    array(
        "name" => "responden",
        "title" => "Responden",
        "icon" => "users",
        "url" => "responden",
        'role' => array(
            // array(
            //     'role_name' => 'role_view_responden',
            //     'role_title' => 'Hanya lihat data'
            // ),
        ),
    ),
    array(
        "name" => "report",
        "title" => "Laporan",
        "url" => "report",
        "icon" => "file",
        "submenu" => array(),
        'role' => array(
            array(
                'role_name' => 'role_report_survei',
                'role_title' => 'Laporan Survei',
            ),
        ),
    ),
    array(
        "name" => "user",
        "title" => azlang("User"),
        "icon" => "user",
        "url" => "",
        "submenu" => array(
            array(
                "name" => "user_user",
                "title" => azlang("Tambah/Edit Pengguna"),
                "url" => "user",
                "submenu" => array()
            ),
            array(
                "name" => "user_user_role",
                "title" => azlang("Hak Akses"),
                "url" => "user_role",
                "submenu" => array()
            ),
        )
    ),
);
