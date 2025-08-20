<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DonasiModel;
use App\Models\SettingModel;
use App\Models\ProgramModel;

class Midtrans extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->donasiModel = new DonasiModel();
        $this->settingModel = new SettingModel();
        $this->programModel = new ProgramModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $data = $this->request->getPost();

        try
        {
        $key = $this->settingModel->first();
        // Set your Merchant Server Key

        \Midtrans\Config::$serverKey = $key['server_key'];

        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
 
        $order_id = rand();
        $params = array(
            'transaction_details' => array(
                'order_id' => $order_id,
                'gross_amount' => $data['amount'],
            ),
            'customer_details' => array(
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $snapUrl = "https://app.midtrans.com/snap/v2/vtweb/" . $snapToken;

        // Simpan di flashdata
        $donasi = [
            'order_id' => $order_id,
            'program_id' => $data['program_id'],
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'referral' => $data['referral'],
            'amount' => $data['amount'],
            'status' => 'pending',
        ];

        if (isset($data['anonim'])) {
            $donasi['anonim'] = $data['anonim'];
        }

        if (!$this->donasiModel->save($donasi)) {
            throw new \RuntimeException('Gagal menyimpan data donasi');
        }

        $db->transComplete();

        session()->setFlashdata('snap_url', $snapUrl);

        // Redirect ke halaman view yang akan buka tab baru
        return redirect()->back();
        
        } catch(\Exception $e) {

        $db->transRollback();

        session()->setFlashdata('kotakok', [
            'status' => 'error',
            'title' => 'Pembayaran Gagal',
            'message' => 'Gagal melakukan pembayaran, Coba lagi nanti'
        ]);

        return redirect()->back()->withInput();
        }
    }

    public function notification()
    {
        $rawInput = $this->request->getJSON();
    
        // Kalau kosong (misalnya test URL tanpa data), langsung balas 200 OK
        if (!$rawInput) {
            return $this->response
                ->setStatusCode(200)
                ->setBody('Notification endpoint OK - No data received');
        }
        
        $db = \Config\Database::connect();
        $db->transStart();

        try
        {
            $key = $this->settingModel->first();
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$serverKey = $key['server_key'];
            $notif = new \Midtrans\Notification();
            
            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $order_id = $notif->order_id;
            $fraud = $notif->fraud_status;

            $donasi = $this->donasiModel->where('order_id', $order_id)->first();
            if ($transaction == 'capture') {
            if ($type == 'credit_card'){
                if($fraud == 'accept'){
                    if (!$this->donasiModel->save([
                        'donasi_id' => $donasi['donasi_id'],
                        'status' => 'success'
                    ])) {
                        throw new \RuntimeException('Gagal menyimpan data donasi');
                    }else{
                        $program = $this->programModel->where('program_id',$donasi['program_id'])->first();
                        $total_donate = $program['total_donate'] + $donasi['amount'];
                        if (!$this->programModel->save([
                            'program_id' => $program['program_id'],
                            'total_donate' => $total_donate
                        ])) {
                            throw new \RuntimeException('Gagal menyimpan data donasi');
                        }
                    }
                }
                }
            }
            else if ($transaction == 'settlement'){
            // TODO set payment status in merchant's database to 'Settlement'
                if (!$this->donasiModel->save([
                    'donasi_id' => $donasi['donasi_id'],
                    'status' => 'success'
                ])) {
                    throw new \RuntimeException('Gagal menyimpan data donasi');
                }else{
                        $program = $this->programModel->where('program_id',$donasi['program_id'])->first();
                        $total_donate = $program['total_donate'] + $donasi['amount'];
                        if (!$this->programModel->save([
                            'program_id' => $program['program_id'],
                            'total_donate' => $total_donate
                        ])) {
                            throw new \RuntimeException('Gagal menyimpan data donasi');
                        }
                    }
            }
            else if($transaction == 'pending'){
                if (!$this->donasiModel->save([
                    'donasi_id' => $donasi['donasi_id'],
                    'status' => 'pending'
                ])) {
                    throw new \RuntimeException('Gagal menyimpan data donasi');
                }
            }
            else if ($transaction == 'deny') {
                if (!$this->donasiModel->save([
                    'donasi_id' => $donasi['donasi_id'],
                    'status' => 'denied'
                ])) {
                    throw new \RuntimeException('Gagal menyimpan data donasi');
                }
            }
            else if ($transaction == 'expire') {
                if (!$this->donasiModel->save([
                    'donasi_id' => $donasi['donasi_id'],
                    'status' => 'expire'
                ])) {
                    throw new \RuntimeException('Gagal menyimpan data donasi');
                }
            }
            else if ($transaction == 'cancel') {
                if (!$this->donasiModel->save([
                    'donasi_id' => $donasi['donasi_id'],
                    'status' => 'canceled'
                ])) {
                    throw new \RuntimeException('Gagal menyimpan data donasi');
                }
            }
            
        $db->transComplete();
        
        } catch(\Exception $e) {

        $db->transRollback();

        }
        
    }
}
