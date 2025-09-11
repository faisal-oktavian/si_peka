<?php
defined('BASEPATH') OR exit('No direct script access allowed');   
    
    if(!function_exists('az_select_outlet')){
        function az_select_outlet($id = 'outlet', $class='', $attr='outlet') {
            $ci =& get_instance();
            $ci->load->library('encrypt');
            $azapp = $ci->load->library('AZApp');
            $select = $ci->azapp->add_select2();
            $select->set_id($id);
            $select->set_url('data/get_outlet');
            $select->set_placeholder('Pilih Outlet');
            if (strlen($class) > 0) {
                $select->add_class($class);
            }
            if (strlen($attr) > 0) {
                $select->add_attr('data-id', $ci->encrypt->encode($attr.'.idoutlet'));
                $select->add_attr('w', 'true');
            }
            
            return $select->render();
        }
    }

    if(!function_exists('az_select_outlet_all')){
        function az_select_outlet_all($id = 'outlet', $class='', $attr='outlet') {
            $ci =& get_instance();
            $ci->load->library('encrypt');
            $azapp = $ci->load->library('AZApp');
            $select = $ci->azapp->add_select2();
            $select->set_id($id);
            $select->set_url('data/get_outlet_all');
            $select->set_placeholder('Pilih Outlet');
            if (strlen($class) > 0) {
                $select->add_class($class);
            }
            if (strlen($attr) > 0) {
                $select->add_attr('data-id', $ci->encrypt->encode($attr.'.idoutlet'));
                $select->add_attr('w', 'true');
            }
            
            return $select->render();
        }
    }

    if (!function_exists('get_url_key')) {
        function az_get_url_key($table, $name, $idpost) {
            $ci =& get_instance();
            $url_key = url_title($name, '-', true);
             if (strlen($idpost) > 0) {
               $ci->db->where('id'.$table .' != '. $idpost);
            }
            $ci->db->where('url_key', $url_key);
            $ci->db->where('status', 1);
            $data = $ci->db->get($table);

            if ($data->num_rows() > 0) {
                $db_url_key = $data->row()->url_key;
                $x_url_key = explode('-', $db_url_key);
                $end_url_key = end($x_url_key);
                if (is_numeric($end_url_key)) {
                    $url_key = $url_key.'-'.($end_url_key + 1);
                }
                else {
                    $url_key = $url_key.'-1';
                }
            }
            return $url_key;
        }
    }

    if(!function_exists('az_select_nama_ruang')){
        function az_select_nama_ruang($id = 'ruangan', $class='', $attr='ruangan') {
            $ci =& get_instance();
            $ci->load->library('encrypt');
            $azapp = $ci->load->library('AZApp');
            $select = $ci->azapp->add_select2();
            $select->set_id($id);
            // $select->set_select_parent($parent);
            $select->set_url('data/get_room');
            $select->set_placeholder('Pilih Ruangan');
            if (strlen($class) > 0) {
                $select->add_class($class);
            }
            if (strlen($attr) > 0) {
                $select->add_attr('data-id', $ci->encrypt->encode($attr.'.idruangan'));
                $select->add_attr('w', 'true');
            }
            
            return $select->render();
        }
    }