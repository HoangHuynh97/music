<?php
namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = db_connect();
        
        $query = $db->query('select * from tbl_song limit 12');
        $result = $query->getResult();
        $data['dataResult'] = $result;

        $query2 = $db->query('select * from tbl_song order by id DESC limit 5');
        $result2 = $query2->getResult();
        $data['dataResult2'] = $result2;
        
        $query3 = $db->query('select * from tbl_song limit 5');
        $result3 = $query3->getResult();
        $data['dataResult3'] = $result3;

        $query4 = $db->query('select * from tbl_song order by RAND() limit 10');
        $result4 = $query4->getResult();
        $data['dataResult4'] = $result4;

        $queryRow = $db->query('select * from tbl_song limit 1');
        $row = $query->getRow();
        $data['dataRow'] = $row;

        return view('home/index', $data);
    }

    public function api_login()
    {
        $db = db_connect();

        $data = $this->request->getVar();
        $query = $db->query('select * from tbl_user where user = '.'"'.$data->inputUser.'"'.' and pw = '.'"'.$data->inputPw.'"');
        $row = $query->getRow();
        
        if(isset($row)) {
            $rep = [
                "message" => "success",
                "id_user" => $row->id,
                "name_user" => $row->name
            ];
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function api_signup()
    {
        $db = db_connect();
        $data = $this->request->getVar();

        $checkExists = $db->query('select * from tbl_user where user = '.'"'.$data->inputUser.'"');
        $row = $checkExists->getRow();
        if(isset($row)) {
            $rep = [
                "message" => "exists"
            ];
            return json_encode($rep);
        }

        $dataInsert = [
            'user' => $data->inputUser,
            'pw' => $data->inputPw,
            'name' => $data->inputName,
            'id_admin' => 0,
        ];
        $res = $db->table('tbl_user')->insert($dataInsert);
        
        if($res) {
            $rep = [
                "message" => "success"
            ];
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function upload_song()
    {
        $db = db_connect();
        $data = $this->request->getVar();

        $arrSinger = explode(" x ", $data->singer);
        $idSinger = '';
        for ($i=0; $i < count($arrSinger); $i++) {
            $checkDataSinger = $db->query('select * from tbl_singer where name = "'.$arrSinger[$i].'"');
            $rowDataSinger = $checkDataSinger->getRow();
            
            if(isset($rowDataSinger)) {
                $idSinger .= $rowDataSinger->id.',';
            } else {
                $dataInsertSinger = [
                    'name' => $arrSinger[$i],
                    'image' => '',
                ];
                $db->table('tbl_singer')->insert($dataInsertSinger);
                $idSinger .= $db->insertID().',';
            }
        }
        $idSinger = rtrim($idSinger, ",");

        $dataInsert = [
            'name' => $data->song,
            'id_singer' => $idSinger,
            'date_create' => date("Y-m-d"),
            'id_gg' => $data->gg,
        ];
        $res = $db->table('tbl_song')->insert($dataInsert);
        
        if($res) {
            $rep = [
                "message" => "success"
            ];
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function add_playlist()
    {
        $db = db_connect();
        $data = $this->request->getVar();

        if(isset($data->id_user_create)) {
            $dataInsert = [
                'name' => $data->name,
                'id_user_create' => $data->id_user_create
            ];
            $res = $db->table('tbl_playlist')->insert($dataInsert);
            
            if($res) {
                $rep = [
                    "message" => "success"
                ];
            } else {
                $rep = [
                    "message" => "fail"
                ];
            }
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function getNameSinger($id = '')
    {
        $db = db_connect();
        $query = $db->query('select * from tbl_singer where id = '.$id);
        $row = $query->getRow();
        return $row->name;
    }

    public function get_DataSong()
    {   
        $db = db_connect();
        $data = $this->request->getVar();
        $dataResult = [];
        
        $query_new = $db->query('select * from tbl_song ORDER BY date_create DESC limit 15');
        $arrSong_new = $query_new->getResultArray();
        $keySong_new = 0;
        foreach ($arrSong_new as $row) {
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $row['id_singer']);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongNew'][$keySong_new]['id'] = $row['id'];
            $dataResult['dataSongNew'][$keySong_new]['name'] = $row['name'];
            $dataResult['dataSongNew'][$keySong_new]['id_gg'] = $row['id_gg'];
            $dataResult['dataSongNew'][$keySong_new]['image'] = $row['image'];
            $dataResult['dataSongNew'][$keySong_new]['date_create'] = $row['date_create'];
            $dataResult['dataSongNew'][$keySong_new]['id_singer'] = $arrSinger;
            $dataResult['dataSongNew'][$keySong_new]['text_gr_singer'] = $text_gr_singer;
            $keySong_new++;
        }


        $query_playlist = $db->query('select * from tbl_playlist where id_user_create = 2 ORDER BY RAND() limit 10');
        $arrSong_playlist = $query_playlist->getResultArray();
        $key_playlist = 0;
        foreach ($arrSong_playlist as $row) {
            $arrImg = [];

            if($row['id_song'] != null && $row['id_song'] != '') {
                $arrIDSong = explode(',', $row['id_song']);
                $ii = 0;
                $count = count($arrIDSong) > 4 ? 4 : count($arrIDSong);
                for ($ii; $ii < $count; $ii++) {
                    $getIMG = $db->query('select * from tbl_song where id = '.$arrIDSong[$ii]);
                    $rowIMG = $getIMG->getRow();
                    $arrImg[$ii] = [
                        'img' => $rowIMG->image
                    ];
                }
                if($ii < 4) {
                    for ($ii; $ii < 4; $ii++) {
                        $arrImg[$ii] = [
                            'img' => 'am-nhac.jpg'
                        ];
                    }
                }
            } else {
                for ($i=0; $i < 4; $i++) { 
                    $arrImg[$i] = [
                        'img' => 'am-nhac.jpg'
                    ];
                }
            }

            $dataResult['dataPlaylist'][$key_playlist]['img'] = $arrImg;
            $dataResult['dataPlaylist'][$key_playlist]['id'] = $row['id'];
            $dataResult['dataPlaylist'][$key_playlist]['name'] = $row['name'];
            $dataResult['dataPlaylist'][$key_playlist]['create_by'] = 'Admin';
            $key_playlist++;
        }


        $query_hotSong = $db->query('select * from tbl_song ORDER BY view_total DESC limit 5');
        $arrSong_hot = $query_hotSong->getResultArray();
        $keySong_hot = 0;
        foreach ($arrSong_hot as $row) {
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $row['id_singer']);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongHot'][$keySong_hot]['id'] = $row['id'];
            $dataResult['dataSongHot'][$keySong_hot]['name'] = $row['name'];
            $dataResult['dataSongHot'][$keySong_hot]['id_gg'] = $row['id_gg'];
            $dataResult['dataSongHot'][$keySong_hot]['image'] = $row['image'];
            $dataResult['dataSongHot'][$keySong_hot]['date_create'] = $row['date_create'];
            $dataResult['dataSongHot'][$keySong_hot]['id_singer'] = $arrSinger;
            $dataResult['dataSongHot'][$keySong_hot]['text_gr_singer'] = $text_gr_singer;

            if(!$data->id_user) {
                $data->id_user = 0;
            }
            $getLike = $db->query('select * from tbl_like where id_song = '.$row['id'].' and id_user = '.$data->id_user);
            $rowLike = $getLike->getRow();
            $dataResult['dataSongHot'][$keySong_hot]['is_like'] = $rowLike ? $rowLike->id_song : 0;
            $keySong_hot++;
        }


        $query_Singer = $db->query('select * from tbl_singer limit 10');
        $arrSinger_hot = $query_Singer->getResultArray();
        $keySinger_hot = 0;
        foreach ($arrSinger_hot as $row) {
            $dataResult['dataSinger_hot'][$keySinger_hot]['img'] = $row['image'];
            $dataResult['dataSinger_hot'][$keySinger_hot]['name'] = $row['name'];
            $dataResult['dataSinger_hot'][$keySinger_hot]['id'] = $row['id'];
            $keySinger_hot++;
        }
        
        return json_encode($dataResult);
    }

    public function get_Singer()
    {
        $db = db_connect();
        $data = $this->request->getVar();

        $dataResult = [];

        $query_new = $db->query('select * from tbl_singer where id = '.$data->id_singer);
        $Singer = $query_new->getRow();
        $dataResult['dataImgSinger'] = $Singer->image;
        $dataResult['dataNameSinger'] = $Singer->name;

        $query_Song = $db->query('select * from tbl_song where FIND_IN_SET("'.$data->id_singer.'", id_singer) limit 9');
        $song_bySinger = $query_Song->getResultArray();

        $keySong = 0;
        foreach ($song_bySinger as $row) {
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $row['id_singer']);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongbySinger'][$keySong]['name'] = $row['name'];
            $dataResult['dataSongbySinger'][$keySong]['id_gg'] = $row['id_gg'];
            $dataResult['dataSongbySinger'][$keySong]['image'] = $row['image'];
            $dataResult['dataSongbySinger'][$keySong]['date_create'] = $row['date_create'];
            $dataResult['dataSongbySinger'][$keySong]['id_singer'] = $arrSinger;
            $dataResult['dataSongbySinger'][$keySong]['text_gr_singer'] = $text_gr_singer;
            $keySong++;
        }


        $query_SongExists = $db->query('select * from tbl_song where FIND_IN_SET("'.$data->id_singer.'", id_singer)');
        $song_bySingerExists = $query_SongExists->getResultArray();

        $keySongExists = 0;
        $checkExistsID = [];
        foreach ($song_bySingerExists as $row) {
            if($keySongExists == 5) {
                break;
            }
            $query_playlist = $db->query('select * from tbl_playlist where id_user_create = 2 and FIND_IN_SET("'.$row['id'].'", id_song)');
            $arrSong_playlist = $query_playlist->getResultArray();
            foreach ($arrSong_playlist as $row2) {
                if($keySongExists == 5) {
                    break;
                }
                if(in_array($row2['id'], $checkExistsID)) {
                    continue;
                } else {
                    array_push($checkExistsID, $row2['id']);
                }
                $arrImg = [];
                $arrIDSong = explode(',', $row2['id_song']);
                for ($i=0; $i < 4; $i++) { 
                    $getIMG = $db->query('select * from tbl_song where id = '.$arrIDSong[$i]);
                    $rowIMG = $getIMG->getRow();
                    $arrImg[$i] = [
                        'img' => $rowIMG->image
                    ];
                }
                $dataResult['dataPlaylist'][$keySongExists]['id'] = $row2['id'];
                $dataResult['dataPlaylist'][$keySongExists]['img'] = $arrImg;
                $dataResult['dataPlaylist'][$keySongExists]['name'] = $row2['name'];
                $dataResult['dataPlaylist'][$keySongExists]['create_by'] = 'Admin';
                $keySongExists++;
            }
        }
        return json_encode($dataResult);
    }

    public function get_Playlist()
    {   
        $db = db_connect();

        $data = $this->request->getVar();
        $dataResult = [];
        if(!is_numeric($data->id_playlist)) {
            return json_encode($dataResult);
        }
        
        $query_playlist = $db->query('select * from tbl_playlist where id = '.$data->id_playlist);
        $arrSong_playlist = $query_playlist->getRow();

        if(!$arrSong_playlist) {
            return json_encode($dataResult);
        }

        $arrImg = [];
        if($arrSong_playlist->id_song != null && $arrSong_playlist->id_song != '') {
            $arrIDSong = explode(',', $arrSong_playlist->id_song);
            $ii = 0;
            $count = count($arrIDSong) > 4 ? 4 : count($arrIDSong);
            for ($ii; $ii < $count; $ii++) {
                $getIMG = $db->query('select * from tbl_song where id = '.$arrIDSong[$ii]);
                $rowIMG = $getIMG->getRow();
                $arrImg[$ii] = [
                    'img' => $rowIMG->image
                ];
            }
            if($ii < 4) {
                for ($ii; $ii < 4; $ii++) {
                    $arrImg[$ii] = [
                        'img' => '/am-nhac.jpg'
                    ];
                }
            }
        } else {
            for ($i=0; $i < 4; $i++) { 
                $arrImg[$i] = [
                    'img' => '/am-nhac.jpg'
                ];
            }
        }
        $getCreateBy = $db->query('select * from tbl_user where id = '.$arrSong_playlist->id_user_create);
        $rowCreateBy = $getCreateBy->getRow();

        $dataResult['dataPlaylist']['img'] = $arrImg;
        $dataResult['dataPlaylist']['name'] = $arrSong_playlist->name;
        $dataResult['dataPlaylist']['create_by'] = $rowCreateBy->name;
        
        if(!$arrSong_playlist->id_song || $arrSong_playlist->id_song == '') {
            return json_encode($dataResult);
        }
        $song_byPlaylist = explode(',', $arrSong_playlist->id_song);
        $keySong = 0;
        for ($i=0; $i < count($song_byPlaylist); $i++) {
            $getSong = $db->query('select * from tbl_song where id = '.$song_byPlaylist[$i]);
            $rowSong = $getSong->getRow();

            if(!$rowSong) {
                continue;
            }
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $rowSong->id_singer);
            for ($j=0; $j < count($coverArrSinger); $j++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$j]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$j] = [
                    'id' => $coverArrSinger[$j],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongbyPlaylist'][$keySong]['name'] = $rowSong->name;
            $dataResult['dataSongbyPlaylist'][$keySong]['id_gg'] = $rowSong->id_gg;
            $dataResult['dataSongbyPlaylist'][$keySong]['image'] = $rowSong->image;
            $dataResult['dataSongbyPlaylist'][$keySong]['date_create'] = $rowSong->date_create;
            $dataResult['dataSongbyPlaylist'][$keySong]['id_singer'] = $arrSinger;
            $dataResult['dataSongbyPlaylist'][$keySong]['text_gr_singer'] = $text_gr_singer;
            $keySong++;
        }


        return json_encode($dataResult);
    }

    public function search_song()
    {
        $db = db_connect();

        $data = $this->request->getVar();
        $dataResult = [];

        $query = $db->query('select * from tbl_song where name like "%'.$data->key_search.'%" limit 5');
        $arrSong_search = $query->getResultArray();
        $keySongSearch = 0;
        foreach ($arrSong_search as $row) {
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $row['id_singer']);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongSearch'][$keySongSearch]['name'] = 'Ca khúc: '.$row['name'];
            $dataResult['dataSongSearch'][$keySongSearch]['id_gg'] = $row['id_gg'];
            $dataResult['dataSongSearch'][$keySongSearch]['image'] = $row['image'];
            $dataResult['dataSongSearch'][$keySongSearch]['date_create'] = $row['date_create'];
            $dataResult['dataSongSearch'][$keySongSearch]['id_singer'] = $arrSinger;
            $dataResult['dataSongSearch'][$keySongSearch]['text_gr_singer'] = $text_gr_singer;
            $keySongSearch++;
        }

        if($keySongSearch < 4) {
            $query_singer = $db->query('select * from tbl_singer where name like "%'.$data->key_search.'%" limit 5');
            $arrSinger_search = $query_singer->getResultArray();
            $keySingerSearch = 0;
            foreach ($arrSinger_search as $row) {
                $dataResult['dataSingerSearch'][$keySingerSearch]['name'] = 'Nghệ sĩ: '.$row['name'];
                $dataResult['dataSingerSearch'][$keySingerSearch]['id'] = $row['id'];
                $keySingerSearch++;
            }
        }


        $querySong = $db->query('select * from tbl_song where name like "%'.$data->key_search.'%" limit 6');
        $arrSongMain_search = $querySong->getResultArray();
        $keySong = 0;
        foreach ($arrSongMain_search as $row) {
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $row['id_singer']);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongMainSearch'][$keySong]['name'] = $row['name'];
            $dataResult['dataSongMainSearch'][$keySong]['id_gg'] = $row['id_gg'];
            $dataResult['dataSongMainSearch'][$keySong]['image'] = $row['image'];
            $dataResult['dataSongMainSearch'][$keySong]['date_create'] = $row['date_create'];
            $dataResult['dataSongMainSearch'][$keySong]['id_singer'] = $arrSinger;
            $dataResult['dataSongMainSearch'][$keySong]['text_gr_singer'] = $text_gr_singer;
            $keySong++;
        }


        return json_encode($dataResult);
    }

    public function get_DataProfile()
    {
        $db = db_connect();

        $data = $this->request->getVar();
        $dataResult = [];

        $query_playlist = $db->query('select * from tbl_playlist where id_user_create = '.$data->id_user.' ORDER BY id DESC limit 5');
        $arrSong_playlist = $query_playlist->getResultArray();
        $key_playlist = 0;
        foreach ($arrSong_playlist as $row) {
            $arrImg = [];
            if($row['id_song'] != null && $row['id_song'] != '') {
                $arrIDSong = explode(',', $row['id_song']);
                $ii = 0;
                $count = count($arrIDSong) > 4 ? 4 : count($arrIDSong);
                for ($ii; $ii < $count; $ii++) {
                    $getIMG = $db->query('select * from tbl_song where id = '.$arrIDSong[$ii]);
                    $rowIMG = $getIMG->getRow();
                    $arrImg[$ii] = [
                        'img' => $rowIMG->image
                    ];
                }
                if($ii < 4) {
                    for ($ii; $ii < 4; $ii++) {
                        $arrImg[$ii] = [
                            'img' => 'am-nhac.jpg'
                        ];
                    }
                }
            } else {
                for ($i=0; $i < 4; $i++) { 
                    $arrImg[$i] = [
                        'img' => 'am-nhac.jpg'
                    ];
                }
            }
            $dataResult['dataPlaylist'][$key_playlist]['img'] = $arrImg;
            $dataResult['dataPlaylist'][$key_playlist]['id'] = $row['id'];
            $dataResult['dataPlaylist'][$key_playlist]['name'] = $row['name'];

            $getCreateBy = $db->query('select * from tbl_user where id = '.$row['id_user_create']);
            $rowCreateBy = $getCreateBy->getRow();
            $dataResult['dataPlaylist'][$key_playlist]['create_by'] = $rowCreateBy->name;
            $key_playlist++;
        }



        $query_likeSong = $db->query('select DISTINCT id_song, id_user from tbl_like where id_user = '.$data->id_user);
        $arrSong_like = $query_likeSong->getResultArray();
        $keySong_like = 0;
        foreach ($arrSong_like as $row) {
            $query_Song = $db->query('select * from tbl_song where id = '.$row['id_song']);
            $rowSong = $query_Song->getRow();

            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $rowSong->id_singer);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongLike'][$keySong_like]['id'] = $rowSong->id;
            $dataResult['dataSongLike'][$keySong_like]['name'] = $rowSong->name;
            $dataResult['dataSongLike'][$keySong_like]['id_gg'] = $rowSong->id_gg;
            $dataResult['dataSongLike'][$keySong_like]['image'] = $rowSong->image;
            $dataResult['dataSongLike'][$keySong_like]['date_create'] = $rowSong->date_create;
            $dataResult['dataSongLike'][$keySong_like]['id_singer'] = $arrSinger;
            $dataResult['dataSongLike'][$keySong_like]['text_gr_singer'] = $text_gr_singer;

            if(!$data->id_user) {
                $data->id_user = 0;
            }
            $getLike = $db->query('select * from tbl_like where id_song = '.$rowSong->id.' and id_user = '.$data->id_user);
            $rowLike = $getLike->getRow();
            $dataResult['dataSongLike'][$keySong_like]['is_like'] = $rowLike ? $rowLike->id_song : 0;
            $keySong_like++;
        }

        return json_encode($dataResult);
    }

    public function add_like()
    {
        $db = db_connect();

        $data = $this->request->getVar();

        if(!$data->id_user) {
            $rep = [
                "message" => "fail"
            ];
            return json_encode($rep);
        }
        $dataInsert = [
                'id_song' => $data->id,
                'id_user' => $data->id_user
            ];
        $res = $db->table('tbl_like')->insert($dataInsert);
        
        if($res) {
            $rep = [
                "message" => "success",
                "id" => $data->id
            ];
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function del_like()
    {
        $db = db_connect();
        $builder = $db->table('tbl_like');
        $data = $this->request->getVar();

        if(!$data->id_user) {
            $rep = [
                "message" => "fail"
            ];
            return json_encode($rep);
        }

        $builder->where('id_song', $data->id);
        $builder->where('id_user', $data->id_user);
        $res = $builder->delete();
        
        if($res) {
            $rep = [
                "message" => "success",
                "id" => $data->id
            ];
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function check_like()
    {
        $db = db_connect();
        $data = $this->request->getVar();

        if(!$data->id_user || !$data->url) {
            $rep = [
                "message" => "fail"
            ];
            return json_encode($rep);
        }

        $getSong = $db->query('select * from tbl_song where id_gg = "'.$data->url.'"');
        $rowSong = $getSong->getRow();
        
        $getHeart = $db->query('select * from tbl_like where id_song = '.$rowSong->id.' and id_user = '.$data->id_user);
        $rowHeart = $getHeart->getRow();
        if($rowHeart) {
            $rep = [
                "message" => "success",
                "id" => $rowSong->id
            ];
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function add_like_byURL()
    {
        $db = db_connect();
        $data = $this->request->getVar();

        if(!$data->id_user || !$data->url) {
            $rep = [
                "message" => "fail"
            ];
            return json_encode($rep);
        }

        $getSong = $db->query('select * from tbl_song where id_gg = "'.$data->url.'"');
        $rowSong = $getSong->getRow();

        $dataInsert = [
                'id_song' => $rowSong->id,
                'id_user' => $data->id_user
            ];
        $res = $db->table('tbl_like')->insert($dataInsert);
        
        if($res) {
            $rep = [
                "message" => "success",
                "id" => $rowSong->id
            ];
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function del_like_byURL()
    {
        $db = db_connect();
        $builder = $db->table('tbl_like');
        $data = $this->request->getVar();

        if(!$data->id_user || !$data->url) {
            $rep = [
                "message" => "fail"
            ];
            return json_encode($rep);
        }

        $getSong = $db->query('select * from tbl_song where id_gg = "'.$data->url.'"');
        $rowSong = $getSong->getRow();

        $builder->where('id_song', $rowSong->id);
        $builder->where('id_user', $data->id_user);
        $res = $builder->delete();
        
        if($res) {
            $rep = [
                "message" => "success",
                "id" => $rowSong->id
            ];
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function get_DataNew()
    {
        $db = db_connect();
        $data = $this->request->getVar();
        $dataResult = [];
        
        $query_new = $db->query('select * from tbl_song ORDER BY date_create DESC limit '.$data->isStart.','.$data->loadMore);
        $arrSong_new = $query_new->getResultArray();
        $keySong_new = 0;
        foreach ($arrSong_new as $row) {
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $row['id_singer']);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongNew'][$keySong_new]['id'] = $row['id'];
            $dataResult['dataSongNew'][$keySong_new]['name'] = $row['name'];
            $dataResult['dataSongNew'][$keySong_new]['id_gg'] = $row['id_gg'];
            $dataResult['dataSongNew'][$keySong_new]['image'] = $row['image'];
            $dataResult['dataSongNew'][$keySong_new]['date_create'] = $row['date_create'];
            $dataResult['dataSongNew'][$keySong_new]['id_singer'] = $arrSinger;
            $dataResult['dataSongNew'][$keySong_new]['text_gr_singer'] = $text_gr_singer;

            if(!$data->id_user) {
                $data->id_user = 0;
            }
            $getLike = $db->query('select * from tbl_like where id_song = '.$row['id'].' and id_user = '.$data->id_user);
            $rowLike = $getLike->getRow();
            $dataResult['dataSongNew'][$keySong_new]['is_like'] = $rowLike ? $rowLike->id_song : 0;

            $keySong_new++;
        }

        return json_encode($dataResult);
    }

    public function get_playlist_id()
    {
        $db = db_connect();
        $data = $this->request->getVar();
        $dataResult = [];
        
        $query_new = $db->query('select * from tbl_playlist where id_user_create = '.$data->id_user);
        $arrSong_new = $query_new->getResultArray();
        if(!$arrSong_new) {
            return json_encode($dataResult);
        }
        $keySong_new = 0;
        foreach ($arrSong_new as $row) {
            $dataResult['dataSongNew'][$keySong_new]['id'] = $row['id'];
            $dataResult['dataSongNew'][$keySong_new]['name'] = $row['name'];
            $keySong_new++;
        }

        return json_encode($dataResult);
    }

    public function add_song_playlist()
    {
        $db = db_connect();
        $builder = $db->table('tbl_playlist');
        $data = $this->request->getVar();
        if(isset($data->id_song) && isset($data->id_playlist)) {
            $getOldData = $db->query('select * from tbl_playlist where id = '.$data->id_playlist);
            $arrSong_new = $getOldData->getRow();
            if(is_null($arrSong_new->id_song)) {
                $arrSong_new->id_song = '';
            }
            $dataInsert = [
                'id_song' => $arrSong_new->id_song == '' ? $data->id_song : $arrSong_new->id_song.','.$data->id_song
            ];

            $builder->where('id', $data->id_playlist);
            $res = $builder->update($dataInsert);
            
            if($res) {
                $rep = [
                    "message" => "success"
                ];
            } else {
                $rep = [
                    "message" => "fail"
                ];
            }
        } else {
            $rep = [
                "message" => "fail"
            ];
        }
        return json_encode($rep);
    }

    public function get_ramdom_song()
    {
        $db = db_connect();
        $data = $this->request->getVar();
        $dataResult = [];
        
        $query_new = $db->query('select * from tbl_song ORDER BY RAND() limit 20');
        $arrSong_new = $query_new->getResultArray();
        if(!$arrSong_new) {
            return json_encode($dataResult);
        }
        $keySong_new = 0;
        foreach ($arrSong_new as $row) {
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $row['id_singer']);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongNew'][$keySong_new]['id'] = $row['id'];
            $dataResult['dataSongNew'][$keySong_new]['name'] = $row['name'];
            $dataResult['dataSongNew'][$keySong_new]['id_gg'] = $row['id_gg'];
            $dataResult['dataSongNew'][$keySong_new]['image'] = $row['image'];
            $dataResult['dataSongNew'][$keySong_new]['date_create'] = $row['date_create'];
            $dataResult['dataSongNew'][$keySong_new]['id_singer'] = $arrSinger;
            $dataResult['dataSongNew'][$keySong_new]['text_gr_singer'] = $text_gr_singer;

            if(!$data->id_user) {
                $data->id_user = 0;
            }
            $getLike = $db->query('select * from tbl_like where id_song = '.$row['id'].' and id_user = '.$data->id_user);
            $rowLike = $getLike->getRow();
            $dataResult['dataSongNew'][$keySong_new]['is_like'] = $rowLike ? $rowLike->id_song : 0;

            $keySong_new++;
        }

        return json_encode($dataResult);
    }

    public function get_song_by_url($value='')
    {
        $db = db_connect();
        $data = $this->request->getVar();
        $dataResult = [];
        
        $query_new = $db->query('select * from tbl_song where id_gg = "'.$data->url.'"');
        $arrSong_new = $query_new->getResultArray();
        if(!$arrSong_new) {
            return json_encode($dataResult);
        }
        $keySong_new = 0;
        foreach ($arrSong_new as $row) {
            $text_gr_singer = '';
            $arrSinger = [];
            $coverArrSinger = explode(',', $row['id_singer']);
            for ($i=0; $i < count($coverArrSinger); $i++) { 
                $getNameSinger = $db->query('select * from tbl_singer where id = '.$coverArrSinger[$i]);
                $rowNameSinger = $getNameSinger->getRow();
                $arrSinger[$i] = [
                    'id' => $coverArrSinger[$i],
                    'name' => $rowNameSinger->name
                ];

                $text_gr_singer .= $rowNameSinger->name.' x ';
            }
            $text_gr_singer = rtrim($text_gr_singer, " x ");
            $dataResult['dataSongNew'][$keySong_new]['id'] = $row['id'];
            $dataResult['dataSongNew'][$keySong_new]['name'] = $row['name'];
            $dataResult['dataSongNew'][$keySong_new]['id_gg'] = $row['id_gg'];
            $dataResult['dataSongNew'][$keySong_new]['image'] = $row['image'];
            $dataResult['dataSongNew'][$keySong_new]['date_create'] = $row['date_create'];
            $dataResult['dataSongNew'][$keySong_new]['id_singer'] = $arrSinger;
            $dataResult['dataSongNew'][$keySong_new]['text_gr_singer'] = $text_gr_singer;

            if(!$data->id_user) {
                $data->id_user = 0;
            }
            $getLike = $db->query('select * from tbl_like where id_song = '.$row['id'].' and id_user = '.$data->id_user);
            $rowLike = $getLike->getRow();
            $dataResult['dataSongNew'][$keySong_new]['is_like'] = $rowLike ? $rowLike->id_song : 0;

            $keySong_new++;
        }

        return json_encode($dataResult);
    }
}
