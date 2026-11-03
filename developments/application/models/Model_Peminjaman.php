<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Peminjaman extends CI_Model 
{
	var $table = 'tb_peminjaman';

    public function tampil()
    {
        return $this->db->order_by('id_peminjaman', 'DESC')->get($this->table);
    }

    public function tampil_detail($where)
    {
        return $this->db->order_by('id_peminjaman', 'DESC')->get_where($this->table, $where);
    }

    public function tampil_id()
    {
        return $this->db->select_max('id_peminjaman')->get($this->table);
    }

    public function jumlah_menunggu()
    {
        return $this->db->where('status_pinjam', 'Menunggu')->count_all_results($this->table);
    }

    public function auto_cancel_no_show()
    {
        $sql = "UPDATE tb_peminjaman 
                SET status_pinjam = 'Dibatalkan', 
                    waktu_pembatalan = NOW(), 
                    keterangan = CONCAT(keterangan, ' [Auto-Cancel: Tidak Check-In >10 menit]')
                WHERE status_pinjam = 'Disetujui' 
                  AND tanggal_meeting = CURDATE() 
                  AND waktu_checkin IS NULL 
                  AND ADDTIME(CONCAT(tanggal_meeting, ' ', jam_meeting), '00:10:00') <= NOW()";
        
        $this->db->query($sql);
    }

    public function slot_terpakai($nama_ruangan, $tanggal_meeting)
    {
        $this->auto_cancel_no_show();

        return $this->db
            ->select('jam_meeting')
            ->where('ruangan_dipinjam', $nama_ruangan)
            ->where('tanggal_meeting', $tanggal_meeting)
            ->where('status_pinjam !=', 'Dibatalkan')
            ->where('jam_meeting IS NOT NULL', NULL, FALSE)
            ->get($this->table);
    }

    public function slot_sudah_dipesan($nama_ruangan, $tanggal_meeting, $jam_meeting)
    {
        $this->auto_cancel_no_show();

        return $this->db
            ->where('ruangan_dipinjam', $nama_ruangan)
            ->where('tanggal_meeting', $tanggal_meeting)
            ->where('jam_meeting', $jam_meeting)
            ->where('status_pinjam !=', 'Dibatalkan')
            ->count_all_results($this->table) > 0;
    }

    public function buat($data_isi)
	{	
		return $this->db->insert($this->table, $data_isi);
	}

	public function perbarui($data, $where)
	{
		return $this->db->update($this->table, $data, $where);
	}

	public function hapus($where)
	{
		return $this->db->delete($this->table, $where);
	}
}