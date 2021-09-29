<?php

namespace App\Controllers;

use App\Models\HargaModel;

class App extends BaseController
{
    public $HargaModel;
    public function __construct()
    {
        $this->HargaModel = new HargaModel();
    }
    public function index()
    {
        return "welcome!";
    }

    public function All(){
        $data['all'] = $this->HargaModel->findAll();
        return view('all', $data);
        // print_r($query);
        // foreach ($query as $row) {
        //     return view($row);
        // }
    }

    public function Insert()
    {
        $name = $this->request->getPostGet('name');
        $price = $this->request->getPostGet('price');
        // echo $name.$price;
        if ($name and $price) {
            $save = $this->HargaModel->insert([
                'id'          => NULL,
                'name'        => strtolower($name),
                'price'       => str_replace('.','', $price),
                'last_update' => 'DATE()',
            ]);
            if ($save) {
                echo "Success Inserted!";
            }else{
                echo "Failed to insert";
            }
        }
        return view('insert');
    }
    public function bulk_insert()
    {
        $data['list'] = [];
        $nama_barang = $this->request->getPostGet('nama');
        $harga = $this->request->getPostGet('harga');
        if ($harga and $nama_barang) {
            foreach ($nama_barang as $number => $barang) {
                // echo "$barang : {$harga[$number]}<br>";
                $cek = $this->HargaModel->like('name', $barang)->get()->getResult();
                if ($cek) {
                    $data['list'][] = "produk {$barang} sudah ada di database\n";
                }else{
                    $save = $this->HargaModel->save([
                        'id'          => NULL,
                        'name'        => strtolower($barang),
                        'price'       => str_replace('.','', $harga[$number]),
                        'last_update' => 'DATE()',
                    ]);
                    if ($save) {
                        $data['list'][] = "{$barang} Success Inserted!\n";
                    }else{
                        $data['list'][] = "{$barang} Failed to insert\n";
                    }
                }
            }
        }
        if ($data['list']) {
            $data['list'] = implode('<br>', $data['list']); 
        } 
        // echo implode('<br>', $data['list']);
        // print_r($data['list']);
        return view('bulk_insert', $data);
    }
    public function Search()
    {
        $q =  $this->request->getPostGet('q');
        if (isset($q)) {
            $this->response->setContentType('text/plain');
            $db      = \Config\Database::connect();
            $builder = $db->table('list_harga');   

            $query = $builder->like('name', $q)
                        // ->select('id, name')
                        ->get();
            $data = $query->getResult();
        }else{
            $data = [];
        }
        echo json_encode($data);
    }
    public function edit()
    {
        // update
        $id = $this->request->getPostGet('id');
        $nama_barang = $this->request->getPostGet('nama');
        $harga = $this->request->getPostGet('harga');
        if ($harga and $nama_barang) {
            foreach ($nama_barang as $number => $barang) {
                $save = $this->HargaModel->save([
                    'id'          => $id[$number],
                    'name'        => strtolower($barang),
                    'price'       => str_replace('.','', $harga[$number]),
                    'last_update' => 'DATE()',
                ]);
                if ($save) {
                    echo 1;
                    $ret['update'][] = "{$barang} Success update!\n";
                }else{
                    echo 2;
                    $ret['update'][] = "{$barang} Failed to update\n";
                }
            }
        }

        //search
        $q =  $this->request->getPostGet('q');
        $db      = \Config\Database::connect();
        $builder = $db->table('list_harga');   

        $query = $builder->like('name', $q??'')
                    // ->select('id, name')
                    ->get();
        $data = $query->getResult();
        $ret['data'] = $data;

        //return
        return view('edit', $ret);
    }
    public function remove_product()
    {
        // update
        $ids = $this->request->getPostGet('id');
        if ($ids) {
            foreach ($ids as $id) {
                $del = $this->HargaModel->delete([
                    'id' => $id
                ]);
                if ($del) {
                    echo 1;
                    $ret['del_product'][] = "ID: {$id} Success deleted!\n";
                }else{
                    echo 2;
                    $ret['del_product'][] = "ID: {$id} Failed to deleted\n";
                }
            }
        }
        
        //search
        $q =  $this->request->getPostGet('q');
        $db      = \Config\Database::connect();
        $builder = $db->table('list_harga');   

        $query = $builder->like('name', $q??'')
                    // ->select('id, name')
                    ->get();
        $data = $query->getResult();
        $ret['data'] = $data;

        //return
        return view('remove_product', $ret);
    }
    public function Home()
    {
        return view('home');
    }
}
