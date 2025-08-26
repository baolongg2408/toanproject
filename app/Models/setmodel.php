<?php
namespace App\Models;
use CodeIgniter\Model;

class SetModel extends Model
{
    protected $table         = 'album_sets';
    protected $useTimestamps = true;
    protected $useSoftDeletes= true;
    protected $allowedFields = ['album_id','slug','name','description','cover_path','is_public'];
}
