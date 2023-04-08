<?php

namespace App\Controllers;

class Upload extends BaseController
{
    public function setData()
    {
        $db = db_connect();
        $builder = $db->table('tbl_song');

        $data = $this->request->getPost();
        $strToArrID = explode(" ", $data['idYTB']);
        $strToArrSong = explode("*", $data['nameSong']);

        for ($i=0; $i < count($strToArrID); $i++) { 
            $dataInput = [
                'name' => $strToArrSong[$i],
                'id_youtube' => $strToArrID[$i],
                'id_singer' => $data['nameSinger'],
                'image' => 'https://img.youtube.com/vi/'.$strToArrID[$i].'/maxresdefault.jpg',
                'id_category' => $data['idCategory']
            ];
            $builder->insert($dataInput);
        }
        header('Location: '.base_url());die();
    }
}
