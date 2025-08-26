<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        $sess = session();

        if ($this->request->getMethod() === 'post') {
            $username = trim((string)$this->request->getPost('username'));
            $password = (string)$this->request->getPost('password');

            $u = (new UserModel())->where('username', $username)->first();
            $ok = $u && (int)$u['is_active'] === 1 && password_verify($password, $u['password_hash']);

            if ($ok) {
                $sess->set('auth', [
                    'user_id'  => (int)$u['id'],
                    'username' => $u['username'],
                    'time'     => time(),
                ]);
                $to = $sess->getFlashdata('redirect') ?? '/admin/albums';
                return redirect()->to($to);
            }
            return redirect()->back()->with('error', 'Sai tài khoản hoặc mật khẩu')->withInput();
        }

        return view('auth/login'); // GET: hiển thị form
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
