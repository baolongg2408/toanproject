<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AlbumModel;
use App\Models\SetModel;
use App\Models\PhotoModel;

class Sets extends BaseController
{
    public function byAlbum(int $albumId)
    {
        $album = (new AlbumModel())->find($albumId);
        if (!$album) return redirect()->to('/admin/albums')->with('error','Không tìm thấy chủ đề');

        $sets = (new SetModel())->where('album_id',$albumId)->orderBy('id','desc')->findAll();
        return view('admin/sets/index', compact('album','sets'));
    }

    public function create(int $albumId)
    {
        $data = $this->request->getPost(['name','description']);
        $data['album_id'] = $albumId;
        $data['slug']     = url_title($data['name'],'-',true);

        // cover optional
        $cover = $this->request->getFile('cover');
        if ($cover && $cover->isValid()) {
            $dir = FCPATH.'uploads/set_covers/';
            if (!is_dir($dir)) mkdir($dir,0755,true);
            $new = time().'_'.$cover->getRandomName();
            $cover->move($dir, $new);
            $data['cover_path'] = 'uploads/set_covers/'.$new;
        }

        (new SetModel())->insert($data);
        return redirect()->to("/admin/albums/{$albumId}/sets")->with('msg','Đã tạo bộ ảnh');
    }

    public function update(int $setId)
    {
        $mS = new SetModel();
        $set = $mS->find($setId);
        if (!$set) return redirect()->back()->with('error','Không tìm thấy bộ ảnh');

        $data = $this->request->getPost(['name','description']);
        $data['slug'] = url_title($data['name'],'-',true);

        $cover = $this->request->getFile('cover');
        if ($cover && $cover->isValid()) {
            $dir = FCPATH.'uploads/set_covers/';
            if (!is_dir($dir)) mkdir($dir,0755,true);
            $new = time().'_'.$cover->getRandomName();
            $cover->move($dir, $new);
            $data['cover_path'] = 'uploads/set_covers/'.$new;
        }

        $mS->update($setId, $data);
        return redirect()->to("/admin/albums/{$set['album_id']}/sets")->with('msg','Đã cập nhật');
    }

    public function delete(int $setId)
    {
        $mS = new SetModel(); $mP = new PhotoModel();
        $set = $mS->find($setId);
        if (!$set) return redirect()->back();

        if (!empty($set['cover_path'])) @unlink(FCPATH.$set['cover_path']);

        // xoá files ảnh thuộc set
        $photos = $mP->where('set_id',$setId)->findAll();
        foreach ($photos as $p) {
            @unlink(FCPATH.$p['large_path']);
            @unlink(FCPATH.$p['thumb_path']);
            @unlink(WRITEPATH.'uploads/originals/'.$p['orig_name']);
        }
        $mP->where('set_id',$setId)->delete();
        $mS->delete($setId);

        return redirect()->to("/admin/albums/{$set['album_id']}/sets")->with('msg','Đã xoá bộ ảnh');
    }

    public function setCover(int $setId, int $photoId)
    {
        $mS = new SetModel(); $mP = new PhotoModel();
        $set = $mS->find($setId); $p = $mP->find($photoId);
        if ($set && $p && (int)$p['set_id'] === (int)$setId) {
            $mS->update($setId, ['cover_path' => $p['large_path']]);
        }
        return redirect()->back()->with('msg','Đã đặt ảnh đại diện cho bộ ảnh');
    }
}
