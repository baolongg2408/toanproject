<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AlbumModel;
use App\Models\PhotoModel;

class Albums extends BaseController
{
    public function index()
    {
        $albums = (new AlbumModel())->orderBy('id','desc')->findAll();
        return view('admin/albums/index', compact('albums'));
    }

    public function create()
    {
        $data = $this->request->getPost(['name','description']);
        $data['slug'] = url_title($data['name'],'-',true);

        // upload cover (tuỳ chọn)
        $cover = $this->request->getFile('cover');
        if ($cover && $cover->isValid()) {
            $dir = FCPATH.'uploads/covers/';
            if (!is_dir($dir)) mkdir($dir,0755,true);
            $new = time().'_'.$cover->getRandomName();
            $cover->move($dir, $new);
            $data['cover_path'] = 'uploads/covers/'.$new;
        }

        (new AlbumModel())->insert($data);
        return redirect()->to('/admin/albums')->with('msg','Đã tạo chủ đề');
    }

    public function update(int $id)
    {
        $m = new AlbumModel();
        $data = $this->request->getPost(['name','description']);
        $data['slug'] = url_title($data['name'],'-',true);

        $cover = $this->request->getFile('cover');
        if ($cover && $cover->isValid()) {
            $dir = FCPATH.'uploads/covers/';
            if (!is_dir($dir)) mkdir($dir,0755,true);
            $new = time().'_'.$cover->getRandomName();
            $cover->move($dir, $new);
            $data['cover_path'] = 'uploads/covers/'.$new;
        }

        $m->update($id, $data);
        return redirect()->to('/admin/albums')->with('msg','Đã cập nhật');
    }

    public function delete(int $id)
    {
        // Xoá files ảnh liên quan + cover
        $mA = new AlbumModel();  $mP = new PhotoModel();
        $album = $mA->find($id);

        if ($album && !empty($album['cover_path'])) @unlink(FCPATH.$album['cover_path']);

        $photos = $mP->where('album_id',$id)->findAll();
        foreach ($photos as $p) {
            @unlink(FCPATH.$p['large_path']);
            @unlink(FCPATH.$p['thumb_path']);
            @unlink(WRITEPATH.'uploads/originals/'.$p['orig_name']);
        }

        $mP->where('album_id',$id)->delete();
        $mA->delete($id);

        return redirect()->to('/admin/albums')->with('msg','Đã xoá chủ đề');
    }

    // Đặt ảnh làm cover cho album
    public function setCover(int $albumId, int $photoId)
    {
        $photo = (new PhotoModel())->find($photoId);
        if ($photo && $photo['album_id'] == $albumId) {
            (new AlbumModel())->update($albumId, ['cover_path' => $photo['large_path']]);
        }
        return redirect()->back()->with('msg','Đã đặt ảnh đại diện');
    }
}
