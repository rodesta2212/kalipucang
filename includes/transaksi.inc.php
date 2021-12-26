<?php
class Transaksi {
	private $conn;
    private $table_transaksi = 'transaksi';
	private $table_barang = 'barang';
	private $table_user = 'user';

    public $id_transaksi;
	public $id_barang;
    public $id_user;
    public $jumlah_pinjam;
	public $tgl_pinjam;
	public $jadwal_kembali;
	public $tgl_kembali;
	public $keterangan;
	public $status;

	public function __construct($db) {
		$this->conn = $db;
	}

	function insert() {
		$query = "INSERT INTO {$this->table_transaksi} VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_transaksi);
		$stmt->bindParam(2, $this->id_barang);
        $stmt->bindParam(3, $this->id_user);
        $stmt->bindParam(4, $this->jumlah_pinjam);
		$stmt->bindParam(5, $this->tgl_pinjam);
		$stmt->bindParam(6, $this->jadwal_kembali);
		$stmt->bindParam(7, $this->tgl_kembali);
		$stmt->bindParam(8, $this->keterangan);
		$stmt->bindParam(9, $this->status);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	function getNewID() {
		$query = "SELECT MAX(id_transaksi) AS code FROM {$this->table_transaksi}";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row) {
			return $this->genCode($row["code"], '');
		} else {
			return $this->genCode($nomor_terakhir, '');
		}
	}

	function genCode($latest, $key, $chars = 0) {
    $new = intval(substr($latest, strlen($key))) + 1;
    $numb = str_pad($new, $chars, "0", STR_PAD_LEFT);
    return $key . $numb;
	}

	function genNextCode($start, $key, $chars = 0) {
    $new = str_pad($start, $chars, "0", STR_PAD_LEFT);
    return $key . $new;
	}

	function readAll() {
		$query = "SELECT A.id_transaksi, A.id_barang, B.nama_barang, B.kategori, A.id_user, C.nama AS nama_user, A.jumlah_pinjam, A.tgl_pinjam, A.jadwal_kembali, A.tgl_kembali, A.keterangan, A.status FROM {$this->table_transaksi} A LEFT JOIN {$this->table_barang} B ON B.id_barang=A.id_barang LEFT JOIN {$this->table_user} C ON C.id_user=A.id_user ORDER BY tgl_pinjam DESC";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
	}

	function readAllUser() {
		$query = "SELECT A.id_transaksi, A.id_barang, B.nama_barang, B.kategori, A.id_user, C.nama AS nama_user, A.jumlah_pinjam, A.tgl_pinjam, A.jadwal_kembali, A.tgl_kembali, A.keterangan, A.status 
		FROM {$this->table_transaksi} A 
		LEFT JOIN {$this->table_barang} B ON B.id_barang=A.id_barang 
		LEFT JOIN {$this->table_user} C ON C.id_user=A.id_user 
		WHERE A.id_user=:id_user ORDER BY tgl_pinjam DESC";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(':id_user', $this->id_user);
		$stmt->execute();

		return $stmt;
	}

	function readOne() {
		$query = "SELECT * FROM {$this->table_transaksi} WHERE id_transaksi=:id_transaksi LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id_transaksi', $this->id_transaksi);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->id_transaksi = $row['id_transaksi'];
        $this->id_barang = $row['id_barang'];
        $this->id_user = $row['id_user'];
        $this->jumlah_pinjam = $row['jumlah_pinjam'];
		$this->tgl_pinjam = $row['tgl_pinjam'];
		$this->jadwal_kembali = $row['jadwal_kembali'];
		$this->tgl_kembali = $row['tgl_kembali'];
		$this->keterangan = $row['keterangan'];
		$this->status = $row['status'];
	}

	function update() {
		$query = "UPDATE {$this->table_transaksi}
			SET
                id_transaksi = :id_transaksi,
                id_barang = :id_barang,
                id_user = :id_user,
				jumlah_pinjam = :jumlah_pinjam,
				tgl_pinjam = :tgl_pinjam,
				jadwal_kembali = :jadwal_kembali,
				tgl_kembali = :tgl_kembali,
				keterangan = :keterangan,
				status = :status
			WHERE
				id_transaksi = :id";
        $stmt = $this->conn->prepare($query);

		$stmt->bindParam(':id_transaksi', $this->id_transaksi);
        $stmt->bindParam(':id_barang', $this->id_barang);
        $stmt->bindParam(':id_user', $this->id_user);
        $stmt->bindParam(':jumlah_pinjam', $this->jumlah_pinjam);
		$stmt->bindParam(':tgl_pinjam', $this->tgl_pinjam);
		$stmt->bindParam(':jadwal_kembali', $this->jadwal_kembali);
		$stmt->bindParam(':tgl_kembali', $this->tgl_kembali);
		$stmt->bindParam(':keterangan', $this->keterangan);
		$stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id_transaksi);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete() {
		$query = "DELETE FROM {$this->table_transaksi} WHERE id_transaksi = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id_transaksi);
		if ($result = $stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
}
