<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $router = service('router');
        $currentRoute = $router->getMatchedRouteOptions();
        
        // Jika route memerlukan auth dan user belum login
        if (isset($currentRoute['filter']) && in_array('auth', $currentRoute['filter'])) {
            if (!$session->get('isLoggedIn')) {
                $session->setFlashdata('kotakok', [
                    'status' => 'error',
                    'title' => 'Akses Ditolak',
                    'message' => 'Silakan login terlebih dahulu'
                ]);
                return redirect()->to(base_url('login'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah request
    }
}