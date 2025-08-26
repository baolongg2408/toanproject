<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SetModel;
use App\Models\PhotoModel;
use App\Models\AlbumModel;

class Photos extends BaseController
{
    public function bySet(int $setId)
    {
        $set = (new SetModel())->find($setId);
        if (!$set) return redirect()->to('/admin/albums')->with('error','Không tìm thấy bộ ảnh');

        $photos = (new PhotoModel())
            ->where('set_id',$setId)
            ->orderBy('id','desc')->findAll();

        return view('admin/photos/by_set', compact('set','photos'));
    }


public function bulkCreate()
{
    helper(['text']);

    $setId = (int) $this->request->getPost('set_id');
    if (!$setId) return redirect()->back()->with('error','Thiếu set_id');

    $set = (new SetModel())->find($setId);
    if (!$set) return redirect()->back()->with('error','Set không tồn tại');

    // Lấy album_id từ set (để thỏa FK albums)
    $albumId = (int) ($set['album_id'] ?? 0);
    if ($albumId <= 0 || !(new AlbumModel())->find($albumId)) {
        return redirect()->back()->with('error','Set không gắn với album hợp lệ');
    }

    // LẤY FILES (QUAN TRỌNG)
    $list = $this->request->getFileMultiple('files') ?? [];
    if (!$list) return redirect()->back()->with('error','Chưa chọn ảnh');

    // Chuẩn bị thư mục
    $pubLarge = FCPATH.'uploads/photos/large/';
    $pubThumb = FCPATH.'uploads/photos/thumb/';
    $oriDir   = WRITEPATH.'uploads/originals/';
    foreach ([$pubLarge,$pubThumb,$oriDir] as $d) if (!is_dir($d)) mkdir($d,0755,true);

    $img = \Config\Services::image();
    $m   = new PhotoModel();

    foreach ($list as $file) {
        if (!$file->isValid()) continue;

        // Lấy thông tin TRƯỚC khi move()
        $clientMime = $file->getClientMimeType();
        $size       = $file->getSize();
        $ext        = $file->getClientExtension() ?: $file->getExtension();

        $name = time().'_'.random_string('alnum',8).'.'.$ext;

        // Lưu bản gốc
        $file->move($oriDir, $name);

        // Tạo ảnh large & thumb
        $img->withFile($oriDir.$name)->resize(1600, 1600, true, 'auto')->save($pubLarge.$name);
        $img->withFile($oriDir.$name)->fit(400, 400, 'center')->save($pubThumb.$name);

        $info = @getimagesize($pubLarge.$name);

        // Ghi DB (có kèm album_id để qua FK)
        $m->insert([
            'album_id'   => $albumId,
            'set_id'     => $setId,
            'title'      => pathinfo($name, PATHINFO_FILENAME),
            'caption'    => null,
            'mime'       => $clientMime,
            'size'       => $size,
            'width'      => $info[0] ?? null,
            'height'     => $info[1] ?? null,
            'orig_name'  => $name,
            'large_path' => 'uploads/photos/large/'.$name,
            'thumb_path' => 'uploads/photos/thumb/'.$name,
            'is_public'  => 1,
        ]);
    }

    return redirect()->to("/admin/sets/{$setId}/photos")->with('msg','Đã upload ảnh');
}

    public function update(int $id)
    {
        $data = $this->request->getPost(['title','caption']);
        (new PhotoModel())->update($id, $data);
        $setId = (int)$this->request->getPost('set_id');
        return redirect()->to("/admin/sets/{$setId}/photos")->with('msg','Đã lưu');
    }

    public function delete(int $id)
    {
        $m = new PhotoModel();
        $p = $m->find($id);
        $setId = $p['set_id'] ?? 0;

        if ($p) {
            @unlink(FCPATH.$p['large_path']);
            @unlink(FCPATH.$p['thumb_path']);
            @unlink(WRITEPATH.'uploads/originals/'.$p['orig_name']);
            $m->delete($id);
        }
        return redirect()->to("/admin/sets/{$setId}/photos")->with('msg','Đã xoá ảnh');
    }
}
