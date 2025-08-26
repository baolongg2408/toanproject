<?php
namespace App\Models;
use CodeIgniter\Model;

class PhotoModel extends Model
{
    protected $table = 'photos';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
   protected $allowedFields = [
  'album_id','set_id','title','caption','mime','size',
  'width','height','orig_name','large_path','thumb_path','is_public'
];
}
