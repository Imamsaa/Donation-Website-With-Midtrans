<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AppMigration extends Migration
{
    public function up()
    {

        //Migrasi Tabel Users
        $this->forge->addField([
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'first_name'  => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'last_name'   => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'username'    => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'level'       => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
            ],
            'status'       => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
            ],
            'address'     => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'photo'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'phone'       => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => true,
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('users', true);

        $this->db->table('users')->insert([
            'first_name' => 'admin',
            'last_name'  => 'sistem',
            'email'      => 'admin@donasi.com',
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'level'      => 'admin',
            'status'      => 'Aktif',
            'address'    => 'Jl. Contoh No. 123',
            'photo'      => 'default.png',
            'phone'      => '08123456789',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->db->table('users')->insert([
            'first_name' => 'ketua',
            'last_name'  => 'sistem',
            'email'      => 'ketua@donasi.com',
            'username'   => 'ketua',
            'password'   => password_hash('ketua123', PASSWORD_DEFAULT),
            'level'      => 'ketua',
            'status'      => 'Aktif',
            'address'    => 'Jl. Contoh No. 456',
            'photo'      => 'default.png',
            'phone'      => '08123456789',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->db->table('users')->insert([
            'first_name' => 'bendahara',
            'last_name'  => 'sistem',
            'email'      => 'bendahara@donasi.com',
            'username'   => 'bendahara',
            'password'   => password_hash('bendahara123', PASSWORD_DEFAULT),
            'level'      => 'bendahara',
            'status'      => 'Aktif',
            'address'    => 'Jl. Contoh No. 456',
            'photo'      => 'default.png',
            'phone'      => '08123456789',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        //akhir Migrasi Tabel Users

        // Migrasi Tabel Program
        $this->forge->addField([
            'program_id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title'         => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'photo'         => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'description'   => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'target_donate' => [
                'type'       => 'VARCHAR',
                'constraint' => 100, 
                'default'    => '0',
            ],
            'total_donate' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '0',
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('program_id', true);
        $this->forge->createTable('program', true);

        //contoh data awal
        $this->db->table('program')->insert([
            'title'         => 'Sedekah Al Quran',
            'slug'          => 'sedekah-al-quran',
            'photo'         => 'program1.png',
            'description'   => 'Sedekahkan Al-Quran, sebarkan cahaya ilmu dan hidayah untuk generasi penerus Islam.',
            'target_donate' => '10000000',
            'total_donate'  => '0',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('program')->insert([
            'title'         => 'Donasi Palestina',
            'slug'          => 'donasi-palestina',
            'photo'         => 'program2.png',
            'description'   => 'Bantu saudara kita di Palestina, setiap donasi adalah tanda kepedulian dan persaudaraan seiman.',
            'target_donate' => '20000000',
            'total_donate'  => '0',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        $this->db->table('program')->insert([
            'title'         => 'Beasiswa Hafidz Al Quran',
            'slug'          => 'beasiswa-hafidz-al-quran',
            'photo'         => 'program3.png',
            'description'   => 'Investasi akhirat dengan mencetak generasi penghafal Al-Quran yang unggul dan berakhlak mulia.',
            'target_donate' => '15000000',
            'total_donate'  => '0',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        //akhir Migrasi Tabel Program

        // Tabel Donasi
        $this->forge->addField([
            'donasi_id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'      => true,
            ],
            'program_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id'    => [
                'type'       => 'INT',
                'constraint' => 30,
                'unsigned'   => true,
                'default' => 0,
            ],
            'donatur_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default' => 0,
            ],
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'anonim'    => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'tidak',
            ],
            'status'     => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'pending',
            ],
            'amount'     => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone'      => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => true,
            ],
            'email'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'referral'   => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('donasi_id', true);
        // $this->forge->addForeignKey('program_id', 'program', 'program_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('donasi', true);

        //Tabel Instansi
        $this->forge->addField([
            'instansi_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'        => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'address'     => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'logo'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'phone'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'facebook'   => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'instagram'   => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'website'     => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('instansi_id', true);
        $this->forge->createTable('instansi', true);

        //contoh data awal
        $this->db->table('instansi')->insert([
            'name'        => 'Bina Insani Grobogan',
            'description' => 'Yayasan Bina Insani Grobogan adalah lembaga pendidikan dan sosial yang beralamat di Jl. Taman Makam Pahlawan No. 19, Purwodadi, Grobogan, didirikan pada tahun 2006 dan telah memperoleh pengesahan badan hukum dari Kemenkumham pada 26 Februari 2020. Dipimpin oleh Sukamto, S.Pd., MM dengan operator Suwati, yayasan ini menaungi berbagai unit pendidikan seperti KB, SD, dan SMP Islam Terpadu Al Firdaus. Berfokus pada pengembangan potensi individu melalui pendidikan dan pemberdayaan masyarakat, Yayasan Bina Insani aktif menciptakan perubahan positif dan berkelanjutan, serta turut berjejaring dengan lembaga sosial seperti Rumah Zakat untuk memperluas dampak kegiatannya.',
            'address'     => 'Jalan Taman Makam Pahlawan No. 19, Purwodadi, Kecamatan Purwodadi',
            'logo'        => 'logo.png',
            'phone'       => '081548811047',
            'email'       => 'binainsanigrobogan@gmail.com',
            'facebook'    => 'https://facebook.com/donasi',
            'instagram'   => 'https://instagram.com/donasi',
            'website'     => 'https://donasi.com',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
        //akhir Tabel Instansi

        //Tabel Setting
        $this->forge->addField([
            'set_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'server_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'client_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('set_id', true);
        $this->forge->createTable('setting', true);

        //contoh data awal
        $this->db->table('setting')->insert([
            'server_key' => 'SB-Mid-server-4VIz2bklbBYFv_gvPpA33Qw_',
            'client_key' => 'SB-Mid-client-o6_E3CUErSGC06il',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        //akhir Tabel Setting

        //Tabel Fundraiser
        $this->forge->addField([
            'fundraiser_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'first_name'    => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'last_name'     => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'email'         => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'username'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password'      => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'level'       => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
                'default'    => 'fundraiser'
            ],
            'address'       => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'photo'         => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'phone'         => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'referral' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'created_at'    => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'    => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('fundraiser_id', true);
        $this->forge->createTable('fundraiser', true);

        //contoh data awal
        $this->db->table('fundraiser')->insert([
            'first_name' => 'Fundraiser',
            'last_name'  => 'Sistem',
            'email'      => 'fundraiser@donsi.com',
            'username'   => 'fundraiser',
            'password'   => password_hash('fundraiser123', PASSWORD_DEFAULT),
            'level'      => 'fundraiser',
            'address'    => 'Jl. Contoh No. 789',
            'photo'      => 'default.png',
            'phone'      => '08123456789',
            'referral'   => 'referral_code',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('fundraiser')->insert([
            'first_name' => 'Fundraiser',
            'last_name'  => 'Sistem 2',
            'email'      => 'fundraiser2@donasi.com',
            'username'   => 'fundraiser2',
            'password'   => password_hash('fundraiser123', PASSWORD_DEFAULT),
            'level'      => 'fundraiser',
            'address'    => 'Jl. Contoh No. 101',
            'photo'      => 'default.png',
            'phone'      => '08123456789',
            'referral'   => 'referral_code_2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        //akhir Tabel Fundraiser

        //Tabel Donatur
        $this->forge->addField([
            'donatur_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'last_name'  => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'username'    => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password'    => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'level'       => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
                'default'    => 'donatur',
            ],
            'status'     => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'Aktif',
            ],
            'address'     => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'photo'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'phone'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('donatur_id', true);
        $this->forge->createTable('donatur', true);

        //contoh data awal
        $this->db->table('donatur')->insert([
            'first_name' => 'Donatur',
            'last_name'  => 'Sistem',
            'email'      => 'donatur@donasi.com',
            'username'   => 'donatur',
            'password'   => password_hash('donatur123', PASSWORD_DEFAULT),
            'level'      => 'donatur',
            'status'     => 'Aktif',
            'address'    => 'Jl. Contoh No. 111',
            'photo'      => 'default.png',
            'phone'      => '08123456789',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->db->table('donatur')->insert([
            'first_name' => 'Donatur',
            'last_name'  => 'Sistem 2',
            'email'      => 'donatur2@donasi.com',
            'username'   => 'donatur2',
            'password'   => password_hash('donatur123', PASSWORD_DEFAULT),
            'level'      => 'donatur',
            'status'     => 'Aktif',
            'address'    => 'Jl. Contoh No. 121',
            'photo'      => 'default.png',
            'phone'      => '08123456789',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        //akhir Tabel Donatur
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('program', true);
        $this->forge->dropTable('donasi', true);
        $this->forge->dropTable('instansi', true);
        $this->forge->dropTable('setting', true);
        $this->forge->dropTable('fundraiser', true);
        $this->forge->dropTable('donatur', true);
    }
}
