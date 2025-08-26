<?php
namespace App\Models;
use CodeIgniter\Model;

class AlbumModel extends Model
{
    protected $table = 'albums';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['slug','name','description','cover_path','is_public'];
}
