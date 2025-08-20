<?php

namespace App\Controllers;
use App\Models\InstansiModel;
use App\Models\ProgramModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        helper('text');
        $this->instansiModel = new InstansiModel();
        $this->programModel = new ProgramModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index(): string
    {
        $data =[
            'its' => $this->instansiModel->first(),
            'programs' => $this->programModel->limit(3)->findAll(),
            'catalog' => $this->programModel->limit(6)->findAll(),
            'title' => 'Welcome to Bina Insani Grobogan',
            'description' => 'Welcome to the home page of our application.',
            'keywords' => 'home, welcome, application'
        ];
        return view('pages/home', $data);
    }
}
