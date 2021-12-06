<?php
class KepalaKeluarga {
	private $conn;
    private $table_kepala_keluarga = 'kepala_keluarga';
    private $table_user = 'user';

    public $id_kk;
    public $id_user;
	public $no_kk;
    public $alamat;
    public $no_no_telp;
	public $email;

	public function __construct($db) {
		$this->conn = $db;
	}

	function insert() {
		$query = "INSERT INTO {$this->table_kepala_keluarga} VALUES(?, ?, ?, ?, ?, ?)";

		$stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_kk);
        $stmt->bindParam(2, $this->id_user);
		$stmt->bindParam(3, $this->no_kk);
        $stmt->bindParam(4, $this->alamat);
        $stmt->bindParam(5, $this->no_telp);
		$stmt->bindParam(6, $this->email);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	function getNewID() {
		$query = "SELECT MAX(id_kk) AS code FROM {$this->table_kepala_keluarga}";
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
		$query = "SELECT A.id_kk, A.id_user, A.no_kk, B.nama, A.alamat, A.no_telp, A.email, B.username, B.password  FROM {$this->table_kepala_keluarga} A LEFT JOIN {$this->table_user} B ON A.id_user=B.id_user ORDER BY A.no_kk ASC";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
	}

	function readOne() {
		$query = "SELECT * FROM {$this->table_kepala_keluarga} WHERE id_kk=:id_kk LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id_kk', $this->id_kk);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->id_kk = $row['id_kk'];
        $this->no_kk = $row['no_kk'];
        $this->alamat = $row['alamat'];
        $this->no_telp = $row['no_telp'];
		$this->email = $row['email'];
	}

	function update() {
		$query = "UPDATE {$this->table_kepala_keluarga}
			SET
                id_kk = :id_kk,
                no_kk = :no_kk,
                alamat = :alamat,
				no_telp = :no_telp,
				email = :email
			WHERE
				id_kk = :id";
        $stmt = $this->conn->prepare($query);

		$stmt->bindParam(':id_kk', $this->id_kk);
        $stmt->bindParam(':no_kk', $this->no_kk);
        $stmt->bindParam(':alamat', $this->alamat);
        $stmt->bindParam(':no_telp', $this->no_telp);
		$stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id_kk);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete() {
		$query = "DELETE FROM {$this->table_kepala_keluarga} WHERE id_kk = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id_kk);
		if ($result = $stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
}
