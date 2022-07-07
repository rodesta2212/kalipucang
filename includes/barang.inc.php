<?php
class Barang {
	private $conn;
    private $table_barang = 'barang';
	private $table_transaksi = 'transaksi';

    public $id_barang;
	public $nama_barang;
    public $kategori;
    public $stok_barang;
	public $tahun_input;

	public function __construct($db) {
		$this->conn = $db;
	}

	function insert() {
		$query = "INSERT INTO {$this->table_barang} VALUES(?, ?, ?, ?, ?)";

		$stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_barang);
		$stmt->bindParam(2, $this->nama_barang);
        $stmt->bindParam(3, $this->kategori);
        $stmt->bindParam(4, $this->stok_barang);
		$stmt->bindParam(5, $this->tahun_input);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	function getNewID() {
		$query = "SELECT MAX(id_barang) AS code FROM {$this->table_barang}";
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
		$query = "SELECT * FROM {$this->table_barang} ORDER BY nama_barang ASC";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
	}

	function readAllReady() {
		$query = "SELECT A.id_barang, A.nama_barang, A.kategori, A.stok_barang, 
		A.tahun_input, IF(B.total_pinjam>0, B.total_pinjam, 0) AS total_pinjam, 
		(stok_barang-IF(B.total_pinjam>0, B.total_pinjam, 0)) AS sisa_barang 
		FROM {$this->table_barang} A 
		LEFT JOIN ( SELECT id_transaksi, id_barang, 
		SUM(jumlah_pinjam) AS total_pinjam 
		FROM {$this->table_transaksi} 
		WHERE status != 'Selesai' AND status != 'Konfirmasi Peminjaman'
		GROUP BY id_barang ) B ON A.id_barang=B.id_barang";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
	}

	function readOne() {
		$query = "SELECT * FROM {$this->table_barang} WHERE id_barang=:id_barang LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id_barang', $this->id_barang);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->id_barang = $row['id_barang'];
        $this->nama_barang = $row['nama_barang'];
        $this->kategori = $row['kategori'];
        $this->stok_barang = $row['stok_barang'];
		$this->tahun_input = $row['tahun_input'];
	}

	function update() {
		$query = "UPDATE {$this->table_barang}
			SET
                id_barang = :id_barang,
                nama_barang = :nama_barang,
                kategori = :kategori,
				stok_barang = :stok_barang,
				tahun_input = :tahun_input
			WHERE
				id_barang = :id";
        $stmt = $this->conn->prepare($query);

		$stmt->bindParam(':id_barang', $this->id_barang);
        $stmt->bindParam(':nama_barang', $this->nama_barang);
        $stmt->bindParam(':kategori', $this->kategori);
        $stmt->bindParam(':stok_barang', $this->stok_barang);
		$stmt->bindParam(':tahun_input', $this->tahun_input);
        $stmt->bindParam(':id', $this->id_barang);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function updateStok() {
		$query = "UPDATE {$this->table_barang}
			SET
                id_barang = :id_barang,
				stok_barang = :stok_barang
			WHERE
				id_barang = :id_barang";
        $stmt = $this->conn->prepare($query);

		$stmt->bindParam(':id_barang', $this->id_barang);
        $stmt->bindParam(':stok_barang', $this->stok_barang);
        $stmt->bindParam(':id_barang', $this->id_barang);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete() {
		$query = "DELETE FROM {$this->table_barang} WHERE id_barang = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id_barang);
		if ($result = $stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
}
